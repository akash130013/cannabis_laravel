<?php

namespace App\Http\Controllers\Api\Documentation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/user/get-nearby-stores",
     *     operationId="/api/user/get-nearby-stores",
     *     tags={"Stores"},
     *     @OA\Parameter(
     *         name="availablity",
     *         in="query",
     *         description="availablity : [active/blocked]",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="rating",
     *         in="query",
     *         description="default [all]",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="product id in integer format",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="category_id or multiple category_id with comma separated",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="is_open",
     *         in="query",
     *         description="is_open in 1 or 0",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="latitude",
     *                     type="string"
     *                 ),
     *                 example={"longitude":"-96.77087365924683", "latitude":"32.7664894578217"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Products",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/user/store-products",
     *     operationId="/api/user/store-products",
     *     tags={"Stores"},
     *     @OA\RequestBody(
     *     description="sorting_id
    1. price high to low
    2. price low to high
    3. mostly recommended
    4. What's new
    5. Popularity
    6. Discount
    stock_availability
    2- IN STOCK
    3- OUTOFSTOCK
    price_range [min,max]
    is_discounted
    1- yes
    2- no
    cannabis_type : category_id",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="store_id",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="sorting_id",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="stock_availability",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="rating",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="price_range",
     *                     type="array",
     *                      @OA\Items(type="integer")
     *                 ),
     *                  @OA\Property(
     *                     property="is_discounted",
     *                     type="boolean",
     *                 ),
     *                  @OA\Property(
     *                     property="cannabis_type",
     *                     type="integer",
     *                 ),
     *                  @OA\Property(
     *                     property="search",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="is_trending",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="zipcode",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="product_id",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="unique",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="dealonly",
     *                     type="bool",
     *                 ),
     *                 example={"store_id":5, "sorting_id": 1, "stock_availability":2, "rating":3, "price_range":"[1,10000]", "is_discounted":1, "cannabis_type":2, "search":"Radhe", "is_trending":"", "zipcode":"", "product_id":"", "unique":"product_id", "dealonly":true},
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Products",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Get(
     *     path="/api/user/store-detail/{storeId}",
     *     operationId="/api/user/store-detail/{storeId}",
     *     tags={"Stores"},
     *     @OA\Parameter(
     *         name="storeId",
     *         in="path",
     *         description="Store Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="store detail",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/user/get-stores-by-productId",
     *     operationId="/api/user/get-stores-by-productId",
     *     tags={"Stores"},
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
     *                 example={"product_id": 2, "longitude":"-96.77087365924683", "latitude":"32.7664894578217"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Store List",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *     ),
     *     security={ {"bearerAuth": {}} },
     * )
     * )
     */


}
