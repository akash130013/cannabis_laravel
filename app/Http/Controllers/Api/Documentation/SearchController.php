<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends BaseController
{

    /**
     * @OA\Post(
     *     path="/api/user/global-search",
     *     operationId="/api/user/global-search",
     *     tags={"Search"},
     *     description="search_type: [ 1 - Product, 2- Store 3- Category]",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="search_type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="search",
     *                     type="string"
     *                 ),
     *                 example={"search_type": "1", "search":""}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Search",
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
     *     path="/api/user/save-search",
     *     operationId="/api/user/save-search",
     *     tags={"Search"},
     *     description="save searched data, searched_type => 1 : product, 2: store, 3: category",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="term",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="searched_type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="searched_id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="string"
     *                 ),
     *                 example={"term": "app", "searched_type": "2", "searched_id": 2, "longitude": "xxx.zzz", "latitude": "yyyy.zzz"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="save seach data",
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
