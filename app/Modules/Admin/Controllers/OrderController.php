<?php


namespace App\Modules\Admin\Controllers;
use App\Models\Order;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\CannabisLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;



class OrderController extends Controller
{

    /**
     * show order list
     * @
     */
    public function index(Request $request)
    {
        // dd($request);
        $orderType  = $request->get('orderType', 'pending');
        $userId     = $request->get('userId', '');
        $storeId    = $request->get('storeId', '');
        $productId  = $request->get('product_id','');
        return view('Admin::order.filteredorderlist',compact('orderType','userId','storeId','productId'));
    }

    /**
     * to show order detail 
     * @request decrypt id
     * @return application/html
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
           $data = Order::with('user')->find($decryptId);
           if($data)
           {    
               $data->store_id= encrypt($data->order_data['cartListing'][0]['store_id']);
               $data->user_id= encrypt($data->order_data['cartListing'][0]['user_id']);
               $data->product_id= encrypt($data->order_data['cartListing'][0]['product_id']);
            //    dd($data);
               $tmpArray = [];
            collect($data->order_data['cartListing'])->map(function($item,$key) use (&$tmpArray)
               {
                   $tmpArray [] =[
                       's_no'               => ++$key,
                       'encrypt_product_id' => encrypt($item['product_id']),
                       'product_name'       => $item['product_name']??'--',
                       'category'           => $item['category_name']??'--',
                       'product_packing'    => $item['size'].' '.$item['size_unit'],
                       'quantity'           => $item['quantity']??0,
                       'price'              => $item['actual_price']??0,
                    //    'coupon_code'        => $item['product_name'],
                       'offered_price'      => $item['offered_price']?'$ '.$item['offered_price']:'--',
                   ];
                   return $tmpArray;
               });
               $data->products = $tmpArray;
            //    dd($data);
           }
           return view('Admin::order.show',compact('data'));
           
       } catch (QueryException $e) 
       {
           $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
           CannabisLog::create($response);  //inserting logs in the table
           return Redirect::back()->with(['message'=>trans('Admin::messages.error'),'type'=>'error']);
       }
    }
}