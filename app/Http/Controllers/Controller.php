<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPointTransaction;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Modules\User\Controllers\GuzzleUserClient;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\User\Models\UserDetail;
use Illuminate\Support\Facades\Session;

 class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $userClient = null;

    protected $userAddress = null;

    protected $userDetail = null;

    protected $cartDetails = null;

    protected $loyaltyPoint = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $user = Auth::guard("users")->user();
            

            if (!is_null($user)) {    //for the web user

                $token = $user->createToken(trans('Cannabies.AppName'))->accessToken;

                $this->userClient = new GuzzleUserClient($token);

                $this->userAddress = Auth::guard('users')->user()->getuser;
               
                $this->userDetail = UserDetail::where('user_id', $user->id)->first();
                  
                $this->loyaltyPoint = @round(LoyaltyPointTransaction::where('user_id', $user->id)->latest()->first()->net_amount,2);
               
                $this->cartDetails = $this->userClient->get('/api/user/my-cart-count', []);
                 info($this->cartDetails);
                Session::put('userdetail', $this->userDetail);

                Session::put('cartdetail', $this->cartDetails);

                Session::put('loyaltyPoint', $this->loyaltyPoint);

            }
            return $next($request);
        });
    }
}
