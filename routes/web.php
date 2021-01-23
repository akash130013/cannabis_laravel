<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
// URL::forceScheme('https');
// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
Route::get('/login', function(){
    return redirect()->route('users.login');
});


// Route::domain(env('ADMIN_DOMAIN','admin.420kingdom.com'))->group(function () {
//     Route::get('/', function () {        
//         return redirect('/admin');    
//     });
// });
// Route::domain(env('STORE_DOMAIN','store.420kingdom.com'))->group(function () {
//     Route::get('/', function () {        
//         return redirect('/store');    
//     });
// });
// Route::domain(env('USER_DOMAIN','www.user.420kingdom.com'))->group(function () {
//     Route::get('/', function () {        
//         return redirect('/user');    
//     });
// });





Route::prefix('admin')->group(function () {
    Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    /*
    |
    | route for password reset
    |
    */
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});


/*
|
| store routes for session handling.
|
*/

    Route::prefix('store')->group(function () {
        Route::get('/', 'Auth\StoreLoginController@showLoginForm')->name('store.login');
        Route::post('/login', 'Auth\StoreLoginController@login')->middleware('checkstatus:store')->name('store.login.submit');
        Route::get('/logout', 'Auth\StoreLoginController@logout')->name('store.logout');
        
        /***
         * Static pages
         * 
         * 
         */
        Route::get('/cms-page','StoreController@showStaticPage')->name('store.static.cms.page');

        /*
        |
        | route for password reset
        |
        */
        Route::post('/password/email', 'Auth\StoreForgotPasswordController@sendResetLinkEmail')->name('store.password.email');
        Route::get('/password/reset', 'Auth\StoreForgotPasswordController@showLinkRequestForm')->name('store.password.request');
        Route::post('/password/reset', 'Auth\StoreResetPasswordController@reset');
        Route::get('/password/reset/{token}', 'Auth\StoreResetPasswordController@showResetForm')->name('store.password.reset');
    });

Route::get('invalidfile', function () {
    return view('invalidfile');
})->name('invalidfile');






/*
|
| users auth routes
|
*/

Route::prefix('user')->group(function () {
    
    Route::get('/', 'Auth\UserLoginController@showHomePage')->name('users.home.page');
    // Route::get('/login', 'Auth\UserLoginController@showLoginForm')->name('users.login')->middleware('HandleCookie');
    Route::get('/login', 'Auth\UserLoginController@showLoginForm')->name('users.login');

    // Route::post('/login', 'Auth\UserLoginController@login')->middleware('checkstatus:users')->name('users.login.submit')->middleware('HandleCookie');
    Route::post('/login', 'Auth\UserLoginController@login')->middleware('checkstatus:users')->name('users.login.submit');
    
    Route::get('/logout', 'Auth\UserLoginController@logout')->name('users.logout');
    
    /*
    |
    | route for password reset
    |
    */
    Route::post('/password/email', 'Auth\UserForgotPasswordController@sendResetLinkEmail')->name('users.password.email');

    Route::get('/password/otp/{params?}', 'Auth\UserForgotPasswordController@sendOtpPage')->name('users.password.otp');
    Route::get('/otp/{params}', 'Auth\UserForgotPasswordController@otpForm')->name('users.otp');
    Route::get('/resent-mobile-verification-otp', 'Auth\UserForgotPasswordController@ResentMobileOTPcode')->name('users.otp.resend.mobile');
    Route::get('/update-mobile-otp', 'Auth\UserForgotPasswordController@submitMobileVerification')->name('user.verify.password.otp');
    
   
    Route::post('/password/reset', 'Auth\UserForgotPasswordController@resetPassword')->name('user.reset.password');


    Route::get('/password/reset', 'Auth\UserForgotPasswordController@showLinkRequestForm')->name('users.password.request');
    // Route::post('/password/reset','Auth\UserResetPasswordController@reset');
    
    Route::get('/password/reset/{token}', 'Auth\UserResetPasswordController@showResetForm')->name('users.password.reset');
});

