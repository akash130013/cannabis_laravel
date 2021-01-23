<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;

class CartController extends BaseController
{

    /**
     * @OA\Post(
     *     path="/api/user/add-to-cart",
     *     operationId="/api/user/add-to-cart",
     *     tags={"Cart"},
     *     description="add item to cart",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="product_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="store_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="size",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="size_unit",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="attributes",
     *                     type="string"
     *                 ),
     *                 example={"product_id": 2, "store_id": 3, "size":"200", "size_unit":"grams", "attributes":""}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Item added succesfully",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */



    /**
     * @OA\Post(
     *     path="/api/user/clear-cart-add-item",
     *     operationId="/api/user/clear-cart-add-item",
     *     tags={"Cart"},
     *     description="clear cart items and add item to cart",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="product_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="store_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="size",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="size_unit",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="attributes",
     *                     type="string"
     *                 ),
     *                 example={"product_id": 2, "store_id": 3, "size":"200", "size_unit":"grams", "attributes":""}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Item added succesfully",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */





    /**
     * @OA\Get(
     *     path="/api/user/remove-cart-item/{cartUid}",
     *     operationId="/api/user/remove-cart-item/{cartUid}",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="cartUid",
     *         in="path",
     *         description="cart_uid is cartUid",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="item remove successfully",
     *     @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/user/show-cart",
     *     operationId="/api/user/show-cart",
     *     tags={"Cart"},
     *     @OA\Response(
     *         response="200",
     *         description="cart listing",
     *     @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */



    /**
     * @OA\Post(
     *     path="/api/user/update-item",
     *     operationId="/api/user/update-item",
     *     tags={"Cart"},
     *     description="update item quantity or update size and unit  in cart(in case of quantity update only quantity key available and in case of size update only size and size_unit keyes will be available)",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="cart_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="quantity",
     *                     type="integer"
     *                 ),
     *                  @OA\Property(
     *                     property="size",
     *                     type="integer"
     *                 ),
     *                  @OA\Property(
     *                     property="size_unit",
     *                     type="string"
     *                 ),
     *                 example={"cart_uid":"1f388b35-8e51-4a17-8feb-33e17a299468", "quantity":1, "size":10, "size_unit":"miligrams"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Item updated succesfully",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */




    /**
     * @OA\Get(
     *     path="/api/user/create-order",
     *     operationId="/api/user/create-order",
     *     tags={"Checkout"},
     *     description="create order/checkout",
     *     @OA\Response(
     *         response="200",
     *         description="Order Scheduled",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */




    /**
     * @OA\Post(
     *     path="/api/user/apply-coupon-code",
     *     operationId="/api/user/apply-coupon-code",
     *     tags={"Checkout"},
     *     description="apply promocode for order",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="coupon_code",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"ba55c113-8561-49c0-950f-6965d82d0281", "coupon_code":"FIRST1K"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/user/remove-coupon-code",
     *     operationId="/api/user/remove-coupon-code",
     *     tags={"Checkout"},
     *     description="remove promocode",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="coupon_code",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"ba55c113-8561-49c0-950f-6965d82d0281", "coupon_code":"FIRST1K"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */




    /**
     * @OA\Post(
     *     path="/api/user/schedule-order",
     *     operationId="/api/user/schedule-order",
     *     tags={"Checkout"},
     *     description="schedule delivery for order",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="schedule_date",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"ba55c113-8561-49c0-950f-6965d82d0281", "schedule_date":"2019-11-11"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Order Scheduled",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/user/redeem-loyalty-points",
     *     operationId="/api/user/redeem-loyalty-points",
     *     tags={"Checkout"},
     *     description="redeem loyalty point as discount",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"ba55c113-8561-49c0-950f-6965d82d0281"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/user/remove-loyalty-points",
     *     operationId="/api/user/remove-loyalty-points",
     *     tags={"Checkout"},
     *     description="redeem loyalty point as discount",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"xxxxxx"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Get(
     *     path="/api/user/show-promo-codes",
     *     operationId="/api/user/show-promo-codes",
     *     tags={"Cart"},
     *     @OA\Response(
     *         response="200",
     *         description="item remove successfully",
     *     @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/user/my-cart-count",
     *     operationId="/api/user/my-cart-count",
     *     tags={"Cart"},
     *     @OA\Response(
     *         response="200",
     *         description="cart count",
     *     @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/user/place-order",
     *     operationId="/api/user/place-order",
     *     tags={"Checkout"},
     *     description="place order",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"ba55c113-8561-49c0-950f-6965d82d0281"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Get(
     *     path="/api/user/get-loyalty-points-exchange-info",
     *     operationId="/api/user/get-loyalty-points-exchange-info",
     *     tags={"Checkout"},
     *     @OA\Response(
     *         response="200",
     *         description="get loyalty point exchange info",
     *     @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *         @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */



    /**
     * @OA\Get(
     *     path="/user/app-redirect/{login_token}",
     *     operationId="/user/app-redirect/{login_token}",
     *     tags={"Checkout"},
     *     description="token for open page in web view or web browser",
     *     @OA\Parameter(
     *         name="login_token",
     *         in="path",
     *         description="Login token ",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorised.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     */




}
