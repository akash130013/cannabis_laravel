<?php

namespace App\Modules\User\Controllers;

use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuzzleUserClient
{

    /**
     * protected url
     */

    protected $url = null;


    /**
     * protected method
     */

    protected $method = null;


    /**
     * protected endpoint
     */

    protected $endpoint = null;

    /**
     * protected header
     */

    public $header = null;

    /**
     * protected params
     */

    public $params = null;

    /**
     * protected client
     */
    protected $client = null;



    public function __construct($token = "")
    {

        $this->url = url('/');

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->url,
            'verify' => false,
            'http_errors' => false
        ]);

        $this->header = $this->setHttpHeader($token);
    }


  /**
   * index function
   *@desc after login
   * @param Request $request
   * @return void
   */
    public function index(Request $request){
        return redirect()->route('users.dashboard');
    }

    /**
     * Get
     * @param : null
     * @return : application/json
     */


    public function get($endpoint, $params = [])
    {
        try {

            $this->endpoint = $endpoint;

            $this->params  = $params;

            $response =  $this->client->get($this->endpoint, [

                'headers' => $this->header,

                'query' => $this->params

            ]);
               
            $jsonBody = $response->getBody();


        } catch (BadResponseException $ex) {

            $response = $ex->getResponse();

            $jsonBody = (string) $response->getBody();
        }

        return ['code' => $response->getStatusCode(), 'response' => json_decode($jsonBody, true)];

    }


    /**
     * post
     * @param : post array
     * @return : application/json
     */

    public function post($endpoint, $params)
    {
       try
       {
       
        $this->endpoint = $endpoint;

        $this->params  = $params;
      
        $response =  $this->client->post($this->endpoint, [

            'headers' => $this->header,

            'json' => $this->params

        ]);

        $jsonBody = $response->getBody();


    } catch (BadResponseException $ex) {

        $response = $ex->getResponse();

        $jsonBody = (string) $response->getBody();
    }

    return ['code' => $response->getStatusCode(), 'response' => json_decode($jsonBody, true)];

    }

    /**
     * setHttpHeader
     * @param : bearer token if available
     * @return : array with bearer token
     */

    public function setHttpHeader($token = null)
    {
          
        // $guestLogin = [
        //     'country_code' => "+91",
        //     "phone_number" => "9720934398",
        //     "password" => "1J@n9720",
        //     'device_type'=>"android",
        // ];
       
        if(empty($token)) {
            $user = Auth::guard("users")->loginUsingId(config('constants.GuestUserId'));// check if guest
            $user->accessToken = $user->createToken(trans('Cannabies.AppName'))->accessToken;
            $newUser=new \stdClass();
            $newUser->code=Response::HTTP_OK;
            $newUser->response=[
                    'status'=>'success',
                    'message'=>null,       
                    'data'=>
                                    [
                                        "id" => $user->id,
                                        "name" => 'Guest',
                                        "user_type"=>2,
                                        "user_referral_code" => null,
                                        "dob" => null,
                                        "profile_pic" => null,
                                        "lat" => null,
                                        "lng" => null,
                                        "country_code" => null,
                                        "phone_number" => null,
                                        "email" => null,
                                        "location_updated_at" => null,
                                        "status" => "active",
                                        "referred_by" => null,
                                        "is_email_verified" => false,
                                        "net_loyaltyPoints" => null,
                                        "user_proof" => [],
                                        "accessToken" => $user->accessToken,     
                                    ]
                            ];

        }else{
            $newUser=$this->returnHttpHeaderWithBearerToken($token);
        }

        // dd($newUser);
        // $this->header = empty($token) ? $this->userLoginAttempt($guestLogin) : $this->returnHttpHeaderWithBearerToken($token);
        
        // dd($this->header);
        // if (isset($this->header['code']) && ($this->header['code'] != Response::HTTP_OK)) {
        //     return $this->header;
        // }
        // dd($newUser);
        // dd($newUser->code);
        if (isset($newUser->code) && ($newUser->code != Response::HTTP_OK)) {
            return $newUser;
        }

        // $token = $this->header['response']['data']['accessToken'] ?? $token ;
        $token = $newUser->response['data']['accessToken'] ?? $token ;
        // dd($token);
       
        return $this->returnHttpHeaderWithBearerToken($token);
    }

    /**
     * returnHttpHeaderWithBearerToken
     * @param : token
     * @return : array with header set to the send bearer token
     * 
     */

    public function returnHttpHeaderWithBearerToken($token)
    {

        return  [

            'Authorization' => 'Bearer ' . $token,
            'Accept'     => 'application/json',
            'Content-Type' => 'application/json'

        ];
    }


    /**
     * userLoginAttempt
     * @param : guest login credentials
     * @return : application/json
     */

    public function userLoginAttempt($guestLogin)
    {
        try {
        
            $this->endpoint = "/api/login";

            $this->params   = $guestLogin;

            $response = $this->client->post($this->endpoint, ['form_params' => $this->params, 'Content-Type' => 'application/x-www-form-urlencoded', 'auth' => [env('AUTH_USER'), env('AUTH_PASS')]]);

            $jsonBody = $response->getBody();

        } catch (BadResponseException $ex) {

            $response = $ex->getResponse();

            $jsonBody = (string) $response->getBody();
        }

        return ['code' => $response->getStatusCode(), 'response' => json_decode($jsonBody, true)];
    }
}
