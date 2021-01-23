<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('terms-conditions', 'CmsController@staticPage');
Route::get('privacy-policy', 'CmsController@staticPage');
Route::get('about-us', 'CmsController@staticPage');
Route::get('help', 'CmsController@showExteriorHelpPage');
Route::get('contact-us', 'CmsController@staticPage');
Route::get('faq', 'CmsController@staticPage');
Route::post('contact-query', 'Api\User\ContactController@query')->middleware('throttle:10,1');


Route::middleware('BasicStaticAuth')->group(function () {
    Route::post('register', 'Api\Auth\RegisterController@register');
    Route::post('login', 'Api\Auth\LoginController@login');
    Route::post('forgot-password', 'Api\Auth\ForgotPasswordController@sendOTP');
    Route::post('verify-forgot-otp', 'Api\Auth\ForgotPasswordController@verifyOtp');
    Route::post('reset-password', 'Api\Auth\ForgotPasswordController@resetPassword');
    Route::post('send-user-otp', 'Api\Auth\RegisterController@sendOTP');
    Route::post('verify-user-otp', 'Api\Auth\RegisterController@verifyOTP');

    Route::post('distributor/login', 'Api\Auth\DistributorLoginController@login');
    Route::post('distributor/forgot-password', 'Api\Auth\DistributorForgotPasswordController@sendOTP');
    Route::post('distributor/verify-forgot-otp', 'Api\Auth\DistributorForgotPasswordController@verifyOtp');
    Route::post('distributor/reset-password', 'Api\Auth\DistributorForgotPasswordController@resetPassword');
});


/**
 * @desc acces by the registered user
 */
Route::prefix('/user')->middleware(['multiauth:api'])->namespace('Api\User')->group(function () {
    // send verification email
    Route::post('send-verification-email/{id?}', 'EmailController@sendVerificationEmail');
    Route::post('update-device-token', 'UserController@updateDeviceToken');  //update devie token for push notification
    Route::get('categories', 'CategoryController@index');
    Route::get('all-categories', 'CategoryController@allCategory');

    Route::post('logout', 'UserController@logout');

    Route::get('trending-products', 'ProductController@trendingProducts');
    Route::post('get-nearby-stores', 'StoreController@getNearStores');

    Route::post('store-products', 'ProductController@storeProducts');
    Route::post('product-detail', 'ProductController@storeProductById');
    Route::post('get-similar-products', 'ProductController@fetchSimilarProduct');

    Route::get('add-to-wishlist/{productId}', 'WishListController@store');
    Route::get('remove-from-wishlist/{productId}', 'WishListController@destroy');
    Route::get('my-wishlist', 'WishListController@index');

    Route::get('create-bookmark-store/{storeId}', 'BookmarkController@store');
    Route::get('remove-bookmark-store/{storeId}', 'BookmarkController@destroy');
    Route::get('my-bookmark', 'BookmarkController@index');
    Route::get('store-detail/{storeId}', 'StoreController@show');
    Route::post('get-stores-by-productId', 'StoreController@fetchStoreByProductId');

    Route::post('global-search', 'SearchController@index');

    Route::post('change-password', 'UserController@changePassword');
    Route::get('my-profile', 'UserController@viewProfile');
    Route::post('update-profile', 'UserController@updateProfile');
    Route::post('update-location', 'UserController@updateLocation');
    Route::post('send-otp-user', 'UserController@sendOTPUser');
    Route::post('verify-otp-user', 'UserController@verifyOTPUser');
    Route::post('change-phone', 'UserController@changePhone');

    Route::post('add-to-cart', 'CartController@addToCart');
    Route::get('remove-cart-item/{cartUid}', 'CartController@removeCartItem');
    Route::get('show-cart', 'CartController@showCart');
    Route::post('update-item', 'CartController@update');
    Route::get('my-cart-count', 'CartController@cartCount');
    Route::get('my-delivery-addresses', 'DeliveryController@showAddress');
    Route::post('save-delivery-location', 'DeliveryController@saveAddress');
    Route::post('update-delivery-location', 'DeliveryController@updateAddress');
    Route::delete('delete-delivery-location/{id}', 'DeliveryController@destroyAddress');
    Route::post('clear-cart-add-item', 'CartController@clearCartAddItem'); // clear cart and add current item into cart

    Route::get('show-promo-codes', 'CartController@getPromoCodes');
    Route::get('create-order/{userId?}', 'CartController@createOrder');
    Route::post('update-order-delivery-address', 'CartController@updateOrderDeliveryAddress');
    Route::post('apply-coupon-code', 'CartController@applyPromoCode');
    Route::post('remove-coupon-code', 'CartController@removePromoCode');
    Route::post('schedule-order', 'CartController@scheduleOrder');
    Route::post('redeem-loyalty-points', 'CartController@redeemLoyaltyPoints');
    Route::post('remove-loyalty-points', 'CartController@removeLoyaltyPoints');
    Route::post('place-order', 'OrderController@placeOrder');
    Route::get('my-orders', 'OrderController@index');
    Route::get('order-detail/{orderUid}', 'OrderController@show');
    Route::get('my-loyalty-points', 'UserController@loyaltyPoints');
    Route::get('track-order/{orderUid}', 'OrderController@trackOrder');


    Route::post('rate-order', 'RatingController@store');
    Route::post('rate-order-bulk', 'RatingController@saveBulkRating');
    Route::get('fetch-rating', 'RatingController@index');
    Route::get('generate-login-token', 'UserController@genenerateLoginToken');
    Route::get('get-loyalty-points-exchange-info', 'CartController@getLoyaltyPointExchangeInfo');
    Route::post('cancel-order', 'OrderController@cancelOrder');
    Route::post('re-order', 'OrderController@reOrder');
    Route::get('my-notifications', 'NotificationController@myNotifications');
    Route::put('read-notification/{id}', 'NotificationController@readNotification');
    Route::post('save-search', 'SearchController@store');
    Route::put('toggle-notification/{status}', 'NotificationController@toggleNotification');
});


Route::prefix('/distributor')->middleware('multiauth:distributor')->namespace('Api\Distributor')->group(function () {
    Route::post('update-device-token', 'DistributorController@updateDeviceToken');
    Route::get('view-profile/{id?}', 'DistributorController@show');
    Route::get('my-reviews', 'OrderController@myReviews');
    Route::post('update-profile', 'DistributorController@update');
    Route::post('change-password', 'DistributorController@changePassword');
    Route::post('send-otp-distributor', 'DistributorController@sendOTPDistributor');
    Route::post('verify-otp-distributor', 'DistributorController@verifyOTPDistributor');
    Route::post('my-orders', 'OrderController@index');
    Route::get('order-detail/{orderUid}', 'OrderController@show');
    Route::post('change-order-status', 'OrderController@changeOrderStatus');
    Route::post('update-location', 'DistributorController@updateLocation');
    Route::post('logout', 'DistributorController@logout');
    Route::get('my-notifications', 'NotificationController@myNotifications');
    Route::put('read-notification/{id}', 'NotificationController@readNotification');
});
