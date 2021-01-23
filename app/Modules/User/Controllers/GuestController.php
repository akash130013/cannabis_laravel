<?php


namespace App\Modules\User\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;




class GuestController extends Controller
{

        /**
         * index
         * @param : null

         */

         public function index(Request $request)
         {
           
                   
             try {
                //  $lat = $request->get('lat');
                //  $lng = $request->get('lng');
                //  $userId = Auth::guard('users')->user()->id;
                 
                //  $userData = UserDetail::where('user_id', $userId)->first();
                //  $userData->formatted_address = $request->get('formatted_address');
                //  $userData->zipcode = $request->get('postal_code', '');
                //  $userData->ip = $request->get('ip', '');
                //  $userData->lat = $lat;
                //  $userData->lng = $lng;
                //  $userData->save();
                //  dd($request->all(),$request->lat);
                Session::put('userdetail', $request->all());

                // Session::put('cartdetail', $this->cartDetails);

                 $response = [
                                'code' => Response::HTTP_OK,
                                'message' => trans('User::home.user_location_updated'),
                                'user_type'=> config('constants.USER.GUEST'),
                           ];
           
               } catch (Exception $e) {
                 $response = [
                   'code' => $e->getCode(),
                   'message' => $e->getMessage()
                 ];
               }
           
               return response()->json($response);
    }
            
         }


