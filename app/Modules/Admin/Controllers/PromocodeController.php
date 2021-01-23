<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Admin\Models\CategoryProductImages;
use App\Modules\Store\Models\StoreProductStock;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\PromoCode as PromocodeModel;
use App\Rules\ValidateCoupon;
use DB;


class PromocodeController extends Controller
{
    /**
     * index
     * @param : null
     * @return : application/html
     */

    public function index()
    {

        return view('Admin::promocode.index');
    }

    /**
     * @show  create or update promocode screen
     * @date 06/11/19
     *      * 
     */
    public function add($id = null)
    {
        $data ='';
        if ($id) {
            $decryptedId = '';
            try {
                $decryptedId = decrypt($id);
            } catch (DecryptException $e) {
                abort(Response::HTTP_NOT_FOUND);
            }
            $data = PromocodeModel::find($decryptedId);
        }

        return view('Admin::promocode.create', compact('data'));
    }

    /**
     * It will validate create and update promocode request
     * @param request 
     * @return array 
     */

    public function validate_data(Request $request)
    {
        
        $rules = [
            'promo_name'                => 'required|max:150',
            'max_cap'                   => Rule::requiredIf('percentage' === $request->promotional_type),
            'promotional_type'          => 'required',
            'amount'                    => 'required',
            'total_coupon'              => ['required', new ValidateCoupon],
            'min_amount'                => 'required',
            'max_redemption_per_user'   => 'required',
            'start_time'                => 'required',
            'end_time'                  => 'required|after:start_time',
            'offer_status'              => 'required',
        ];
        $rules['coupon_code']  = 'required|unique:promo_codes';
        if ('percentage' === $request->promotional_type) {
            $rules['amount']  = 'required|numeric|max:100';
        } else {
            $rules['amount']  = 'required|numeric|lte:min_amount';
        }
        if ($request->promocode_id != '') {
            $rules['coupon_code']  = 'required|unique:promo_codes,id,' . $request->promocode_id;
        }
        
        $msg=[
          'total_coupon.max' =>'Total Coupon can not less than Used Coupon Or Invalid total coupon',
        ];

        $validation = Validator::make($request->all(), $rules,$msg);
        if ($validation->fails()) {
            return ['status' => false, 'message' => $validation->errors()];
        }
        return ['status' => true, 'message' => 'OK'];
    }

    /**
     * store Promocodes
     * @param : post params 
     * @return : redirect back with error & on success redirect to list screen
     */

    public function store(Request $request)
    {
       
        $validateStatus = $this->validate_data($request);
        if (!$validateStatus['status']) {
            return Redirect::back()->with('errors', $validateStatus['message'])->withInput();
        }
       
        try {
            $data = [
                'promo_name'                => $request->promo_name,
                'description'               => $request->description,
                'promotional_type'          => $request->promotional_type,
                'amount'                    => $request->amount,
                'total_coupon'              => $request->total_coupon,
                'min_amount'                => $request->min_amount,
                'max_redemption_per_user'   => $request->max_redemption_per_user,
                'start_time'                => $request->start_time,
                'end_time'                  => $request->end_time,
                'offer_status'              => $request->offer_status,
            ];

            $data['max_cap']  = $request->amount;

            if ($request->promotional_type == 'percentage') {
                $data['max_cap']  =  $request->max_cap;
            }

            $message = '';
            DB::transaction(function () use ($request, $data, &$message) {
                if ($request->promocode_id) {  //at the time of update

                    $promocode          = PromocodeModel::find($request->promocode_id);
                    if($promocode->total_coupon>$request->total_coupon){
                       
                        $data['coupon_remained']=$promocode->coupon_remained-($promocode->total_coupon-$request->total_coupon);
                    }
                   
                    if($promocode->total_coupon<$request->total_coupon){
                       
                        $data['coupon_remained']=$request->total_coupon-$promocode->total_coupon+$promocode->coupon_remained;
                    }
                  
                    $updatedPromocode   = $promocode->update($data);
                    $message            = trans('Admin::messages.promocode_update_success');
                } else {    //create new record
                    $data['coupon_code']   = $request->coupon_code;
                    $data['coupon_remained']   = $request->total_coupon;
                    $updateStatus           = PromocodeModel::create($data);
                    $message                = trans('Admin::messages.promocode_create_success');
                }
            });

            return redirect()->route('admin.promocode.index')->with(['message' => $message, 'type' => 'success']);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }
    }


    /**
     * show promocode detail screen
     * @param : get ID
     * @show promocode detail screen
     */

    public function show($id)
    {
        try {
            try {
                $decryptedId = decrypt($id);
            } catch (DecryptException $e) {
                abort(Response::HTTP_NOT_FOUND);
            }
            $decryptId  = decrypt($id);
            $data       = PromocodeModel::withCount('redeemedUsers')->find($decryptId);
            if ($data) {
                $data->promocode_id = encrypt($data->id);
                return view('Admin::promocode.show', compact('data'));
            }
            abort(Response::HTTP_NOT_FOUND);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }
    }
}
