<?php

namespace App\Http\Controllers\Api\Documentation;

use App\Http\Controllers\Documentation\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{

    /**
     * @OA\Post(
     *     path="/api/contact-query",
     *     operationId="/api/contact-query",
     *     tags={"Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="reason",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"name":"Khushi", "email":"khusboo.agarwal@appinventiv.com", "reason":"can not access login", "message":"I can not access my account."}
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
     *         response="429",
     *         description="To avoid basic DDoS attack; To Many Attempt error",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="/api/login",
     *     tags={"Pre Login"},
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
     *         response="407",
     *         description="Error Basic auth missing or invalid.",
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
     *     path="/api/register",
     *     operationId="/api/register",
     *     tags={"Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="country_code",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="phone_number",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="dob",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="referral_code",
     *                     type="string"
     *                 ),
     *
     *                 example={"name":"Sumit Sharma", "email":"sumit.sharma@appinventiv.com","country_code": "+91", "phone_number":"9667471608", "dob":"1990-11-21", "password":"123456", "referral_code":"YUT234"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Signup success",
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
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/send-user-otp",
     *     operationId="/api/send-user-otp",
     *     tags={"Pre Login"},
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
     *         description="OTP send success",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="User not registered.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/verify-user-otp",
     *     operationId="/api/verify-user-otp",
     *     tags={"Pre Login"},
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
     *         description="OTP send success",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="User not registered.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */
    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     operationId="/api/forgot-password",
     *     tags={"Pre Login"},
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
     *         description="OTP send success",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *          @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="User not registered.",
     *          @OA\JsonContent(),
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/verify-forgot-otp",
     *     operationId="/api/verify-forgot-otp",
     *     tags={"Pre Login"},
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
     *                 ),@OA\Property(
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
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="Error: Invalid OTP.",
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     operationId="/api/reset-password",
     *     tags={"Pre Login"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user_id",
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
     *                 example={"user_id": "1", "reset_token": "069311a3-f091-43f2-bf97-1389281e19a7", "password": "1234"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request.",
     *     ),
     *     @OA\Response(
     *         response="406",
     *         description="Error: Password could not reset.",
     *     ),
     *     security={ {"basicAuth": {}} },
     * )
     */


    /**
     *  logged in user
     */


    /**
     * @OA\Post(
     *     path="/api/user/change-password",
     *     operationId="/api/user/change-password",
     *     tags={"Post-Login User"},
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
     *     security={ {"bearerAuth": {}} },
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/user/my-profile",
     *     operationId="/api/user/my-profile",
     *     tags={"Post-Login User"},
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
     *     path="/api/user/update-profile",
     *     operationId="/api/user/update-profile",
     *     tags={"Post-Login User"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="profile_pic",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="dob",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="age_proof",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="medical_proof",
     *                     type="string"
     *                 ),
     *                 example={"name":"Sumit S", "dob":"2001-01-01", "profile_pic":"aa", "email":"sumit.sharma@appinventiv.com", "age_proof":"https://appinventiv-development.s3.amazonaws.com/0.810906578974881_elearning.pdf", "medical_proof":"https://appinventiv-development.s3.amazonaws.com/0.6928921015566882_elearning.pdf"}
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
     *     path="/api/user/send-otp-user",
     *     operationId="/api/user/send-otp-user",
     *     tags={"Post-Login User"},
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
     *                 example={"country_code": "+91", "phone_number": "9999999999"}
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
     *     path="/api/user/verify-otp-user",
     *     operationId="/api/user/verify-otp-user",
     *     tags={"Post-Login User"},
     *     description="verify phone-number and change phone number",
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
     *                 example={"country_code": "+91", "phone_number": "9999999999", "otp": "0000"}
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
     *     path="/api/user/send-verification-email",
     *     operationId="/api/user/send-verification-email",
     *     tags={"Post-Login User"},
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
     *     path="/api/user/my-loyalty-points",
     *     operationId="/api/user/my-loyalty-points",
     *     tags={"Post-Login User"},
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
     *     path="/api/user/generate-login-token",
     *     operationId="/api/user/generate-login-token",
     *     tags={"Checkout"},
     *     description="token for open page in web view or web browser",
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="Product Id",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="store_id",
     *         in="query",
     *         description="store id",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="order_id",
     *         in="query",
     *         description="order Id",
     *         required=false,
     *         @OA\Schema(type="string")
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
     *     path="/api/user/update-location",
     *     operationId="/api/user/update-location",
     *     tags={"Post-Login User"},
     *     description="update user location",
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
     *                  @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 example={"longitude": "XXXXXXX", "latitude": "YYYYYYYYY", "address": "zzzz"}
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
     *     path="/api/user/update-device-token",
     *     operationId="/api/user/update-device-token",
     *     tags={"Post-Login User"},
     *     description="update device token",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="device_token",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="device_type",
     *                     type="string"
     *                 ),
     *                 example={"device_token": "XXXXXXX", "device_type": "ios/android"}
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
     *     path="/api/user/my-notifications",
     *     operationId="/api/user/my-notifications",
     *     tags={"User Notification"},
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
     *     path="/api/user/read-notification/{notficationId}",
     *     operationId="/api/user/read-notification/{notficationId}",
     *     tags={"User Notification"},
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



    /**
     * @OA\Put(
     *     path="/api/user/toggle-notification/{push_status}",
     *     operationId="/api/user/toggle-notification/{push_status}",
     *     tags={"User Notification"},
     *     description="user toggle notification, push_status can be `active`  or `blocked`",
     *     @OA\Parameter(
     *         name="push_status",
     *         in="path",
     *         description="can be `active`  or `blocked`",
     *         required=true,
     *         @OA\Schema(type="string")
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
     *     path="/api/user/logout",
     *     operationId="/api/user/logout",
     *     tags={"Post-Login User"},
     *     description="logout user",
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
