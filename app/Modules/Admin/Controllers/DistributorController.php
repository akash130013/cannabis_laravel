<?php


namespace App\Modules\Admin\Controllers;
use App\Models\Distributor;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Modules\Admin\Models\CannabisLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;



class DistributorController extends Controller
{

    /**
     * index
     * @param : null
     * @return : application/html
     */

    public function index(Request $request)
    {
        $storeId = $request->get('storeId', '');
        return view('Admin::distributor.index',compact('storeId'));
    }

    /**
     * @param :distributor encrypted id
     * @return :html
     */

    public function show($id)
    {
       try 
       {
           try {
               $decryptId = decrypt($id);
           } catch (QueryException $e) {
               abort(Response::HTTP_NOT_FOUND);
           }
           $data = Distributor::with('proofs')->withCount(['orders'])
                    ->find($decryptId);
           if($data)
           {
               if($data->orders_count != 0)
               {
                    $data->load('completedOrders');
               }
               else{
                   $data->completed_orders_count = 0;
               }
               $data->distributor_decrypt_id = $id;
               $data->profile_image = $data->profile_image ?? config('constants.DEAFULT_IMAGE.DRIVER_IMAGE');
               return view('Admin::distributor.show',compact('data'));
           }
           abort(Response::HTTP_NOT_FOUND);
       } catch (QueryException $e) 
       {
           $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
           CannabisLog::create($response);  //inserting logs in the table
           return Redirect::back()->with(['message'=>trans('Admin::messages.error'),'type'=>'error']);
       }
      


    }

    /**
     * function is to show edit screen 
     *
     * @param [int] $id (optional)
     * @return : application/html
     */
    public function edit($id = null)
    {
        $data='';
        if($id)
        {
            $decryptedId = '';
            try 
            {
              $decryptedId = decrypt($id);
            } 
            catch (DecryptException $e) 
            {
                abort(Response::HTTP_NOT_FOUND);
            }
            $data= Distributor::find($decryptedId);
        }
        return view('Admin::distributor.edit',compact('data'));
    }
    

    public function update(Request $request,$id)
    {
        try {
                $data = [
                    'content' => $request->content,
                ];
                DB::transaction(function () use ($data,$id){
                    $staticPage = StaticPage::find($id);
                    $staticPage->update($data);
                });
                return redirect()->route('admin.cms.index')
                        ->with(['message' => trans('Admin::messages.cms_update_success'), 'type' => 'success']);
    
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with($response);
        }

    }
    
}