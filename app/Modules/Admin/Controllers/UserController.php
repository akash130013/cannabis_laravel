<?php

namespace App\Modules\Admin\Controllers;
use App\User as UserModel;
use App\Modules\Admin\Models\CannabisLog;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;



class UserController extends Controller
{
     /**
     * index
     * @param : null
     * @return : application/json
     */

    public function index(Request $request)
    {
        $promoCode = $request->get('search', null);
        return view('Admin::user.index',compact('promoCode'));

    }

        /**
     * show promocode detail screen
     * @param : get ID
     * @show promocode detail screen
     */

    public function show($id)
    {
       try 
       {
           try {
               $decryptId = decrypt($id);
           } catch (DecryptException $e) {
               abort(Response::HTTP_NOT_FOUND);
           }
           $data = UserModel::withCount('orders')->find($decryptId);
           if($data)
           {
               $data->load('userProof'); 
               $data->user_id = encrypt($data->id);
               $data->avtaar = $data->avatar ?? config('constants.DEAFULT_IMAGE.USER_IMAGE');
               return view('Admin::user.show',compact('data'));
           }
           abort(Response::HTTP_NOT_FOUND);
       } catch (QueryException $e) 
       {
           $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
           CannabisLog::create($response);  //inserting logs in the table
           return Redirect::back()->with(['message'=>trans('Admin::messages.error'),'type'=>'error']);
       }
      


    }

}
