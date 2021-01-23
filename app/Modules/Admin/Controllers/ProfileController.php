<?php


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\CannabisLog;
use Hash;

class ProfileController extends Controller
{

    /**
     * showing admin user basic profile
     * @param : null
     * @return : application/html
     * 
     */

     public function profile()
     {
         $user = Auth::guard('admin')->user();
         $user->profile_pic = $user->avtaar??config('constants.DEAFULT_IMAGE.STORE_IMAGE');
         return view('Admin::profile.profile',compact('user'));
     }


     /**
      * to update admin user password
      * @params request
      * @return  json
      */
      public function changePassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'old_password'  => 'required|string|min:6',
                'password'      => 'required|string|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                return Redirect::back()->with('errors', $validator->errors())->withInput();
            }
            $user = Auth::guard('admin')->user();

            if (!Hash::check($request->old_password, $user->password)) 
            {
   
                return Redirect::back()->withErrors(['old_password'=>trans('Admin::messages.old_password_error')])->withInput();
            }
            if (Hash::check($request->password, $user->password)) 
            {

                return Redirect::back()->withErrors(['password'=>trans('Admin::messages.same_password_error')])->withInput();
            }
            $user->update(['password' => bcrypt($request->password)]);
            return Redirect::back()->with(['message' => trans('Admin::messages.password_changed_success'), 'type' => 'success']);

        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with('errors', $response);
        }
    }
}