<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\CommonHelper;
use App\Notifications\UserMailVerifyNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

/**
 * Class EmailController
 * @package App\Http\Controllers\Api\User
 * @author Sumit Sharma
 */
class EmailController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * EmailVerificaionController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * send verification email
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function sendVerificationEmail(Request $request, $id = null)
    {
        try {
            $id       = $id ?? $request->user()->id;
            $user     = $this->user->find($id);
            $time     = now()->addMinute(10);  //set validity of the url
            $token    = [
                'email' => $user->email,
                'time'  => $time,
            ];
            $encToken = encrypt($token);
            $user->notify(new UserMailVerifyNotification($encToken));  //send a url for the verification link
            $user->email_verified_at    = null;
            $user->email_verified_token = $encToken;
            if (!$user->save()) {
                return response()->jsend_error(new \Exception("Please try again to send verification mail"), $message = null);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            CommonHelper::catchException($exception);
        }

    }

}
