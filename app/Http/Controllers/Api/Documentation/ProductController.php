<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/user/trending-products",
     *     operationId="/api/user/trending-products",
     *     tags={"Products"},
     *     @OA\Response(
     *         response="200",
     *         description="Products",
         *     @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
         *     @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */



    /**
     * @OA\Post(
     *     path="/api/user/product-detail",
     *     operationId="/api/user/product-detail",
     *     tags={"Products"},
     *     description="id is product_id, store_id : optional, user_type: web is only applicable for api from userWeb, app dev need to ignore this",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="latitude",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="store_id",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="user_type",
     *                     type="string"
     *                 ),
     *                 example={"id": 2, "longitude":"-96.77087365924683", "latitude":"32.7664894578217", "store_id":2, "user_type":"web"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Products",
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
     *     path="/api/user/get-similar-products",
     *     operationId="/api/user/get-similar-products",
     *     tags={"Products"},
     *     description="fetch similar product based on category and location",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="product_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="latitude",
     *                     type="string"
     *                 ),
     *                 example={"product_id": 1, "longitude":"-96.77087365924683", "latitude":"32.7664894578217"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Products",
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



}
