<?php


namespace App\Modules\User\Controllers;

use Illuminate\Routing\Controller as BaseController;
//use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Modules\User\Models\UserDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class AppUserController
 * @package App\Modules\User\Controllers
 * @author Sumit Sharma
 */
class AppUserController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;
    protected $userClient = null;

    protected $userAddress = null;

    protected $userDetail = null;

    protected $cartDetails = null;

    /**
     * AppUserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * redirect from app to web
     * @param $loginToken
     * @param Request $request
     * @link product-detail api
     * @return void
     */
    public function appRedirect($loginToken, Request $request)
    {
        
        $loggedToken = $this->userService->getUserfromLoginToken($loginToken);
        if (!$loggedToken){
            abort(404);
        }
        
        $user = User::find($loggedToken->user_id);
        Auth::guard('users')->login($user);
        $token = $user->createToken(trans('Cannabies.AppName'))->accessToken;
        $this->userClient = new GuzzleUserClient($token);
        $this->userAddress = Auth::guard('users')->user()->getuser;
        $this->userDetail = UserDetail::where('user_id', $user->id)->first();
        $this->cartDetails = $this->userClient->get('/api/user/my-cart-count', []); 
        Session::put('userdetail', $this->userDetail);
        Session::put('cartdetail', $this->cartDetails);
        if (isset($loggedToken->product_id)) {
            return redirect()->route('users.product.detail', ['id' => encrypt($loggedToken->product_id)]);
        }elseif (isset($loggedToken->store_id)){
            return redirect()->route('users.store.detail', ['id' => encrypt($loggedToken->store_id)]);
        }

        return redirect()->route('user.show.cart.list') ;
    }


    public function productRedirect(Request $request)
    {
        dd($this->userClient->header['Authorization']);
        dd(Auth::guard('users')->user());

    }
}
