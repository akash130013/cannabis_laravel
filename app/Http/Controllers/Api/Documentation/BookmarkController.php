<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;

class BookmarkController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/user/create-bookmark-store/{storeId}",
     *     operationId="/api/user/create-bookmark-store/{storeId}",
     *     tags={"Bookmark"},
     *     @OA\Parameter(
     *         name="storeId",
     *         in="path",
     *         description="Store Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="added",
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
     *     path="/api/user/remove-bookmark-store/{storeId}",
     *     operationId="/api/user/remove-bookmark-store/{storeId}",
     *     tags={"Bookmark"},
     *     @OA\Parameter(
     *         name="storeId",
     *         in="path",
     *         description="Store Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="remove",
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
     *     path="/api/user/my-bookmark",
     *     operationId="/api/user/my-bookmark",
     *     tags={"Bookmark"},
     *     @OA\Response(
     *         response="200",
     *         description="My Bookmarks",
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
