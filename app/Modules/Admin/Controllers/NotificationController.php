<?php

namespace App\Modules\Admin\Controllers;

use DB;
use App\Adaptors\CommonAdaptor;
use App\Modules\Admin\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Enums\NotificationType;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\CannabisLog;
use App\Http\Controllers\Controller;
use App\Jobs\PushNotification;
use App\Modules\Admin\Models\CategoryProduct;
use App\Store;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::notification.index');
    }

    /**
     * Show the form for creating/updating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($id = null)
    {
        $data = '';
        if ($id) {
            $decryptedId = '';
            try {
                $decryptedId = decrypt($id);
            } catch (DecryptException $e) {
                abort(Response::HTTP_NOT_FOUND);
            }
            $data = Notification::find($decryptedId);
        }
        $notificationTypes = NotificationType::toArray();
        return view('Admin::notification.add', compact('data', 'notificationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $rules = [
                'title'             =>  'required',
                'notify_type'       =>  'required|numeric',
                'notify_type_id'    =>   Rule::requiredIf((NotificationType::Store_Detail === $request->notify_type || NotificationType::Product_Detail === $request->notify_type)),
                'platform'          =>  'required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return Redirect::back()->with('errors', $validation->errors())->withInput();
            }
            $data = [
                'title'             =>  request('title'),
                'notify_type'       =>  request('notify_type'),
                'notify_type_id'    =>  request('notify_type_id'),
                'description'       =>  request('description'),
                'url'               =>  request('thumbUrl'),
                'platform'          =>  request('platform'),
            ];
            $response = ['message' => trans('Admin::messages.error'), 'type' => 'error'];
            DB::transaction(function () use ($data, &$response) {
                $notification = Notification::create($data);
                PushNotification::dispatch($notification);
                $response['message'] = trans('Admin::messages.notification_created_success');
                $response['type']    = 'success';
            });
            return redirect()->route('admin.notification.index')->with($response);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function getNotifyData(Request $request)
    {
        //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);

        if (!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check

        $dataType = $request->get('data_type');
        $searchLike = $request->get('searchTerm');

        $data = $this->getDestinationPage($dataType, $searchLike);
        return (new Response($data, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param   $request dataType & searchLike string
     * @return  :collection
     */
    public function getDestinationPage($dataType,  $searchLike)
    {
        switch ($dataType) {

            case NotificationType::Store_Detail:
                $data = Store::join('store_details', 'store.id', '=', 'store_details.store_id')
                    ->where('is_profile_complete', true)
                    ->where('admin_action', 'approve')
                    ->where('is_admin_approved', true)
                    ->when($searchLike, function ($q, $searchLike) {
                        $q->whereHas('storeDetail', function ($query) use ($searchLike) {
                            $query->where(function ($query) use ($searchLike) {
                                $query->where('store_name', 'LIKE', '%' . $searchLike . '%');
                            });
                        });
                    })->limit(config('constants.SHOW_DESTINATION_PAGE_LIMIT'))->get(['store.id', 'store_name AS name']);
                break;
            default:
                $data = CategoryProduct::when(
                    $searchLike,
                    function ($query, $searchLike) {
                        $query->where('product_name', 'like', '%' . $searchLike . '%');
                    }
                )->limit(config('constants.SHOW_DESTINATION_PAGE_LIMIT'))->get(['id', 'product_name AS name']);
                break;
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
