<?php

use Illuminate\Support\Facades\Route;

$module_namespace = "App\Modules\User\Controllers";


Route::namespace($module_namespace)->group(function () {

    Route::domain(env('USER_DOMAIN','www.user.420kingdom.com'))->group(function () {

        Route::get('user/check-message-status','WebhookController@getStreamedResponse')->name('user.message.status');

        Route::middleware('web')->group(function () {
            Route::get('user/app-redirect/{token}', 'AppUserController@appRedirect');
            Route::get('user/verify/email/{token}','DashboardController@verifyEmail')->name('user.verify.email');
            Route::post('/user/submit-contact-us-route','SettingController@contactUs')->name('user.submit.contactus');
        });

        
        // Route::middleware(['web','guest:users','HandleCookie'])->group(function(){
        Route::middleware(['web','guest:users'])->group(function(){

            Route::get('/', 'HomeController@index')->name('user.home');
            Route::post('coming-soon', 'HomeController@comingSoon')->name('user.coming-soon');
            Route::get('user/guest', 'GuestController@index')->name('user.guest');
            Route::get('user/register', 'HomeController@RegisterUser')->name('user.register'); // guest
            Route::get('login', 'GuzzleUserClient@index')->name('guest.login');   ///for the guest

            /**for mail */
            Route::get('user/show-password-otp-verification/{params}','HomeController@showOtpVerificationForm')->name('user.show.otp.verification.page'); //guest

            //**for mobile  */

            Route::get('user/register-step-three','HomeController@ShowThreeStep')->name('user.register.step-three');
            Route::get('user/referal','HomeController@checkReferalValidity')->name('user.referal.validity');
            Route::get('user/resent-otp','HomeController@ResendOTP')->name('user.reset.password.resend');
            Route::post('user/update-webhook-status','WebhookController@handleMessageStatus')->name('user.webhook.twilio');

            // Static pages routes
            Route::get('user/terms-conditions','SettingController@showExteriorTermsAndConditions')->name('user.terms-condition.page');
            Route::get('user/terms-privacy-policy','SettingController@showExteriorPrivacyPolicy')->name('user.privacy-policy.page');
            Route::get('user/help','SettingController@showExteriorHelpPage')->name('user.help.page');
            Route::get('user/contact-us','SettingController@showExteriorContactPage')->name('user.contact-us.page');
            Route::get('user/about_us','SettingController@showExteriorAboutPage')->name('user.about.page');
            
            //Signup process
             Route::get('user/show-otp-form/{params?}','HomeController@ShowSecondStep')->name('user.show.otp.verification');
            Route::get('user/show-user-mobile-verification-page/{params}','HomeController@showMobileVerificationOtpPage')->name('users.show.mobile.otp.verification.page'); //guest
            Route::get('user/resent-mobile-verification-otp','HomeController@mobileOTPcode')->name('users.reset.password.resend.mobile');
            Route::get('user/submit-mobile-otp','HomeController@submitMobileVerification')->name('users.verify.mobile.otp');
           
        });
        




        // SIGNUP PROCESS ROUTES :START

        Route::group(['prefix' => 'user','middleware' => ['web','revalidate','auth:users','checkage:users']], function () {
            Route::get('/age/verification','DashboardController@showAgeVerificationPage')->name('users.age.verification');
            Route::get('/save-proof','DashboardController@userDocumentProof')->name('users.save.proof'); //guest
            Route::get('/location','DashboardController@showDeliveryLocation')->name('user.show.delivery.page'); //guest
            Route::get('/submit-user-delivery-location','DashboardController@userLocationDetails')->name('submit.user.delivery.location'); //guest
        });


        Route::middleware(['web','auth:users','revalidate','checkUserStatus:users'])->group(function () {
            /*
            |
            | dashboard and verification routes after logins.
            |
            */
            Route::get('user/home','DashboardController@index')->name('users.dashboard');
            Route::get('user/mobile-verification','DashboardController@showMobileRegistration')->name('users.register.mobile');
            Route::get('user/submit-mobile-verification','DashboardController@RegisterMobileNumber')->name('users.submit.mobile');
            Route::get('user/deletefiles3', array('before' => 'csrf', 'uses' => 'CommonAjaxController@deleteFileS3'));
            Route::get('user/update-current-location','HomeController@updateCurrentLocation')->name('user.update.current.location');
                /**
                 * Product routes
                 *
                 */
                Route::get('user/product','ProductController@allProduct')->name('users.product.category');
                Route::get('user/trending/product','ProductController@trendingProduct')->name('users.product.trending');
                Route::get('user/category/product/{id?}','ProductController@categoryProduct')->name('users.category.product');
                Route::get('user/product/detail/{id?}/{store_id?}','ProductController@productDetail')->name('users.product.detail');
                Route::get('user/product/near-store/{product_id}','ProductController@productNearStore')->name('users.product.near.store');
                Route::post('user/add-to-card','ProductController@addToCart')->name('user.add.data.to.cart');
                Route::get('user/clear-cart-add','ProductController@clearCardAdd')->name('user.clear.cart.add');

                /**
                 * Store routes
                 */
                Route::get('user/store','StoreController@index')->name('users.product.store');
                Route::get('user/store/map','StoreController@storeMap')->name('users.store.map');
                Route::get('user/store/detail/{id?}','StoreController@storeDetail')->name('users.store.detail');
                Route::get('user/store/product/{id?}','StoreController@storeProduct')->name('users.store.product');
                Route::get('user/store/review/{id?}','StoreController@storeProductReview')->name('users.store.review');

                /*
                |
                | define setting page routes
                |
                */

                Route::get('user/profile','SettingController@index')->name('user.show.setting.page');

                Route::get('user/change-password','SettingController@showChangePassword')->name('user.change.password');
                Route::post('user/update-password','SettingController@updatePassword')->name('user.update.password');

                Route::get('user/change-mobile','SettingController@showChangePhoneNumber')->name('user.change.mobile');
                Route::get('user/show-change-address','SettingController@showChangeAddress')->name('user.show.change.address');
                Route::get('user/show-terms-conditions','SettingController@showTermsAndConditions')->name('user.show.terms-condition.page');
                Route::get('user/show-terms-privacy-policy','SettingController@showPrivacyPolicy')->name('user.show.privacy-policy.page');
                Route::get('user/show-help','SettingController@showHelpPage')->name('user.show.help.page');
                Route::get('user/show-contact-us','SettingController@showContactUsPage')->name('user.show.contact-us.page');
                Route::get('user/show-faq','SettingController@showFaqPage')->name('user.show.faq.page');
                Route::get('user/about-us','SettingController@showAboutUsPage')->name('user.show.about-us.page');

                Route::get('user/edit-account-info','SettingController@editAccountInfo')->name('user.edit.account.information');
                Route::post('user/update-account-info','SettingController@updateAccountInfo')->name('submit.user.account.info');
                Route::post('user/update-mobile-number','SettingController@updateMobile')->name('submit.update.password');
                Route::get('user/add-user-address','SettingController@addDeliveryAddress')->name('add.user.delivery.address');
                Route::get('user/edit-form','SettingController@showDeliveryLocationPage')->name('user.get.edit.form');
                Route::get('user/edit-address','SettingController@updateAddress')->name('edit.user.delivery.address');
                Route::get('user/remove-address','SettingController@deleteAddress')->name('user.remove.address');

                Route::get('user/send/otp','SettingController@mobileOTPcode')->name('user.send.otp');
                Route::get('user/mail/otp','SettingController@sendEmailOTP')->name('user.email.otp');
                Route::post('user/update-email','SettingController@updateEmail')->name('user.update.email');
                Route::get('user/verify/email','SettingController@verifyEmail')->name('user.email.verify');

                /**
                 * Global search
                 */
                Route::get('user/global-search','DashboardController@globalSearch')->name('user.global-search');
                Route::post('user/save-recent-search','DashboardController@saveSearch')->name('user.save.recent-search');
                

                /*
                |
                | define wish list routes
                |
                */

                Route::get('user/wish-list','WishListController@index')->name('user.show.wish.list');
                Route::post('user/update-wish-list','WishListController@updateWishList')->name('user.wishlist.action');
                Route::get('user/bookmark-list','WishListController@bookmarkList')->name('user.wishlist.bookmark.list');
                /*****
                 *
                 * Profile update of user profile pic
                 *
                 *
                 *
                 */
                Route::post('user/upload-profile-pic','SettingController@uploadProfilePic')->name('user.upload.profile.pic');

                /***
                 * Cancel & Re- order
                 *
                 *
                 */
                Route::post('/user/cancel-order','OrderController@cancelOrder')->name('user.cancel.order');
                Route::post('/user/re-order','OrderController@reOrder')->name('user.reorder');

                /***
                 *
                 *
                 *
                 */
                /**
                 * define cart routes
                 */

                Route::get('user/cart-list','CartController@index')->name('user.show.cart.list');
                Route::post('user/remove-from-cart','CartController@removeFromCart')->name('user.cart.remove.item');
                Route::get('user/validate-promo-code','CartController@validatePromoCode')->name('user.validate.promo.code');
                Route::post('user/remove-coupon-code','CartController@removeCouponCode')->name('user.remove.coupon.code');
                Route::get('user/update-quantity','CartController@updateQuantityItem')->name('user.update.quantity');
                Route::get('user/checkout-delivery-address','CartController@showDeliveryAddress')->name('user.checkout.delivery.address');
                Route::get('user/show-add-delivery-address','CartController@showAddDeliveryLocation')->name('user.add.new.delivery.address');
                Route::get('user/show-final-delivery-confirmation','CartController@showFinalDeliveryConfirmation')->name('user.select.delivery.location');
                Route::get('user/show-place-order-page','CartController@showFinalOrderProces')->name('user.show.place.order');
                Route::get('user/update-cart-delivery-address','CartController@addDeliveryAddressFromCart')->name('add.user.cart.delivery.address');
                Route::get('user/place-order','CartController@placeFinalOrder')->name('user.place.order');

                /**
                 * orderlisting routes
                */
                Route::get('user/orders','OrderController@index')->name('user.order.listing');
                Route::get('user/rating','OrderController@submitRating')->name('user.rating.submit');
                Route::get('user/track/order','OrderController@trackMyOrder')->name('user.order.track');


                /**
                 * loyality point routes
                 */
                Route::get('user/loyalty-point','LoyalityController@index')->name('user.loyality-point.listing');
                Route::get('user/loyalty-point-redumption','CartController@useLoyaltyPoint')->name('user.loyality-point.redumption');




                /**
                 * @deals routes
                 */

                Route::get('user/product/deals','DealsController@index')->name('user.product.deal.list');

        });
    });

});
