<?php

namespace App\Http\Controllers\Api\Documentation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishListController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/add-to-wishlist/{productId}",
     *     operationId="/api/user/add-to-wishlist/{productId}",
     *     tags={"Wishlist"},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Wishlist added",
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
     *     path="/api/user/remove-from-wishlist/{productId}",
     *     operationId="/api/user/remove-from-wishlist/{productId}",
     *     tags={"Wishlist"},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Wishlist added",
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
     *     path="/api/user/my-wishlist",
     *     operationId="/api/user/my-wishlist",
     *     tags={"Wishlist"},
     *     @OA\Response(
     *         response="200",
     *         description="My Wishlist ",
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


}
