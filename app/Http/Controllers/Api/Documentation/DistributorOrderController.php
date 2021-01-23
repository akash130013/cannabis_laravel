<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributorOrderController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/distributor/my-orders",
     *     operationId="/api/distributor/my-orders",
     *     tags={"Distributor Orders"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_status",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="order_delivery_schedule_date",
     *                     type="date"
     *                 ),
     *                 example={"order_status": "completed/upcoming", "order_delivery_schedule_date":"2019-12-31"}
     *             )
     *         )
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

    /**
     * @OA\Get(
     *     path="/api/distributor/order-detail/{order_uid}",
     *     operationId="/api/distributor/order-detail/{order_uid}",
     *     tags={"Distributor Orders"},
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
     * @OA\Post(
     *     path="/api/distributor/change-order-status",
     *     operationId="/api/distributor/change-order-status",
     *     tags={"Distributor Orders"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="order_status",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="order_uid",
     *                     type="string"
     *                 ),
     *                 example={"order_status": "on_delivery/delivered/amount_received", "order_uid":"xxxx-yyyy-zzzz"}
     *             )
     *         )
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
