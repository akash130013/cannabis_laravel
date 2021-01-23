<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryController extends BaseController
{

    /**
     * @OA\Get(
     *     path="/api/user/my-delivery-addresses",
     *     operationId="/api/user/my-delivery-addresses",
     *     tags={"Checkout"},
     *     @OA\Response(
     *         response="200",
     *         description="my address listing",
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
     *     path="/api/user/save-delivery-location",
     *     operationId="/api/user/save-delivery-location",
     *     tags={"Checkout"},
     *     description="save delivery address",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="mobile",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="locality",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="state",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="zipcode",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="country",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address_type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="lat",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="lng",
     *                     type="string"
     *                 ),
     *                 example={"name":"Sumit Sharma", "mobile":"+91 99XXXXXX","address":"B-25,", "locality":"Sector 58", "city":"Noida", "state":"Uttar Pradesh", "zipcode":201301, "country":"India", "address_type":"Home/Office/Other", "lat":"28.6060756", "lng":"77.36191400000007"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="address saved succesfully",
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
     *     path="/api/user/update-delivery-location",
     *     operationId="/api/user/update-delivery-location",
     *     tags={"Checkout"},
     *     description="save delivery address",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="mobile",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="locality",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="state",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="zipcode",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="country",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address_type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="lat",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="lng",
     *                     type="string"
     *                 ),
     *                 example={"id": 1, "name": "Sumit", "mobile": "+91 9899387270", "address":"B-25,", "locality":"Sector 58", "city":"Noida", "state":"Uttar Pradesh", "zipcode":201301, "country":"India", "lat":"28.6060756", "lng":"77.36191400000007", "address_type":"Home/Office/Other"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="address updated succesfully",
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
     * @OA\Delete(
     *     path="/api/user/delete-delivery-location/{id}",
     *     operationId="/api/user/delete-delivery-location/{id}",
     *     tags={"Checkout"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id is addressId",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Delivery Address Deleted Successfully",
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
     *     path="/api/user/update-order-delivery-address",
     *     operationId="/api/user/update-order-delivery-address",
     *     tags={"Checkout"},
     *     description="update order delivery address",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address_id",
     *                     type="integer"
     *                 ),
     *                 example={"order_uid":"ba55c113-8561-49c0-950f-6965d82d0281", "address_id":1}
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
     *     path="/api/user/my-orders",
     *     operationId="/api/user/my-orders",
     *     tags={"User Orders"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="type can be pending or ongoing or completed",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
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
     *     path="/api/user/order-detail/{order_uid}",
     *     operationId="/api/user/order-detail/{order_uid}",
     *     tags={"User Orders"},
     *     @OA\Parameter(
     *         name="order_uid",
     *         in="path",
     *         description="order_uid is order uid",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
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
     *     path="/api/user/fetch-rating",
     *     operationId="/api/user/fetch-rating",
     *     tags={"rating-review"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type can be driver, store or product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="rated_id",
     *         in="query",
     *         description="id of driver, store or product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pagesize",
     *         in="query",
     *         description="pagesize",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
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
     *     path="/api/user/rate-order",
     *     operationId="/api/user/rate-order",
     *     tags={"rating-review"},
     *     description="rate your order",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="rated_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="rate",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="review",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"xxxyyyyyzzzz", "type":"product", "rated_id": 1, "rate":5, "review":"fabalous man, somebody give him noble prize"}
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
     *     path="/api/user/rate-order-bulk",
     *     operationId="/api/user/rate-order-bulk",
     *     tags={"rating-review"},
     *     description="rate your order's driver, store and prodcut(s) in one go, Note: all rating objects in array, see example",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="rated_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="rate",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="review",
     *                     type="string"
     *                 ),
     *                 example={{"order_uid":"xxxyyyyyzzzz", "type":"product", "rated_id": 1, "rate":5, "review":"fabalous man, somebody give him noble prize"},{"order_uid":"xxxyyyyyzzzz", "type":"product", "rated_id": 1, "rate":5, "review":"fabalous man, somebody give him noble prize"}}
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
     *     path="/api/user/cancel-order",
     *     operationId="/api/user/cancel-order",
     *     tags={"Checkout"},
     *     description="cancel order by user",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"xxxyyyyyzzzz"}
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
     *     path="/api/user/re-order",
     *     operationId="/api/user/re-order",
     *     tags={"Checkout"},
     *     description="clean pref-filled cart(if any) and add products of a specific order",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 example={"order_uid":"xxxyyyyyzzzz"}
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
     *     path="/api/user/track-order/{order_uid}",
     *     operationId="/api/user/track-order/{order_uid}",
     *     tags={"User Orders"},
     *     @OA\Parameter(
     *         name="order_uid",
     *         in="path",
     *         description="order_uid is order uid",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
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


}

