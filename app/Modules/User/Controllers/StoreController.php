<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use App\Modules\User\Models\UserDetail;
use Illuminate\Support\Facades\Log;


class StoreController extends Controller
{

  /**
   * index
   * @param : null
   * @return : application/html
   */

  public function index(Request $request)
  {

       
    try {
      $query = Input::get();
      $user = Auth::guard("users")->user();
      $userDetail = UserDetail::where('user_id', $user->id)->first();
      $search = (isset($request->search) && !empty($request->search)) ? $request->search : '';
     
      $category_id = (isset($request->category_id)) ? array_unique($request->get('category_id')) : "";

      $is_open = $request->is_open;
      $rating=$request->rating;
      $params = [
        'longitude' => $userDetail->lng,
        'latitude' => $userDetail->lat,
        'search' => $search,
        'page' => $request->get('page'),
        'category_id' => $category_id,
        'is_open' => $is_open,
        'rating' =>$rating,
      ];
      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), $params);   //near by store api
    
      $addBookMark = config('userconfig.ENDPOINTS.BOOKMARK.ADD');
      $removeBookMark = config('userconfig.ENDPOINTS.BOOKMARK.REMOVE');
      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api
     
      return view(
        'User::store.index',
        [
          'userNearStore' => $userNearStore['response']['data'],
          'query' => $query,
          'addBookMark' => $addBookMark,
          'removeBookMark' => $removeBookMark,
          'token' => $this->userClient->header['Authorization'],
          'categories' => $categories['response'],
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }

  /**
   * @desc show store on the map
   */
  public function storeMap(Request $request)
  {

    try {
      $query = Input::get();
      $user = Auth::guard("users")->user();
      $userDetail = UserDetail::where('user_id', $user->id)->first();
      $search = (isset($request->search) && !empty($request->search)) ? $request->search : '';
      $category_id = (isset($request->category) && !empty($request->category)) ? $request->category : '';  //category filter
    
      $is_open = $request->is_open;
      $rating=$request->rating;
      $params = [
        'longitude' => $userDetail->lng,
        'latitude' => $userDetail->lat,
        'search' => $search,
        'page' => $request->get('page'),
        'category_id' => $category_id,
        'is_open' => $is_open,
        'rating' =>$rating,
      ];

      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), $params);   //near by store api
     
      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api
      $addBookMark = config('userconfig.ENDPOINTS.BOOKMARK.ADD');
      $removeBookMark = config('userconfig.ENDPOINTS.BOOKMARK.REMOVE');
      return view(
        'User::store.store-map',
        [
          'userNearStore' => $userNearStore['response']['data'],
          'query' => $query,
          'userDetail' => $userDetail,
          'categories' => $categories['response'],
          'addBookMark' => $addBookMark,
          'removeBookMark' => $removeBookMark,
          'token' => $this->userClient->header['Authorization'],
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }



  /**
   * @desc product category
   */
  public function storeDetail(Request $request)
  {

    try {
      $query = Input::get();
      $user = Auth::guard("users")->user();
      $store_id = decrypt($request->id);
      $userDetail = UserDetail::where('user_id', $user->id)->first();
      $storeDetail = $this->userClient->get(config('userconfig.ENDPOINTS.STORE.DETAIL') . '/' . $store_id);  //store detail
      
      if($storeDetail['code']==Response::HTTP_BAD_REQUEST && is_null($storeDetail['response']['data'])){
        $response = ['code' =>Response::HTTP_BAD_REQUEST, 'message' => trans('User::home.store_not_availbale')];

       return  Redirect::back()->with('success', $response);
      }
      
      return view(
        'User::store.detail',
        [
          'storeDetail' => $storeDetail['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'input' => $query,
          'userDetail' => $userDetail,
        ]
      );
    } catch (Exception $e) {
      $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
      Log::error(trans('User::home.error_processing_request'), $errors);
      abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  /**
   * @desc product category
   */
  public function storeProduct(Request $request)
  {
     
    try {
      $query = Input::get();
      $user = Auth::guard("users")->user();
      $store_id = decrypt($request->id);
      $search = (isset($request->search)) ? $request->search : '';  //for the search 
      $category_id = (isset($request->category_id)) ? array_unique($request->get('category_id')) : "";

     
      $params = [
        'store_id' => $store_id,
        'sorting_id' => $request->sorting_id ?? '',
        'stock_availability' => $request->stock_availability ?? '',
        'search' => $search,
        'cannabis_type' => $category_id,
        'page' =>$request->input('page',''),
      ];
    
      $userDetail = UserDetail::where('user_id', $user->id)->first();
      $storeProduct = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category
      $storeDetail = $this->userClient->get(config('userconfig.ENDPOINTS.STORE.DETAIL') . '/' . $store_id);  //product detail
      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api

      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');
      return view(
        'User::store.store-product',
        [
          'storeProduct' => $storeProduct['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'query' => $query,
          'userDetail' => $userDetail,
          'addWishList' => $addWishList,
          'removewishlist' => $removeWishList,
          'category_id' => $category_id,
          'store_id' => $store_id,
          'storeDetail' => $storeDetail['response']['data'],
          'categories' => $categories['response'],
        ]
      );
    } catch (Exception $e) {
      $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
      Log::error(trans('User::home.error_processing_request'), $errors);
      abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * @desc product category
   */
  public function storeProductReview(Request $request)
  {

    try {
      $query = Input::get();
      $user = Auth::guard("users")->user();
      $store_id = decrypt($request->id);
      $search = (isset($request->search)) ? $request->search : '';  //for the search 
      $params = [
        'store_id' => $store_id,
        'sorting_id' => $request->sorting_id ?? '',
        'stock_availability' => $request->stock_availability ?? '',
        'search' => $search,
      ];
      $category_id = $request->has('category_id') ? current($request->get('category_id')) : "";
      $userDetail = UserDetail::where('user_id', $user->id)->first();
      $storeProduct = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category
      $storeDetail = $this->userClient->get(config('userconfig.ENDPOINTS.STORE.DETAIL') . '/' . $store_id);  //product detail
     
      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');
      
      $reviewParam=[
        'type'=>'store',
        'rated_id'=>$store_id,
        'page'=>$request->input('page',''),
        'pagesize'=>5,
      ];

      $storeReview = $this->userClient->get(config('userconfig.ENDPOINTS.STORE.RATING'), $reviewParam);  //trending product by category

      return view(
        'User::store.store-review',
        [
          'storeProduct'  => $storeProduct['response']['data'],
          'token'         => $this->userClient->header['Authorization'],
          'query'         => $query,
          'userDetail'    => $userDetail,
          'addWishList'   => $addWishList,
          'removewishlist'=> $removeWishList,
          'category_id'   => $category_id,
          'storeDetail'   => $storeDetail['response']['data'],
          'productReview' => $storeReview['response']['data'],
        ]
      );
    } catch (Exception $e) {
      $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
      Log::error(trans('User::home.error_processing_request'), $errors);
      abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
