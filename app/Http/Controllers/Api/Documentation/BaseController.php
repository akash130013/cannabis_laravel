<?php

namespace App\Http\Controllers\Documentation;

class BaseController
{
    /**
     * @OA\Info(
     *   title="Cannibies API Documentation",
     *   version="1.0",
     *   @OA\Contact(
     *     email="support@cannibies.com",
     *     name="Support Team"
     *   ),
     * ),
     * @OA\SecurityScheme(
     *     @OA\Flow(
     *         flow="clientCredentials",
     *         tokenUrl="oauth/token",
     *         scopes={}
     *     ),
     *     securityScheme="bearerAuth",
     *     in="header",
     *     type="http",
     *     description="Oauth2 security",
     *     name="Authorization",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     * )
     */

    /**
     * @OA\Schema(
     *   schema="success",
     *   type="object",
     *   description="Data Object",
     * )
     */

    /**
     *    @OA\SecurityScheme(
     *     securityScheme="basicAuth",
     *     in="header",
     *     type="http",
     *     description="basic security",
     *     name="Authorization",
     *     scheme="basic",
     *     bearerFormat="JWT",
     * )
     */
}
