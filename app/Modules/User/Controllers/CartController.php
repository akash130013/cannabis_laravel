<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Response;
use App\Modules\User\Models\UserDeliveryLocation;


class CartController extends Controller
{

    /**
     * index
     * @param : null
     * @return : application/html
     */

    public function index()
    {

        try {

            $cartListing = $this->userClient->get(config('userconfig.ENDPOINTS.CART_LIST'));

            $couponList  = $this->userClient->get(config('userconfig.ENDPOINTS.PROMO_CODE_LIST'));

            $cartList = empty($cartListing['response']['data']['cartListing']) ? [] : $cartListing['response']['data']['cartListing'];

            $summary = empty($cartListing['response']['data']['cartSummary']) ? [] : $cartListing['response']['data']['cartSummary'];

            $couponList = empty($couponList['response']['data']) ? [] : $couponList['response']['data'];

            $totalItems =  empty($cartListing['response']['data']['itemCount']) ? 0 : $cartListing['response']['data']['itemCount'];

            $orderId = empty($cartListing['response']['data']['order_uid']) ? "" : $cartListing['response']['data']['order_uid'];

            $summaryTotal = empty($cartListing['response']['data']['total']) ? "" : $cartListing['response']['data']['total'];

            return view('User::cart.index', [
                'cartList' => $cartList,
                'summary' => $summary,
                'coupons' => $couponList,
                'items' => $totalItems,
                'orderId' => $orderId,
                'total' => $summaryTotal,
                'token' => $this->userClient->header['Authorization'],
            ]);
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }
    }

    /**
     * addDeliveryAddress
     * @param : null
     * @return : application/html
     */

    public function addDeliveryAddress()
    {
        return view('User::cart.add-address');
    }

    /**
     * placeOrder
     * @param : null
     * @return : application/html
     */

    public function placeOrder()
    {
        return view('User::cart.place-order');
    }


    /**
     * removeFromCart
     * @param : product id
     * @return : reponse
     */

    protected function removeFromCart(Request $request)
    {
        try {

            $endpoint = config('userconfig.ENDPOINTS.REMOVE_CART');

            $id = $request->get('id');

            $http_response_header =  $this->userClient->get(url('/') . $endpoint . '/' . $id);

            $http_response_header = ['code' => $http_response_header['code'], 'message' => $http_response_header['response']['message']];
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }

        return Redirect::back()->with('success', $http_response_header);
    }



