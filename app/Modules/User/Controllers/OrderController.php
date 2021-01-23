<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;



class OrderController extends Controller
{

  /**
   * index
   * @param : null

   */

  public function index(Request $request)
  {
    try {

      $query = Input::get();

      if (empty($query)) {
        $query['type'] = '';
      }

      $param = [
        'type' => $request->input('type', ''),
        'page' =>  $request->input('page'),
      ];

      $orderList = $this->userClient->get(config('userconfig.ENDPOINTS.ORDER.LIST'), $param);

      return view('User::order.index', compact('orderList', 'query'));
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }



  /**
   * @desc user submit rating request
   *
   * @param Request $request
   * @return void
   */
  public function submitRating(Request $request)
  {

    try {
      $params = $request->jsonArr;

      $ratingdata = $this->userClient->post(config('userconfig.ENDPOINTS.ORDER.RATING'), $params);

      $reponse = [
        'code' => Response::HTTP_OK,
        'message' => trans('User::home.success'),
        'data' => $ratingdata['response']['data'],
      ];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($reponse);
  }

  /****
   * @desc Function to cancel the order
   *@request : orderuid
   * @response : application/json
   */
  public function cancelOrder(Request $request)
  {
    try {
      $params = ["order_uid" => $request->order_uid];
      $canceldata = $this->userClient->post(config('userconfig.ENDPOINTS.ORDER.CANCEL'), $params);
      $reponse = [
        'code' => Response::HTTP_OK,
        'message' => $canceldata['response']['message'],
        'data' => $canceldata['response']['data'],
      ];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($reponse);
  }


  /****
   * @desc Function to re the order
   *@request : orderuid
   * @response : application/json
   */
  public function reOrder(Request $request)
  {
    try {
      $params = ["order_uid" => $request->order_uid];
      $ratingdata = $this->userClient->post(config('userconfig.ENDPOINTS.ORDER.REORDER'), $params);
      $reponse = [
        'code' => Response::HTTP_OK,
        'message' => $ratingdata['response']['message'],
        'data' => $ratingdata['response']['data'],
      ];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($reponse);
  }


  /****
   * @desc Function to re the order
   *@request : orderuid
   * @response : application/json
   */
  public function trackMyOrder(Request $request)
  {
    try {
      $trackorderData = $this->userClient->get(config('userconfig.ENDPOINTS.ORDER.TRACK') . '/' . $request->order_uid);
      $reponse = [
        'code' => Response::HTTP_OK,
        'message' => trans('User::home.success'),
        'data' => $trackorderData['response']['data'],
      ];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($reponse);
  }
}
