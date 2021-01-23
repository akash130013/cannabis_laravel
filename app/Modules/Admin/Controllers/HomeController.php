<?php


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\StoreEarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\Order;
use App\Modules\Store\Models\User;
use App\Store;
use stdClass;

class HomeController extends Controller
{

    /**
     * @param : null
     * @return : application/html
     * 
     */

    function index() {

      $route_name=app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
      if($route_name=='admin.password.reset'){  //redirecting to the login page of the user
       Auth::guard('admin')->logout();
       $http_response_header = ['type' => Response::HTTP_OK, 'message' => trans('Store::home.passwordResetSuccess')];
       return redirect()->route('admin.login')->with('success', $http_response_header);
      } 
      $data = new stdClass;
      $data->userCount            = User::where('is_profile_complete',true)->count();
      $data->driverCount          = Distributor::count();
      $data->orderCount           = Order::whereIn('order_status',['delivered','amount_received'])->count();
      $data->productCount         = CategoryProduct::count();
      $data->paymentCount         = StoreEarning::where('status','closed')->count();
      $data->requestedStoretCount = Store::where('is_profile_complete', true)
                                    ->whereIn('admin_action', [config('constants.STATUS.PENDING'), config('constants.STATUS.REJECT')])
                                    ->where('is_admin_approved', false)->count();
      
      
      return view("Admin::dashboard.index",compact('data'));
    }

     public function productDetails()
     {
        return view('Admin::product.product-details');
     }

    
}