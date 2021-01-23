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

use function GuzzleHttp\json_decode;

class ProductController extends Controller
{


  /**
   * @desc product category
   */
  public function allProduct(Request $request)
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
        'page'      => $request->get('page'),
        'unique'    => 'product_id',
      ];

      $nearparams = [
        'longitude' => session()->get('userdetail')->lng,
        'latitude'  => session()->get('userdetail')->lat,
      ];

      $productCategory = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category

      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api

      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), $nearparams);   //categories api

      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');

      return view(
        'User::product.product-all',
        [
          'productCategory' => $productCategory['response']['data'],
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


  /**
   * @desc product category
   */
  public function trendingProduct(Request $request)
  {

    try {
      $query = Input::get();

      $category_id = (isset($request->category_id)) ? array_unique($request->get('category_id')) : "";
      $store_id    = $request->has('store_id') ? array_unique($request->get('store_id')) : "";
      $search = (isset($request->search)) ? $request->search : '';  //for the search

      $params = [
        'cannabis_type' => $category_id,
        'stock_availability' => $request->stock_availability ?? '',
        'sorting_id' => $request->sorting_id ?? '5',
        'longitude' => session()->get('userdetail')->lng,
        'latitude'  => session()->get('userdetail')->lat,
        'store_id'  => $store_id,
        'search'    => $search,
        'page'      => $request->get('page'),
        'unique'    => 'product_id',
      ];

      $query['sorting_id'] = (isset($request->sorting_id)) ? $request->sorting_id : 5;

      $productCategory = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category

      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api

      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), ['longitude' => session()->get('userdetail')->lng, 'latitude' => session()->get('userdetail')->lat]);   //categories api
      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');

      return view(
        'User::product.trending-product',
        [
          'productCategory' => $productCategory['response']['data'],
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


  /**
   * @desc product category
   */
  public function categoryProduct(Request $request)
  {

    try {
      $query = Input::get();

      $category_id = (isset($request->id) ? decrypt($request->id) : "");

      $store_id    = $request->has('store_id') ? array_unique($request->get('store_id')) : "";

      $params = [
        'cannabis_type' => $category_id,
        'stock_availability' => $request->stock_availability ?? '',
        'sorting_id' => $request->sorting_id ?? '',
        'store_id' => $store_id,
        'page'     =>  $request->get('page'),
        'unique' => 'product_id',
        'longitude' => session()->get('userdetail')->lng,
        'latitude'  => session()->get('userdetail')->lat,
      ];

      $nearparams = [
        'cannabis_type' => $category_id,
        'longitude' => session()->get('userdetail')->lng,
        'latitude'  => session()->get('userdetail')->lat,
      ];

      $productCategory = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category

      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), $nearparams);   //categories api
      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');

      return view(
        'User::product.category-product',
        [
          'productCategory' => $productCategory['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'addWishList' => $addWishList,
          'removewishlist' => $removeWishList,
          'category_id' => $category_id,
          'query' => $query,
          'userNearStore' => $userNearStore['response']['data'],
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }

  /**
   * @desc product category
   */
  public function productDetail(Request $request)
  {

    try {

      $query = Input::get();
      $product_id = decrypt($request->id);
      $store_id = $request->store_id ? decrypt($request->store_id) : "";

      $params = [
        'longitude' => session()->get('userdetail')->lng,
        'latitude' => session()->get('userdetail')->lat,
        'id' => $product_id,
        'store_id' => $store_id,
        'user_type' => 'web',
      ];

      $paramsSimilarProduct = [
        'longitude' => session()->get('userdetail')->lng,
        'latitude' => session()->get('userdetail')->lat,
        'product_id' => $product_id,
      ];

      $reviewParam = [
        'type' => 'product',
        'rated_id' => $product_id,
        'page' => $request->input('page', ''),
        'pagesize' => 5,
      ];



      $productDetail = $this->userClient->post(config('userconfig.ENDPOINTS.PRODUCT.DETAIL'), $params);  //product detail

      if (!empty($productDetail['response']['data']) && $productDetail['response']['data']['status'] == 'active') {
        $similarProduct = $this->userClient->post(config('userconfig.ENDPOINTS.PRODUCT.SIMILAR'), $paramsSimilarProduct);  //similar product detail

        $productReview = $this->userClient->get(config('userconfig.ENDPOINTS.STORE.RATING'), $reviewParam);  //trending product by category

        $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
        $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');
        $addBookMark = config('userconfig.ENDPOINTS.BOOKMARK.ADD');
        $removeBookMark = config('userconfig.ENDPOINTS.BOOKMARK.REMOVE');



        $first_product = reset($productDetail['response']['data']['currentstock']);
        $first_card_data = reset($productDetail['response']['data']['is_cartAdded_data']);

        if (empty($first_product['total_stock'])) {
          foreach ($productDetail['response']['data']['currentstock'] as $index => $val) {
            if ($val['total_stock'] != 0) {
              $first_product = $val;
              $first_card_data = $productDetail['response']['data']['is_cartAdded_data'][$val['id']];
              break;
            }
          }
        }


        return view(
          'User::product.detail',
          [
            'productDetail' => $productDetail['response']['data'],
            'token' => $this->userClient->header['Authorization'],
            'input' => $query,
            'similarProduct' => $similarProduct['response']['data'],
            'addWishList' => $addWishList,
            'removewishlist' => $removeWishList,
            'productReview' => $productReview['response']['data'],
            'addBookMark' => $addBookMark,
            'removeBookMark' => $removeBookMark,
            'first_product' => $first_product,
            'first_card_data' => $first_card_data,
          ]
        );
      } else {
        $response = ['code' => Response::HTTP_BAD_REQUEST, 'message' => trans('User::home.product_not_availbale')];
        return  Redirect::back()->with('success', $response);
      }
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }


  /**
   * @desc product wish list
   */
  /**
   * @desc product category
   */
  public function myWishList(Request $request)
  {

    try {
      $query = Input::get();
      $wishList = $this->userClient->get(config('userconfig.ENDPOINTS.WISHLIST'), []);  //trending product by category
      return view(
        'User::product.detail',
        [
          'wishList' => $wishList['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'input' => $query,
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }

  /**
   * addToCart
   * @param : request array
   * @return : application/json
   */

  public function addToCart(Request $request)
  {

    try {
      $params = [];
      $params['store_id'] = $request->get('store_id', '');
      $params['product_id'] = $request->get('product_id', '');
      $params['size'] = $request->get('size');
      $params['size_unit'] = $request->get('unit');

      $addToCartList = $this->userClient->post(config('userconfig.ENDPOINTS.ADD_CART'), $params);

      $http_response_header = [
        'code' => $addToCartList['code'],
        'message' => $addToCartList['response']['message']
      ];
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }

    //if user is coming from buy now button
    if ($request->input('is_buy') == config('constants.YES') && $addToCartList['code'] !== Response::HTTP_BAD_REQUEST) {
      $http_response_header = [
        'code' => $addToCartList['code'],
        'message' => $addToCartList['response']['message']
      ];

      return redirect()->route('user.show.cart.list')->with('success', $http_response_header);
    }

    if ($http_response_header['message'] == config('constants.SINGLE_STORE_RULE_MSG')) {
      $params['is_buy'] = $request->input('is_buy');
      session(['addAndClearData' => json_encode($params)]);
    }

    return Redirect::back()->with(['success' => $http_response_header]);
  }


  /**
   * @desc clear card and add function
   *
   * @param Request $request
   * @return void
   */
  public function clearCardAdd(Request $request)
  {
    try {

      if ($request->session()->has('addAndClearData')) {
        $clearCard = session('addAndClearData');
        $clearData = json_decode($clearCard);
      }

      $request->session()->forget('addAndClearData');   //forgot session 

      $params = [];
      $params['store_id'] = $clearData->store_id;
      $params['product_id'] = $clearData->product_id;
      $params['size'] = $clearData->size;
      $params['size_unit'] = $clearData->size_unit;

      $addToCartList = $this->userClient->post(config('userconfig.ENDPOINTS.CLEAR_CART_ADD'), $params);  //clear cart data and add to cart data

      $http_response_header = [
        'code' => $addToCartList['code'],
        'message' => $addToCartList['response']['message']
      ];
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }

    //if user is coming from buy now button
    if ($clearData->is_buy == config('constants.YES')) {
      $http_response_header = [
        'code' => $addToCartList['code'],
        'message' => $addToCartList['response']['message']
      ];

      return redirect()->route('user.show.cart.list')->with('success', $http_response_header);
    }

    return Redirect::back()->with(['success' => $http_response_header]);
  }
  /**
   * @desc get near by store
   */
  public function productNearStore(Request $request)
  {
    try {
      $query = Input::get();

      $product_id = decrypt($request->product_id);
      $search = (isset($request->search) && !empty($request->search)) ? $request->search : '';
      $category_id = (isset($request->category_id)) ? array_unique($request->get('category_id')) : "";
      $is_open = $request->is_open;
      $params = [
        'longitude' => session()->get('userdetail')->lng,
        'latitude' => session()->get('userdetail')->lat,
        'search' => $search,
        'page' =>    $request->get('page'),
        'category_id' => $category_id,
        'product_id' => $product_id,
        'is_open' => $is_open,
      ];

      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), $params);   //near by store api
      $addBookMark = config('userconfig.ENDPOINTS.BOOKMARK.ADD');
      $removeBookMark = config('userconfig.ENDPOINTS.BOOKMARK.REMOVE');

      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'));   //categories api


      return view(
        'User::product.product-near-store',
        [
          'userNearStore'  => $userNearStore['response']['data'],
          'query'          => $query,
          'addBookMark'    => $addBookMark,
          'removeBookMark' => $removeBookMark,
          'token'          => $this->userClient->header['Authorization'],
          'categories' => $categories['response'],
          'product_id'     => $product_id,
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }
}
