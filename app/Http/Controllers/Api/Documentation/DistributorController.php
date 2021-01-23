<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributorController extends BaseController
{

    /**
     * @OA\Get(
     *     path="/api/distributor/view-profile",
     *     operationId="/api/distributor/view-profile",
     *     tags={"Distributor Detail"},
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
     *     path="/api/distributor/my-reviews",
     *     operationId="/api/distributor/my-reviews",
     *     tags={"Distributor Detail"},
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
     *     path="/api/distributor/change-password",
     *     operationId="/api/distributor/change-password",
     *     tags={"Distributor Detail"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="old_password",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"old_password":"123456", "password":"qwerty@123"}
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
     * @OA\Post(
     *     path="/api/distributor/update-profile",
     *     operationId="/api/distributor/update-profile",
     *     tags={"Distributor Detail"},
     *     description="update distributor profile",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="profile_image",
     *                     type="string"
     *                 ),
     *                 example={"name":"Valentino Rossi", "profile_image":"https://images.app.goo.gl/KbrV4MVr1L5sLePe8"}
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
     * @OA\Post(
     *     path="/api/distributor/send-otp-distributor",
     *     operationId="/api/distributor/send-otp-distributor",
     *     tags={"Distributor Detail"},
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
     *                 example={"country_code": "+91", "phone_number": "9667471608"}
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
     * @OA\Post(
     *     path="/api/distributor/verify-otp-distributor",
     *     operationId="/api/distributor/verify-otp-distributor",
     *     tags={"Distributor Detail"},
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
     *                 example={"country_code": "+91", "phone_number": "9667471608", "otp":"0000"}
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
     * @OA\Post(
     *     path="/api/distributor/update-location",
     *     operationId="/api/distributor/update-location",
     *     tags={"Distributor Detail"},
     *     description="update driver location",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="string"
     *                 ),
     *                 example={"longitude": "xx.yyyzzz", "latitude":"zzz.aaaabbbb"}
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
     * @OA\Post(
     *     path="/api/distributor/logout",
     *     operationId="/api/distributor/logout",
     *     tags={"Distributor Detail"},
     *     description="logout driver",
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
     * @OA\Post(
     *     path="/api/distributor/update-device-token",
     *     operationId="/api/distributor/update-device-token",
     *     tags={"Distributor Detail"},
     *     description="update driver device-token",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="device_token",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_type",
     *                     type="string"
     *                 ),
     *                 example={"device_token": "xx.yyyzzz", "device_type":"ios/android"}
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
     *     path="/api/distributor/my-notifications",
     *     operationId="/api/distributor/my-notifications",
     *     tags={"Distributor Notification"},
     *     description="get user notification listing",
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
     * @OA\Put(
     *     path="/api/distributor/read-notification/{notficationId}",
     *     operationId="/api/distributor/read-notification/{notficationId}",
     *     tags={"Distributor Notification"},
     *     description="read user notification listing",
     *     @OA\Parameter(
     *         name="notficationId",
     *         in="path",
     *         description="Notfication Id",
     *         required=true,
     *         @OA\Schema(type="integer")
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
