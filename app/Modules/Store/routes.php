<?php
use Illuminate\Support\Facades\Route;

$module_namespace = "App\Modules\Store\Controllers";

Route::namespace($module_namespace)->group(function () {
//   Route::domain(env('STORE_DOMAIN','store.420kingdom.com'))->group(function () {
    Route::middleware(['web','revalidate','guest:store'])->group(function () {
        Route::get('store/register', 'Home@RegisterStoreUser')->name('store.register.user');

        Route::get('store/show-step-registration', 'Home@showStepTwoRegistration')->name('store.show.step.two.registration');

        Route::get('store/register-step-two', 'Home@ShowSecondStep')->name('store.register.step-two');

        Route::get('store/show-password-form/{params}', 'Home@showPasswordVerificationForm')->name('store.show.password.verification');

        Route::get('store/show-password-otp-verification/{params}', 'Home@showPasswordOTPEmailForm')->name('store.show.password.verification.page');

        Route::get('store/register-step-three', 'Home@ShowThirdStep')->name('store.register.step-three');

        Route::get('store/register-step-four', 'Home@ShowFourStep')->name('store.register.step-four');

        Route::get('store/resent-otp', 'Home@ResendOTP')->name('store.reset.password.resend');
    });


    Route::middleware(['web','auth:store','revalidate','recentnotifications','checkstatus:store'])->group(function () {

        Route::get('store/dashboard', 'Dashboard@index')->name('store.dashboard');
        // Route::get('store/profile', 'Home@showStoreProfile');

        Route::get('store/mobile-verification', 'Dashboard@showMobileRegistration')->name('store.register.mobile');
        Route::get('store/submit-mobile-verification', 'Dashboard@RegisterMobileNumber')->name('store.submit.mobile');
        Route::get('store/resent-mobile-verification-otp', 'Dashboard@ResentMobileOTPcode')->name('store.reset.password.resend.mobile');

        Route::get('store/show-store-mobile-verification-page/{params}', 'Dashboard@showMobileVerificationOtpPage')->name('store.show.mobile.otp.verification.page');

        Route::get('store/submit-mobile-otp', 'Dashboard@submitMobileVerification')->name('store.verify.mobile.otp');
        Route::get('store/show-business-name-page', 'Dashboard@showBusinessNamePage')->name('store.show.business.name.page');

        Route::get('store/store-save-businessname', 'Dashboard@StoreBusinessName')->name('store.save.businessname');
        Route::get('store/store-save-proof', 'Dashboard@storeDocumentProof')->name('store.save.proof');


        Route::post('store/save-store-details', 'Dashboard@storeDetails')->name('submit.store.details');
        Route::get('store/remove-store-uploaded-images', 'Dashboard@removeUploadedImages')->name('store.remove.uploaded.images');

        Route::get('store/show-store-working-hours', 'Dashboard@storeShowHours')->name('store.show.working.hours');
        Route::post('store/save-working-hours', 'Dashboard@storeWorkingHours')->name('submit.store.working.hours');


        Route::post('store/save-store-images', 'Dashboard@storeImagesUpload')->name('save.store.images');
        Route::get('store/show-store-images', 'Dashboard@showStoreImagesPage')->name('show.store.images');


        Route::get('store/show-delivery-address-page', 'Dashboard@showDeliveryLocation')->name('store.show.delivery.page');

        Route::post('store/submit-store-delivery-location', 'Dashboard@storeSubmitStoreDeliveryAddress')->name('add.store.delivery.location');

        Route::get('store/remove-delivery-location-status', 'Dashboard@removeStoreDeliveryLocation')->name('remove.store.delivery.location');
        Route::get('store/update-delivery-location-status/{id}/{deleted?}', 'Dashboard@updateStoreDeliveryLocationStatus')->name('update.store.delivery.location.status');

        Route::get('store/submit-final-route', 'Dashboard@submitFinalProfile')->name('final-submit-profile');

        Route::group(['prefix' => 'store', 'middleware' => ['checkstorestatus']], function () {


            /***
             * Resoucre controller for profile pic
             * 
             */
            Route::resource('storeprofile', 'ProfileController');

             /*
            |
            | routes for product panel listing page
            |
            |
            */

            Route::get('product-listing', 'ProductController@index')->name('store.product.dashboard');
            Route::get('requested-product', 'ProductController@requestedProduct')->name('store.request.product.list');
            Route::get('product-show-add-product', 'ProductController@showAddProduct')->name('store.product.add-page');
            Route::get('ajax-request/show-product', 'ProductController@showProductList');
            Route::get('ajax-request/get-product-qty', 'ProductController@showQuantity');
            Route::get('ajax-request/get-product-images-data', 'ProductController@showDataImagesPrice');
            Route::get('ajax-request/submit-product-data', 'ProductController@submitStoreProductData');
            Route::get('product-detail/{id}', 'ProductController@showProductDetail')->name('show.product.detail');
            Route::get('product-detail/ajax-request/delete-product', 'ProductController@deleteStoreProduct')->name('store.product.delete');
            Route::get('requested/product/create', 'ProductController@requestedProductCreate')->name('store.request.product');
            Route::get('product-edit/{id}', 'ProductController@showEditProduct')->name('store.edit.product');
            Route::get('product-edit/ajax-request/submit-product-edit-data', 'ProductController@updateStoreProduct');
            Route::get('product-edit/ajax-request/get-product-add', 'ProductController@getProductAddMoreOptions');
            Route::get('list/status', 'CommonAjax@changeStatus')->name('store.list.status');
            Route::get('detail/status', 'CommonAjax@changeStatus')->name('store.detail.status');
            Route::get('product-search', 'ProductController@searchProduct')->name('store.product.list.search');


            /*
            |
            | location routes
            |
            */

            Route::get('location-list', 'LocationController@index')->name('store.location.list');
           
            /***
             * Driver Routes
             */
            Route::prefix('driver')->group(function () {
                Route::get('list', 'DriverController@index')->name('store.driver.list');
                Route::get('view', 'DriverController@driverView')->name('store.driver.view');
                Route::get('add', 'DriverController@create')->name('store.driver.create');
                Route::post('store', 'DriverController@store')->name('store.driver.save');
                Route::get('detail/{id}', 'DriverController@show')->name('store.driver.show');
                Route::get('edit/{id}', 'DriverController@edit')->name('store.driver.edit');
                Route::put('update/{id}', 'DriverController@update')->name('store.driver.update');
                Route::delete('change/{id}', 'DriverController@destroy')->name('store.driver.destroy');
                Route::get('/search', 'DriverController@searchDriver')->name('store.driver.search');
                Route::get('/check-existing','DriverController@checkExsitingDriverEmail')->name('store.driver.check.existing.email');
                Route::get('/check-password','DriverController@changeDriverPass')->name('store.driver.change.password');

            });

            /**
             * Order Routes
             */
            Route::prefix('order')->group(function () {
                Route::get('list', 'OrderController@index')->name('store.order.list');
                Route::get('add', 'OrderController@create')->name('store.order.create');
                Route::get('detail/{id}', 'OrderController@show')->name('store.order.show');
                Route::get('get-driver/{id}', 'OrderController@getDriverList')->name('store.order.driver-list');
                Route::get('get-driver-allocation/{id}', 'OrderController@getDriverAllocation')->name('store.order.driver-orders');
                Route::post('assign-to-driver/{id}', 'OrderController@assignToDriver')->name('store.order.assign-driver');
                Route::post('un-assign-driver', 'OrderController@unAssignDriver')->name('store.order.un-assign-driver');
                Route::put('update/{id}', 'OrderController@update')->name('store.order.update');
                Route::get('/search', 'OrderController@searchOrder')->name('store.order.search');
                Route::get('/driver/search', 'OrderController@searchOrderDriver')->name('store.order.search.driver');
                Route::put('/cancel-order/{id}', 'OrderController@cancelOrder')->name('store.cancel-order');


            });

            /**
             * Notification routes
             *
             */

            Route::get('notification-list','NotificationController@index')->name('store.notification.index');
            Route::get('/unread-notification-count','NotificationController@unreadNotificationCount')->name('store.notification.count');
            
            /**
             * upload profile pic
             */
            Route::post('upload-profile-pic','ProfileController@uploadProfilePic')->name('store.upload.profile.pic');


            /**
            * earning routes
            *
            */

            Route::get('earning-list','EarningController@index')->name('store.earning.list');
            Route::get('earning-search','EarningController@searchEarning')->name('store.search.earning');

            /**
             *   offer routes
             *
             */

            Route::get('offer-list','OfferController@index')->name('store.offer.list');
            Route::get('ajax-request/store-offer/show-product','OfferController@showOfferProducts')->name('store.show.offer.product.list');
            Route::get('ajax-request/store-offer/get-product-qyt','OfferController@getAddProductOfferHTML')->name('store.get.offer.html');
            Route::get('offer-add','OfferController@showAdd')->name('store.add.offer.page');
            Route::get('ajax-request/store-offer/add-more-offer','OfferController@getAddMoreOffersHtml')->name('store.get.offer.add.more.html');
            Route::post('ajax-request/update-offer/submit-product-offer-data','OfferController@updateOfferPrice');
            Route::post('ajax-request/store-offer/update-offer-date','OfferController@updateOfferDates')->name('store.update.product.offer.data');
            Route::get('ajax-request/store-offer/cancel-offer-status','OfferController@cancelOfferStatus')->name('offer.cancel.offer');
            // Route::get('show-edit-offer','OfferController@showEditOffer')->name('offer.edit');
            Route::get('ajax-request/store-offer/get-offer-edit-html','OfferController@getEditProductOfferHTML')->name('store.offer.edit.html');
            Route::get('offer-search','OfferController@searchOfferByName')->name('store.search.offer.product');

            /**
             * profile routes
             */

            Route::put('update-name/{id}', 'ProfileController@updateStoreName')->name('store.update.name');
            Route::put('update-desc/{id}', 'ProfileController@updateStoreDescription')->name('store.update.desc');
            Route::get('change-mobile','ProfileController@showChangeMobile')->name('store.show.change.mobile');
            Route::post('update-mobile-number','ProfileController@updateMobile')->name('submit.update.mobile');

            Route::get('edit-address','ProfileController@editUserAddress')->name('store.edit.address.html');
            Route::post('update-address','ProfileController@updateStoreAddress')->name('store.update.address');
            Route::get('send-email-notification','CommonAjax@sendEmailNotification')->name('store.send.otp.email');
            Route::post('update-email','ProfileController@updateStoreEmail')->name('update.store.email');
            Route::get('get-delivery-address','ProfileController@getDeliveryAddress')->name('store.get.delivery.address.html');
            Route::post('update-delivery-address','ProfileController@updateStoreWorkingHours')->name('store.update.delivery.address');

            /**
             * Change Password
             */
            Route::get('change-password', 'ProfileController@showChangePassword')->name('store.change.password.show');
            Route::post('update/password', 'ProfileController@changePassword')->name('store.update.password');

            /**
             * CMS pages
             */
            Route::get('static', 'ProfileController@showStaticPage')->name('store.cms');
            /**
             * update store image
             */
            Route::get('images','ProfileController@showStoreImage')->name('store.show.images');
            Route::post('update-store-images', 'ProfileController@updateStoreImage')->name('store.update.images');



            
        });

        Route::group(['prefix' => 'store'],function(){
            Route::post('submit-delivery-location', 'LocationController@storeSubmitStoreDeliveryAddress')->name('submit.store.delivery.location.list');
            Route::get('ajax-request/update-location-status', 'LocationController@updateLocationStatus');
            Route::get('ajax-get-store-zip-codes', 'LocationController@getDeliveryAddressZipcodes')->name('store.ajax.get.zip.code');
            Route::get('location-search', 'LocationController@searchLocation')->name('address.search.location');

        });
       


    });
//   });
});
