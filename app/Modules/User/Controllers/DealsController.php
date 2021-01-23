<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;



class DealsController extends Controller
{

  /**
   * @desc show listing of deals page
   *@param Request
   */

  public function index(Request $request)
  {

    try {
      $query = Input::get();

      $category_id = (isset($request->category_id)) ? array_unique($request->get('category_id')) : "";
      $store_id    = $request->has('store_id') ? array_unique($request->get('store_id')) : "";
      $search = (isset($request->search)) ? $request->search : '';  //for the search 

      $params = [
        'cannabis_type' => $category_id,
        'stock_availability' => $request->stock_availability ?? '',
        'sorting_id' => $request->sorting_id ?? '',
        'longitude' => session()->get('userdetail')->lng,
        'latitude'  => session()->get('userdetail')->lat,
        'store_id'  => $store_id,
        'search'    => $search,
        'page'      =>  $request->get('page'),
        'unique'    =>  'product_id',
        'dealonly'  => true,
      ];



      $productwithDeals = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category

      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api
      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), ['longitude' => session()->get('userdetail')->lng, 'latitude' => session()->get('userdetail')->lat]);   //categories api
      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');

      return view(
        'User::deals.product-deals',
        [
          'productwithDeals' => $productwithDeals['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'addWishList' => $addWishList,
          'removewishlist' => $removeWishList,
          'categories' => $categories['response'],
          'query' => $query,
          'userNearStore' => $userNearStore['response']['data'],
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }
}
