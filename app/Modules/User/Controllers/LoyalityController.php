<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Exception;



class LoyalityController extends Controller
{

    /**
     * index
     * @param : null

     */

    public function index(Request $request)
    {

        try {

            $query = Input::get();
            if (empty($query)) {
                $query['type'] = '';
            }

            $param = [
                'type' => $request->input('type', ''),
                'page' =>  $request->input('page'),
            ];

            $loyaltyList = $this->userClient->get(config('userconfig.ENDPOINTS.LOYALITY_POINT.SHOW'), $param);

            $loyaltyPoint = $this->userClient->get(config('userconfig.ENDPOINTS.LOYALITY_POINT.DETAIL'));

            return view('User::loyality-point.index', compact('loyaltyList', 'query', 'loyaltyPoint'));
        } catch (Exception $e) {

            return CommonHelper::handleException($e);
        }
    }
}
