<?php

namespace App\Http\Controllers\Api\User;

use App\Events\LPCreditEvent;
use App\Events\PostPlaceOrderEvent;
use App\Helpers\CommonHelper;
use App\Http\Services\CartService;
use App\Http\Services\DeliveryService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PromoCode;
use App\Rules\AddCartQuantityRule;
use App\Rules\CartItemQuantityRule;
use App\Rules\PlaceOrderRule;
use App\Rules\PromoCodeRule;
use App\Rules\SingleStoreOrderRule;
use App\Rules\StoreUserZipcodeRule;
use App\Transformers\CartTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\CartItemSizeRule;
use Illuminate\Validation\Rule;

/**
 * Class CartController
 * @package App\Http\Controllers\Api
 * @author Sumit Sharma
 */
class CartController extends Controller
{
    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * CartController constructor.
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * add item into cart
     * @param Request $request
     * @return mixed
     */
    public function addToCart(Request $request)
    {
        try {
            $request->request->add(['quantity' => 1]);
            $validator = \Validator::make($request->all(), [
                'product_id' => 'required',
                'store_id'   => ['required', Rule::exists('store_product_stock')->where(function ($query) {
                    $query->where(['store_id' => request()->store_id, 'product_id' => request()->product_id]);
                }), new SingleStoreOrderRule],
                'size'       => 'required',
                'quantity' => [new AddCartQuantityRule($request->product_id, $request->store_id, $request->size)],
            ], [
                'store_id.exists' => 'Product is not available on given store',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $sellingPrice = $this->cartService->fetchSellingPrice($request->product_id, $request->store_id, $request->size, $request->size_unit);
            if (!$sellingPrice) {
                return response()->jsend_error(new \Exception("Selling Price Unavailable"), $message = null);

            }

            $request->request->add(['user_id' => $request->user()->id]);
            $request->request->add(['selling_price' => $sellingPrice]);
            $cartStatus = $this->cartService->addCart($request->all());
            return response()->jsend($data = $cartStatus, $presenter = null, $status = "success", $message = "product added to cart", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * remove item from cart
     * @param $cartUid
     * @return mixed
     */
    public function removeCartItem($cartUid)
    {
        try {
            $validator = \Validator::make(['cart_uid' => $cartUid], [
                'cart_uid' => ['required', Rule::exists('carts')->where(function ($query) use ($cartUid) {
                    $query->where(['cart_uid' => $cartUid, 'user_id' => request()->user()->id]);
                })
                ],
            ], [
                'cart_uid.exists' => 'cart_uid is not associate with current user'
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $removeItem = $this->cartService->removeCart($cartUid, request()->user()->id);
            if (!$removeItem) {
                return response()->jsend_error(new \Exception("Cart could not be removed, try again"), $message = null);
            }
            return $this->showCart(\request()->user()->id, "item remove successfully");

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * show cart items
     * @param null $userId
     * @param null $message
     * @return mixed
     */
    public function showCart($userId = null, $message = null)
    {
        if (!$userId) {
            $userId = \request()->user()->id;
        }
        $orderUid = $this->cartService->createOrder(['user_id' => $userId]);
        if (!$orderUid) {
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = $message ?? "empty cart", $code = config('constants.SuccessCode'));
        }
        $order = $this->cartService->getOrder(['order_uid' => $orderUid])->first();

        $cartData = new \stdClass();
        $cart     = $this->cartService->showCart(['user_id' => $userId]);
        if ($cart->count() == 0) {
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = $message ?? "empty cart", $code = config('constants.SuccessCode'));

        }
        $this->checkCartPromoValidity($orderUid);


        $cart                                  = CartTransformer::TransformCollection($cart);
        $cartData->cartSummary                 = CommonHelper::cartSummary($cart);
        $cartData->cartListing                 = $cart;
        $cartData->total['cartSubTotal']       = $cart->sum('item_subtotal');
        $cartData->itemCount                   = $cart->count('item_subtotal');
        $cartData->total['additional_charges'] = @$order->additional_charges;
        $cartData->total['discounts']          = @$order->discounts;
        $cartData->total['promo_code_applied'] = @$this->cartService->fetchUserPromoCode(['order_uid' => $orderUid])->first()->promo_code;
        $net_amount                            = $cart->sum('item_subtotal') + (is_null(@$order->additional_charges) ? 0 : array_sum(array_values($order->additional_charges))) - (is_null(@$order->discounts) ? 0 : array_sum(array_values($order->discounts)));
        $cartData->total['net_amount']         = ($net_amount > 0) ? $net_amount : 0;
        $cartData->order_uid                   = $orderUid;
        $cartData->delivery_address            = @$this->cartService->getOrder(['order_uid' => $orderUid])->first()->delivery_address;
        $order->cart_subtotal                  = $cartData->total['cartSubTotal'];
        $order->net_amount                     = is_null(@$cartData->total['net_amount']) ? 0 : @$cartData->total['net_amount'];
        $order->save();


        return response()->jsend($data = $cartData, $presenter = null, $status = "success", $message = $message ?? "cart listing", $code = config('constants.SuccessCode'));

    }

    /**
     * update cart item.
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'cart_uid' => ['required', Rule::exists('carts')->where(function ($query) {
                    $query->where(['cart_uid' => \request()->cart_uid, 'user_id' => request()->user()->id]);
                })
                ],
                'quantity' => ['required', 'min:1', 'max:' . config('constants.CART.MAX_SINGLE_ITEM_QUANTITY'), 'numeric', new CartItemQuantityRule($request->cart_uid, $request->size, $request->size_unit)],
                'size' => ['required', 'min:1', 'numeric'],
                'size_unit' => ['required', 'string'],
//                'size_unit' => ['required', 'string', new CartItemSizeRule($request->cart_uid)],
                //                'quantity' => ['required', 'min:1', 'max:5', 'numeric', function ($attribute, $value, $fail) {
                //                    if (!is_int($value)) $fail($attribute . ' is not full number.');
                //                }],
            ], [
                'cart_uid.exists' => 'cart_uid is not associate with current user'
            ]);


            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $status = $this->cartService->updateQuantitySize($request->cart_uid, $request->quantity,  $request->size, $request->size_unit);

            if (!$status) {
                return response()->jsend_error(new \Exception("some error occurred"), $message = null);
            }
            return $this->showCart(\request()->user()->id, "item updated successfully");


        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @param null $userId
     * @return mixed
     */
    public function createOrder($userId = null)
    {
        try {
            $userId    = $userId ?? \request()->user()->id;
            $validator = \Validator::make(['user_id' => $userId], [
                'user_id' => ['required',],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $orderUid = $this->cartService->createOrder(['user_id' => $userId]);

            $cart = $this->cartService->showCart(['user_id' => $userId]);
            $cart = CartTransformer::TransformCollection($cart);

            $this->cartService->updateOrder($orderUid, ['cart_subtotal' => $cart->sum('item_subtotal')]);

            return response()->jsend($data = $orderUid, $presenter = null, $status = "success", $message = $message ?? "order Uid", $code = config('constants.SuccessCode'));


        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateOrderDeliveryAddress(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid'  => ['required', Rule::exists('orders')->where(function ($query) {
                    $query->where(['order_uid' => \request()->order_uid, 'user_id' => request()->user()->id]);
                })],
                'address_id' => ['required', 'exists:user_delivery_location,id', new StoreUserZipcodeRule($request->order_uid)],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $deliveryService = new DeliveryService();
            $deliverAddress  = $deliveryService->getUserDeliverAddress(['id' => $request->address_id])->first();
            unset($deliverAddress->id, $deliverAddress->user_id, $deliverAddress->created_at, $deliverAddress->is_default, $deliverAddress->status);
            $updateOrderDeliveryAddress = $this->cartService->updateOrder($request->order_uid, ['delivery_address' => $deliverAddress]);
            if ($updateOrderDeliveryAddress) {
                return response()->jsend($data = null, $presenter = null, $status = "success", $message = $message ?? "Delivery address set successfully", $code = config('constants.SuccessCode'));

            }


        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function applyPromoCode(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid'   => ['required', Rule::exists('carts')->where(function ($query) {
                    $query->where(['order_uid' => \request()->order_uid, 'user_id' => request()->user()->id]);
                }), new PromoCodeRule($request->coupon_code)],
                'coupon_code' => ['required'],

            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $order = $this->cartService->applyPromoCode($request->order_uid, $request->user()->id, $request->coupon_code);
            if (!$order) {
                return response()->jsend_error(new \Exception(config('constants.coupon_code_invalid')), $message = null);
            }

            return $this->showCart(\request()->user()->id, "Coupon code applied");

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * remove promo code
     * @param Request $request
     * @return mixed
     */
    public function removePromoCode(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid'   => ['required', Rule::exists('carts')->where(function ($query) {
                    $query->where(['order_uid' => \request()->order_uid, 'user_id' => request()->user()->id]);
                })],
                'coupon_code' => ['required', 'exists:promo_codes,coupon_code'],

            ], [
                'coupon_code.exists' => config('constants.coupon_code_invalid'),
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $order = $this->cartService->removePromoCode($request->order_uid);
            if (!$order) {
                return response()->jsend_error(new \Exception(config('constants.coupon_code_invalid')), $message = null);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = $message ?? "Coupon code removed", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function scheduleOrder(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid'     => ['required'],
                'schedule_date' => ['required', 'date_format:Y-m-d', 'after:' . Carbon::now()->addDays(config('constants.ORDER_SCHEDULE__PREDATE'))],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $order = $this->cartService->updateOrder($request->order_uid, ['schedule_date' => $request->schedule_date]);
            if (!$order) {
                return response()->jsend_error(new \Exception("Order could not be scheduled"), $message = null);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Order Scheduled", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * redeem loyalty point for discount
     * @param Request $request
     * @return mixed
     */
    public function redeemLoyaltyPoints(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $order = $this->cartService->redeemLPoints($request->order_uid, $request->user()->id);
            if (!$order)
                return response()->jsend_error(new \Exception("Loyalty point is insufficient to redeem"), $message = null);

            return response()->jsend($data = $order, $presenter = null, $status = "success", $message = "loyalty point redeem for discount", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * remove loyalty points from cart-order.
     * @param Request $request
     * @return mixed
     */
    public function removeLoyaltyPoints(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $order = $this->cartService->removeRedeemPoints($request->order_uid, $request->user()->id);
            if (!$order)
                return response()->jsend_error(new \Exception("Can not process this request now"), $message = null);

            return response()->jsend($data = $order, $presenter = null, $status = "success", $message = "loyalty point removed from order", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * show listing for available promo codes
     * @param Request $request
     * @return mixed
     */
    public function getPromoCodes(Request $request)
    {
        try {
            $promoCodes = $this->cartService->showAvailablePromoCodes(['offer_status' => 'active']);
            $promoCodes = CartTransformer::promoCodeTransformerCollection($promoCodes);
            return response()->jsend($data = $promoCodes, $presenter = null, $status = "success", $message = "list for available promo-codes", $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * @return mixed
     */
    public function cartCount()
    {
        try {
            $cartCount = $this->cartService->showCart(['user_id' => \request()->user()->id])->count();
            return response()->jsend($data = $cartCount, $presenter = null, $status = "success", $message = "cart count", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * get loyalty point exchange info.
     * @param Request $request
     * @return mixed
     */
    public function getLoyaltyPointExchangeInfo(Request $request)
    {
        try {
            $loyaltyPointsExchangeInfo = $this->cartService->fetchLoyaltyPointsExchangeInfo();
            $info['data']              = CartTransformer::loyaltyPointExchangeCollectionTransform($loyaltyPointsExchangeInfo);
            return response()->jsend($data = $info, $presenter = null, $status = "success", $message = "loyalty point exchange info", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    public function clearCartAddItem(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'product_id' => 'required',
                'store_id'   => ['required', Rule::exists('store_product_stock')->where(function ($query) {
                    $query->where(['store_id' => request()->store_id, 'product_id' => request()->product_id]);
                })],
                'size'       => 'required',
            ], [
                'store_id.exists' => 'Product is not available on given store',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $this->cartService->clearCart(['user_id' => $request->user()->id]);
            return $this->addToCart($request);
        } catch (\Exception $exception) {
            CommonHelper::catchException($exception);
        }

    }

    protected function checkCartPromoValidity($orderUid)
    {
//        $cart = $this->cartService->showCart(['cart_uid' => $cartUid])->first();
//        if (!$cart || is_null($cart->order_uid) || !$cart->order->promo_code) {
//            return true;
//        }
        $order = Order::where('order_uid', $orderUid)->first();
        if (!$order || is_null($order->promo_code)){
            return true;
        }
        $promoCode = PromoCode::where(['coupon_code' => $order->promo_code, 'offer_status' => 'active'])
            ->where(function ($q) {
                $q->where('start_time', '<=', Carbon::now());
                $q->where('end_time', '>=', Carbon::now());
            })
            ->where('coupon_remained', '>', 0)
            //                                 other queries will be added
            ->first();
        if (!$promoCode) {
            $this->cartService->removePromoCode($orderUid);
        }

        $carts       = Cart::where('order_uid', $orderUid)->get();
        $price       = [];
        foreach ($carts as $data) {
            $price[] = $this->cartService->fetchSellingPrice($data->product_id, $data->store_id, $data->size, $data->size_unit, $data->quantity);
        }

        $total_amount = array_sum($price);
        if ($promoCode && $promoCode->min_amount > $total_amount) {
            $this->cartService->removePromoCode($orderUid);
        }

    }


}
