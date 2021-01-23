<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;

class CategoryController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/user/categories",
     *     operationId="/api/user/categories",
     *     tags={"Category"},
     *     @OA\Response(
     *         response="200",
     *         description="Category",
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
     *     path="/api/user/all-categories",
     *     operationId="/api/user/all-categories",
     *     tags={"Category"},
     *     @OA\Response(
     *         response="200",
     *         description="All Category",
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
