<?php

use Illuminate\Support\Facades\Route;

$module_namespace = "App\Modules\Admin\Controllers";

Route::namespace($module_namespace)->group(function () {
  Route::domain(env('ADMIN_DOMAIN','admin.420kingdom.com'))->group(function () {
      Route::group(['prefix' => 'admin', 'middleware' =>  ['web','auth:admin','revalidate']], function () {
          
        Route::get('/dashboard','HomeController@index')->name('admin.dashboard');
        Route::get('/product-details', 'HomeController@productDetails');
        
        /**Start:Users routes */
        Route::get('/user','UserController@index')->name('admin.user.index');
        Route::get('/user-list', array('uses' => 'AjaxController@UserData'))->name('admin.user.listing'); 
        Route::get('/user/show/{id?}', array('uses' => 'UserController@show'))->name('admin.user.show'); 
        /**End:Users routes */

        /**Start:Store routes */
        Route::get('/store','StoreController@index')->name('admin.store.index');
        Route::get('/store-list', array('uses' => 'AjaxController@StoreData'))->name('admin.store.listing'); 
        Route::get('/store/show/{id?}', array('uses' => 'StoreController@show'))->name('admin.store.show'); 
        Route::get('/store/requested','StoreController@showRequestedStoreData')->name('admin.store.request');
        Route::get('/store/requested-list','AjaxController@requestedStoreList')->name('admin.store.request.listing');
        Route::get('/store/get-delivery-locations/{storeId?}','StoreController@getDeliverLocations');
        Route::get('/store/open/settlement/{id}/{store_name}','StoreController@showOpenSettlement')->name('admin.store.open.settlement');
        Route::get('/store/open-settlement-list','AjaxController@settlementData')->name('store.open.settlement.list');
        Route::get('/store/history/settlement/{id}/{store_name}','StoreController@showStoreSettlementHistory')->name('admin.store.history.settlement');
        Route::get('/store/history-settlement-list','AjaxController@settlementData')->name('store.history.settlement.list');
        /**End:Store routes */

        /**Start:Promocode routes */
        Route::get('/promocode','PromocodeController@index')->name('admin.promocode.index');
        Route::get('/promocode-list', array('uses' => 'AjaxController@PromocodeData'))->name('admin.promocode.listing'); 
        Route::get('/promocode/add/{id?}','PromocodeController@add')->name('admin.promocode.create');
        Route::get('/promocode/show/{id?}','PromocodeController@show')->name('admin.promocode.show');
        Route::post('/promocode/store', 'PromocodeController@store')->name('admin.promocode.store');

        // Route::get('admin/store/show/{id?}', array('uses' => 'UserController@show'))->name('admin.store.show'); 
        /**End:promcode routes */

        /**Deliver Location management:start */
        Route::get('/deliver-location-list',array('uses' => 'AjaxController@deliverLocationData'))->name('admin.deliver.location.listing');
        /**start category routes */
        Route::get('/category','ProductCategoryController@index')->name('admin.category.index');
        Route::get('/category/create','ProductCategoryController@create')->name('admin.category.create');
        Route::post('/category/store', 'ProductCategoryController@store')->name('admin.category.store');
        Route::get('/category-list', array('uses' => 'AjaxController@CategoryData'))->name('admin.category.listing'); 
        Route::get('/category/show/{id?}', array('uses' => 'ProductCategoryController@show'))->name('admin.category.show'); 
        Route::get('/category/edit/{id?}', array('uses' => 'ProductCategoryController@edit'))->name('admin.category.edit'); 
        Route::post('/category/update/{id?}', array('uses' => 'ProductCategoryController@update'))->name('admin.category.update'); 
        /**end categroy routes*/

        /**Prodcut routes */
        Route::get('/show-products','ProductController@index')->name('admin.product.listing');
        Route::post('/store-product','ProductController@storeProducts')->name('admin.store.products');
        Route::get('/product/add', 'ProductController@showAddProduct')->name('admin.show.add.product');
        Route::get('/product-list', array('uses' => 'AjaxController@productData'))->name('product.listing'); 
        Route::get('/product/show/{id?}', array('uses' => 'ProductController@show'))->name('product.show'); 
        Route::get('/product/edit/{id}', 'ProductController@edit')->name('admin.product.edit'); 
        Route::post('/product/update/{id?}', array('uses' => 'ProductController@update'))->name('product.update'); 
        Route::get('/product/ratings/{id?}','ProductController@showProductRatings')->name('admin.product.rating');
        Route::get('/product/rating-list','AjaxController@getProductRatingList')->name('admin.product.rating.list');
        /**end product routes */
            

        /**Start:Ordes routes */
        Route::get('/order','OrderController@index')->name('admin.order.index');
        Route::get('/order-list', array('uses' => 'AjaxController@orderList'))->name('admin.order.listing'); 
        Route::get('/order/show/{id?}', 'OrderController@show')->name('admin.order.show'); 
        /**End:Orders routes */
    
        /**request product routes */
        Route::get('/product/request','ProductRequestController@index')->name('admin.product.request');
        Route::get('/product/request/edit/{id?}', array('uses' => 'ProductRequestController@edit'))->name('admin.product.request.edit'); 
        Route::post('/product/request/update/{id?}', array('uses' => 'ProductRequestController@update'))->name('admin.product.request.update'); 
      
        Route::get('/product/request/list', array('uses' => 'AjaxController@productRequestData'))->name('admin.product.request.listing'); 
        Route::post('/changeDataStatus', array('before' => 'csrf', 'uses' => 'CommonAjaxController@changeDataStatus'));

        /**delete image from s3 */
        Route::get('/deletefiles3', array('before' => 'csrf', 'uses' => 'CommonAjaxController@deleteFileS3'));


        /**
         * import excel file from data
         */

      // Route::get('export', 'MyController@export')->name('export');
        Route::get('/importExportView', 'DeliveryAddressImportController@importExportView')->name('admin.show.import');
        Route::post('/import', 'DeliveryAddressImportController@import')->name('admin.upload.delivery.address');
        // Route::get('/import/edit/{id?}','DeliveryAddressImportController@edit')->name('admin.edit.delivery.address');
        Route::post('/import/store','DeliveryAddressImportController@updateLocation')->name('admin.update.delivery.location');
        //Show admin profile
        Route::get('/profile','ProfileController@profile')->name('admin.profile');
        Route::post('/change-password','ProfileController@changePassword')->name('admin.change.password');

        // CMS Management
        Route::get('/cms','CMSController@index')->name('admin.cms.index');
        Route::get('/cms-list', array('uses' => 'AjaxController@cmsData'))->name('admin.cms.list');
        Route::get('/cms-edit/{id?}', 'CMSController@edit')->name('admin.cms.edit');
        Route::put('/cms-update/{id}', 'CMSController@update')->name('admin.cms.update');
        Route::group(['prefix' => 'laravel-filemanager'], function () {
          \UniSharp\LaravelFilemanager\Lfm::routes();
        });


        // Distributor Management
        Route::get('/distributor','DistributorController@index')->name('admin.distributor.index');
        Route::get('/distributor-list',array('uses' => 'AjaxController@distributorData'))->name('admin.distributor.list');
        Route::get('/distributor/show/{id?}', array('uses' => 'DistributorController@show'))->name('admin.distributor.show'); 
        Route::get('/distributor/order-list',array('uses' => 'AjaxController@orderList'))->name('admin.distributor.order.list');
        Route::get('/distributor-edit/{id?}', 'DistributorController@edit')->name('admin.distributor.edit');
        Route::put('/distributor/{id}', 'DistributorController@update')->name('admin.distributor.update');


        //Notification Management
        Route::get('/notification','NotificationController@index')->name('admin.notification.index');
        Route::get('/notification/add/{id?}','NotificationController@add')->name('admin.notification.add');
        Route::post('/notification/store','NotificationController@store')->name('admin.notification.store');
        Route::get('/ajax-request/notify-data','NotificationController@getNotifyData');
        Route::get('/notification-list','AjaxController@notificationList')->name('admin.notification.list');

        //Contact Query List
        Route::get('/contact','ContactController@index')->name('admin.contact.index');
        Route::get('/contact-query-list','AjaxController@contactQueryList')->name('admin.notification.list');
       
      });
    });

});
