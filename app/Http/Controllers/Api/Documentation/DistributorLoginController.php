<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributorLoginController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/distributor/login",
     *     operationId="/api/distributor/login",
     *     tags={"Distributor Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="country_code",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="phone_number",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_token",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_type",
     *                     type="string"
     *                 ),
     *                 example={"country_code": "+91", "phone_number":"9667471608", "password": "1234", "device_token":"xxxx-yyyy-zzzz", "device_type":"android/ios"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Login success",
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
     *     @OA\Response(
     *         response="410",
     *         description="Phone Number not verified.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/distributor/forgot-password",
     *     operationId="/api/distributor/forgot-password",
     *     tags={"Distributor Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="country_code",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="phone_number",
     *                     type="string"
     *                 ),
     *                 example={"country_code": "+91", "phone_number":"9667471608"}
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
     *     @OA\Response(
     *         response="410",
     *         description="Phone Number not verified.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */



    /**
     * @OA\Post(
     *     path="/api/distributor/verify-forgot-otp",
     *     operationId="/api/distributor/verify-forgot-otp",
     *     tags={"Distributor Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="country_code",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="phone_number",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="otp",
     *                     type="string"
     *                 ),
     *                 example={"country_code": "+91", "phone_number":"9667471608", "otp":"0000"}
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
     *     @OA\Response(
     *         response="410",
     *         description="Phone Number not verified.",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="OTP mismatch.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/distributor/reset-password",
     *     operationId="/api/distributor/reset-password",
     *     tags={"Distributor Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="distributor_id",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="reset_token",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"distributor_id": "1", "reset_token": "662fcc8f-4670-454a-98f3-2741dd886140", "password": "123456"}
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
     *     security={ {"basicAuth": {}} },
     * )
     */


}
