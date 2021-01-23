<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;


class WishListController extends Controller
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

      $params = [
        'page' => $request->input('page', ''),
      ];

      $wishList = $this->userClient->get(config('userconfig.ENDPOINTS.WISHLIST'), $params);  // wish list 

      return view(
        'User::wishlist.index',
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
   * removeFromWishList
   * @param : id
   * @return : return with success or failure
   */

  public function updateWishList(Request $request)
  {

    try {
      $productId = $request->get('product_id');
      $isWishListed = $request->get('is_wishlisted');

      if (empty($productId)) {
        throw new Exception(trans('User::home.product_id_missing'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      switch ($isWishListed) {

        case true:
          $http_response_header = $this->removeFromWishList($productId);
          break;

        case false:
          $http_response_header = $this->addFromWishList($productId);

          break;
      }

      $removeFromCart = $request->get('is_cart_remove', '');
      if ($removeFromCart) {
        $cartUid = $request->get('cartUid', '');
        $this->removeFromCart($cartUid);
      }

      $http_response_header = [
        'code' => $http_response_header['code'],
        'message' => $http_response_header['response']['message']
      ];
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
    return Redirect::back()->with('success', $http_response_header);
  }




  /**
   * removeFromWishList
   * @param : null
   * @return : application/html
   */

  protected function removeFromWishList($id)
  {

    $endpoint = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');
    return $this->userClient->get(url('/') . $endpoint . '/' . $id);
  }


  /**
   * addFromWishList
   * @param : null
   * @return : application/html
   */

  protected function addFromWishList($id)
  {

    $endpoint = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
    return $this->userClient->get(url('/') . $endpoint . '/' . $id);
  }

  /**
   * removeFromCart
   * @param : product id
   * @return : reponse
   */

  protected function removeFromCart($id)
  {
    $endpoint = config('userconfig.ENDPOINTS.REMOVE_CART');
    return $this->userClient->get(url('/') . $endpoint . '/' . $id);
  }


  /**
   * To show bookmark list using API
   * @request : Request
   * @return : html/json
   * 
   * 
   */

  public function bookmarkList(Request $request)
  {
    try {
      $query = Input::get();
      $params = [
        'page' => $request->input('page', ''),
      ];
      $bookmarks = $this->userClient->get(config('userconfig.ENDPOINTS.BOOKMARK.INDEX'), $params);  // wish list 
      return view(
        'User::wishlist.bookmark-index',
        [
          'bookmarks' => $bookmarks['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'input' => $query,
        ]
      );
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }
}