    /**
     * validatePromoCode
     * @return : Redirect back with success or failure
     * @param : promo code
     */
    public function validatePromoCode(Request $request)
    {
        try {

            $promoCode = $request->get('promo_code');

            $orderUid = $request->get('id');

            if (empty($promoCode)) {
                throw new Exception(trans('User::home.promo_code_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (empty($orderUid)) {
                throw new Exception(trans('User::home.order_uid_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }


            $params = [];
            $params['order_uid'] = $orderUid;
            $params['coupon_code'] = $promoCode;

            $response = $this->userClient->post(config('userconfig.ENDPOINTS.APPLY_PROMO_CODE'), $params);

            $http_response_header = ['code' => $response['code'], 'message' => $response['response']['message']];
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }

        return response()->json($http_response_header);
    }


    /**
     * removeCouponCode
     * @param : coupon code
     * @return : return back with success or failure
     */

    public function removeCouponCode(Request $request)
    {

        try {

            $promoCode = $request->get('promo_code');

            $orderUid = $request->get('id');

            if (empty($promoCode)) {
                throw new Exception(trans('User::home.promo_code_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if (empty($orderUid)) {
                throw new Exception(trans('User::home.order_uid_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $params = [];
            $params['order_uid'] = $orderUid;
            $params['coupon_code'] = $promoCode;

            $result = $this->userClient->post(config('userconfig.ENDPOINTS.REMOVE_PROMO_CODE'), $params);

            $response = ['code' => $result['code'], 'message' => $result['response']['message']];
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }

        return Redirect::back()->with('success', $response);
    }

    /**
     * updateItem
     * @param : quantity and cartId
     * @return : redirect back with success and failure
     */

    public function updateQuantityItem(Request $request)
    {

        try {

            $cartId     = $request->get('cart_uid');
            $quantity   = $request->get('quantity');
            $size       = $request->get('size');
            $size_unit  = $request->get('size_unit');

            if (empty($cartId)) {
                throw new Exception(trans('User::home.cart_id_field_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (empty($quantity)) {
                throw new Exception(trans('User::home.quantity_field_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $params = [];
            $params['cart_uid']     = $cartId;
            $params['quantity']     = $quantity;
            $params['size_unit']    = $size_unit;
            $params['size']         = $size;

            $result = $this->userClient->post(config('userconfig.ENDPOINTS.UPDATE_QTY_PROMO_CODE'), $params);
            $response = ['code' => $result['code'], 'message' => $result['response']['message']];
        } catch (Exception $e) {
            return CommonHelper::catchException($e);
        }

        return json_encode($response);
    }




    /***
     * @desc use loyality point
     * @param $request
     */
    public function useLoyaltyPoint(Request $request)
    {

        try {

            $orderId = $request->get('orderId', '');
            $is_redeam = $request->get('is_redeam', '');

            if (empty($orderId) || empty($is_redeam)) {
                throw new Exception(trans('User::home.failed_to_process_request'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $params = [];
            $params['order_uid'] = $orderId;

            if ($request->get('is_redeam') == config('constants.YES')) {
                $apiResult = $this->userClient->post(config('userconfig.ENDPOINTS.LOYALITY_POINT.REDEAM'), $params);
            } else {
                $apiResult = $this->userClient->post(config('userconfig.ENDPOINTS.LOYALITY_POINT.REMOVE'), $params);
            }


            if ($apiResult['code'] == Response::HTTP_BAD_REQUEST) {

                throw new Exception($apiResult['response']['message'], Response::HTTP_BAD_REQUEST);
            }
            //**cart data for update */

            $response = ['code' => $apiResult['code'], 'message' => $apiResult['response']['message']];
        } catch (Exception $e) {
            return CommonHelper::catchException($e);
        }

        return json_encode($response);
    }
    /**
     * showDeliveryAddress
     * @param : null
     * @return : application/html
     */

    public function showDeliveryAddress()
    {

        try {

            $cartListing = $this->userClient->get(config('userconfig.ENDPOINTS.CART_LIST'));

            $couponList  = $this->userClient->get(config('userconfig.ENDPOINTS.PROMO_CODE_LIST'));

            $userId = Auth::guard('users')->user()->id;

            $cartList = empty($cartListing['response']['data']['cartListing']) ? [] : $cartListing['response']['data']['cartListing'];

            $summary = empty($cartListing['response']['data']['cartSummary']) ? [] : $cartListing['response']['data']['cartSummary'];

            $couponList = empty($couponList['response']['data']) ? [] : $couponList['response']['data'];

            $totalItems =  empty($cartListing['response']['data']['itemCount']) ? 0 : $cartListing['response']['data']['itemCount'];

            $orderId = empty($cartListing['response']['data']['order_uid']) ? "" : $cartListing['response']['data']['order_uid'];

            $summaryTotal = empty($cartListing['response']['data']['total']) ? "" : $cartListing['response']['data']['total'];

            $userDeliveryAddress = UserDeliveryLocation::where('user_id', $userId)->get();


            return view('User::cart.show-address', [
                'cartList' => $cartList, 'summary' => $summary, 'deliveryAddress' => $userDeliveryAddress,
                'coupons' => $couponList, 'items' => $totalItems, 'orderId' => $orderId, 'total' => $summaryTotal
            ]);
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }
    }


    /**
     * showAddDeliveryLocation
     * @param : null
     * @return : application/html
     */

    public function showAddDeliveryLocation()
    {

        try {
            $cartListing = $this->userClient->get(config('userconfig.ENDPOINTS.CART_LIST'));

            $couponList  = $this->userClient->get(config('userconfig.ENDPOINTS.PROMO_CODE_LIST'));

            $userId = Auth::guard('users')->user()->id;

            $cartList = empty($cartListing['response']['data']['cartListing']) ? [] : $cartListing['response']['data']['cartListing'];

            $summary = empty($cartListing['response']['data']['cartSummary']) ? [] : $cartListing['response']['data']['cartSummary'];

            $couponList = empty($couponList['response']['data']) ? [] : $couponList['response']['data'];

            $totalItems =  empty($cartListing['response']['data']['itemCount']) ? 0 : $cartListing['response']['data']['itemCount'];

            $orderId = empty($cartListing['response']['data']['order_uid']) ? "" : $cartListing['response']['data']['order_uid'];

            $summaryTotal = empty($cartListing['response']['data']['total']) ? "" : $cartListing['response']['data']['total'];

            $userDeliveryAddress = UserDeliveryLocation::where('user_id', $userId)->get();

            return view('User::cart.add-address', [
                'cartList' => $cartList, 'summary' => $summary, 'deliveryAddress' => $userDeliveryAddress,
                'coupons' => $couponList, 'items' => $totalItems, 'orderId' => $orderId, 'total' => $summaryTotal
            ]);
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }
    }

    /**
     * showFinalDeliveryConfirmation
     * @param : Request
     * @return : application/html
     */

    public function showFinalDeliveryConfirmation(Request $request)
    {

        try {

            $orderId = $request->get('order_id', '');
            $addressId = $request->get('address_id', '');

            if (empty($orderId) || empty($addressId)) {
                throw new Exception(trans('User::home.failed_to_process_request'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $params = [];
            $params['order_uid'] = $orderId;
            $params['address_id'] = $addressId;

            $apiResult = $this->userClient->post(config('userconfig.ENDPOINTS.ADD_DELIVERY_ADDRESS_TO_ORDER'), $params);


            if ($apiResult['code'] == Response::HTTP_BAD_REQUEST) {

                throw new Exception($apiResult['response']['message'], Response::HTTP_BAD_REQUEST);
            }

            $response = ['code' => $apiResult['code'], 'message' => $apiResult['response']['message']];
        } catch (Exception $e) {

            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];

            return Redirect::back()->with('success', $response);
        }

        return Redirect::route('user.show.place.order')->with('success', $response);
    }

    /**
     * showFinalOrderProces
     * @param : null
     * @return : application/html
     */

    public function showFinalOrderProces()
    {

        try {
            $cartListing = $this->userClient->get(config('userconfig.ENDPOINTS.CART_LIST'));

            $cartList = empty($cartListing['response']['data']['cartListing']) ? [] : $cartListing['response']['data']['cartListing'];

            $summary = empty($cartListing['response']['data']['cartSummary']) ? [] : $cartListing['response']['data']['cartSummary'];

            $totalItems =  empty($cartListing['response']['data']['itemCount']) ? 0 : $cartListing['response']['data']['itemCount'];

            $orderId = empty($cartListing['response']['data']['order_uid']) ? "" : $cartListing['response']['data']['order_uid'];

            $summaryTotal = empty($cartListing['response']['data']['total']) ? "" : $cartListing['response']['data']['total'];

            $deliveryAddress = empty($cartListing['response']['data']['delivery_address']) ? [] : $cartListing['response']['data']['delivery_address'];

            return view('User::cart.place-order', [
                'cartList' => $cartList, 'summary' => $summary,
                'items' => $totalItems, 'orderId' => $orderId, 'total' => $summaryTotal,
                'delivery' => $deliveryAddress
            ]);
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }
    }

    /**
     * placeOrder
     * @param : order id
     * @return : application/html
     */

    public function placeFinalOrder(Request $request)
    {

        try {

            $orderId = $request->get('order_id', '');

            if (empty($orderId)) {
                throw new Exception(trans('User::home.order_id_field_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $params = [];
            $params['order_uid'] = $orderId;

            $apiResult = $this->userClient->post(config('userconfig.ENDPOINTS.PLACE_ORDER'), $params);

            if ($apiResult['code'] == Response::HTTP_UNPROCESSABLE_ENTITY) {  //check if product is available or not
                $response = ['code' => Response::HTTP_OK, 'message' => $apiResult['response']['message']];

                return redirect()->route('user.show.cart.list')->with('success', $response);
            }

            if ($apiResult['code'] != Response::HTTP_OK) {

                throw new Exception($apiResult['response']['message'], $apiResult['code']);
            }

            $response = ['code' => $apiResult['code'], 'message' => $apiResult['response']['message']];
        } catch (Exception $e) {

            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];

            Redirect::back()->with('success', $response);
        }

        return Redirect::route('user.order.listing')->with('success', $response);
    }


    /**
     * addDeliveryAddress
     * @param : null
     * @return : application/html
     */

    public function addDeliveryAddressFromCart(Request $request)
    {

        /*
        |
        | define validation rules
        |
        */

        $rules = [
            'username' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'administrative_area_level_1' => 'required',
            'locality' => 'required',
            'postal_code' => 'required',
            'address_type_val' => 'required',
        ];

        /*
        |
        | run validation rules
        |
        */

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->with('errors', $validation->errors())->withInput();
        }



        try {
            $userId = Auth::guard('users')->user()->id;

            $deliveryAddress = new UserDeliveryLocation;
            $deliveryAddress->user_id = $userId;
            $deliveryAddress->name = $request->get('username');
            $deliveryAddress->mobile = $request->get('contact_number');
            $deliveryAddress->address = $request->get('houseno', '');
            $deliveryAddress->formatted_address = $request->get('address');
            $deliveryAddress->city = $request->get('locality');
            $deliveryAddress->state = $request->get('administrative_area_level_1');
            $deliveryAddress->zipcode = $request->get('postal_code');
            $deliveryAddress->address_type = $request->get('address_type_val');
            $deliveryAddress->country = is_null($request->get('country')) ? "" : $request->get('country', '');
            $deliveryAddress->lat = is_null($request->get('lat')) ? 0.00000 : $request->get('lat', '');
            $deliveryAddress->lng = is_null($request->get('lng')) ? 0.00000 : $request->get('lng', '');
            $deliveryAddress->save();

            $http_response_header = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.add_delivery_location')
            ];
        } catch (Exception $e) {
            CommonHelper::handleException($e);
        }

        return redirect()->route('user.checkout.delivery.address')->with('success', $http_response_header);
    }
}
