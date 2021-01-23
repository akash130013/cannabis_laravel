<?php

use GuzzleHttp\Psr7\Response;

return [
    'REGISTER_SUCCESS_MSG'        => "You are successfully register on 420 KINGDOM",
    'USER_TYPE'                   => 'user',
    'USER'                        => [
        'GUEST' => 2,
    ],
    'DEFAULT_STORE_COMMISION'     => 10, //commision in percentage
    'PAGINATE'                    => 10,
    'GLOBAL_PAGINATE'             => 5,
    'SMS_ENABLE'                  => true,
    'BY_PASS_OTP'                 => 397551,  //used for the bypass /resend otp
    'DEFAULT_DB_DATE_TIME_FORMAT' => date("Y-m-d H:i:s"),
    'TYPE'                        => [
        'AGE_PROOF'     => 1,
        'MEDICAL_PROOF' => 2,
    ],
    'YES'                         => 1,
    'NO'                          => 0,
    'ACTIVE'                      => 1,
    'BLOCKED'                     => 2,
    'DELETED'                     => 3,
    'APPROVED'                    => 4,
    'REJECTED'                    => 5,
    'EMAIL_EXPIRE_TIME'           => 10,  //in minute
    'STOCK'                       => [
        'ALL'      => 1,
        'INSTOCK'  => 2,
        'OUTSTOCK' => 3,
    ],
    'NOTIFICATION'                => [
        'REPEAT' => 1,
    ],
    'SETTLEMENT' =>[
        'OPEN'      =>1,
        'CLOSED'    =>2
    ],
    'STATUS'                      => [
        'ACTIVE'    => 'active',
        'INACTIVE'  => 'inactive',
        'UNBLOCKED' => 'unblocked',
        'BLOCKED'   => 'blocked',
        'APPROVE'   => 'approve',
        'REJECT'    => 'reject',
        'PENDING'   => 'pending',
        'CLOSED'    => 'closed',
        'OPEN'      => 'open',
    ],
    "SHOW_DESTINATION_PAGE_LIMIT"          =>5,
    "basic_auth_login"                     => "appinventiv",
    "basic_auth_password"                  => "app@123##$$",
    'SuccessCode'                          => 200,
    'NonAuthonticate'                      => 203,
    'OTP_SEND_SUCCESS_MSG'                 => 'OTP has been sent',
    'INVALID_CREDENTIALS_MSG'              => 'We do not recognize the Phone number and password',
    'OTP_SEND_ERROR_MSG'                   => 'OTP could not be send',
    'otpValidationTime'                    => 15,
    'store_radius'                         => 50,
    'storePageProductLimit'                => 2,
    'user_dummy_image'                     => 'https://appinventiv-development.s3.amazonaws.com/0.411458619367568_download.jpeg',
    'legal_age'                            => 21,
    'coupon_code_invalid'                  => 'Invalid Coupon Code',
    'ORDER_SCHEDULE__PREDATE'              => 5,
    'SORTING_FILTER'                       => [
        1 => 'Price: High To Low',
        2 => 'Price: Low To High',
        3 => 'Recommended Products',
        4 => 'Whats New',
        5 => 'Popularity',
        6 => 'Relevance Products',
    ],
    'ORDER_FILTER'                         => [
        'pending'   => 'Pending',
        'ongoing'   => 'Processing',
        'completed' => 'Delivered',
        ''          => 'All',
        // 'order_cancelled' => 'Cancelled',
    ],
    'NotFound'                             => "not used",
    'InvalidDistributor'                   => "Invalid Distributor",
    'UpdationFailed'                       => 'Updation Failed',
    'ratingType'                           => [
        'driver'  => 'driver',
        'store'   => 'store',
        'product' => 'product',
    ],
    'userType'                             => [
        'user'   => 'user',
        'driver' => 'driver',
    ],
    'DEVICE_TYPE'                          => ['android', 'ios'],
    'GuestUserId'                          => 2,
    "Currency"                             => [
        "symbol" => "$",
        "words"  => "dollar"
    ],
    'USER_WEB_PRODUCT_DETAIL_REVIEW_LIMIT' => 5,
    "SUBSCRIPTION_OPTION"                  => [
        "ACTIVE"   => "subscribe",
        "INACTIVE" => "unsubscribe"
    ],
    'CART'                                 => [
        'MAX_SINGLE_ITEM_QUANTITY' => 5,
    ],
    'SINGLE_STORE_RULE_MSG'                => 'You can not order from 2 different stores in single order',
    'TEMP_IMPORTING_FOLDER_PATH'           =>'/pendingImport/',
    'DEAFULT_IMAGE'                              =>[
        'PROFILE'           => '/asset-admin/images/user-image.png',
        'USER_IMAGE'        => '/asset-user-web/images/profile.png',
        'DRIVER_IMAGE'      => '/asset-user-web/images/profile.png',
        'PRODUCT_IMAGE'     => '/svg/503.svg',
        'CATEGORY_IMAGE'    => '/svg/503.svg',
        'STORE_IMAGE'       => '/asset-user-web/images/homeshop_ph.svg',
        'DRIVER_PROOF_IMAGE'=> '/svg/503.svg',
        'STORE_PRODUCT_IMAGE' => '/asset-user-web/images/homeproduct_ph.svg',

        
    ],
    'SCHEDULER_DEFAULT_TIME_ZONE' => 'America/Los_Angeles',
    'LOYALTY_POINTS_REASONS' => [
        'REFERRED'=>'referred',
        'PURCHASE'=>'purchase',
        'DISCOUNTED' =>'discounted',
        'REFUNDED'=>'refunded',
        'OTHER' => 'other',
    ],
    'NULL_DATE_TIME'        => NULL,
    'DATE'=>[
        'END_DATE_TIME'     => " 23:59:59",
        'START_DATE_TIME'   => " 00:00:00 ",
        'NULL_TIMER'        => "00:00:00",
    ],
    'DRIVER_SORTING_FILTER' => [
        'Online' => 'Online',
        'Busy' => 'Busy',
        'offline' => 'Offline',
        'all' => 'Select All'
    ],
    'OrderRuleMSG' => [
        'PRODUCT_UNAVAILABLE'       => 'Product unavailable with this quantity or size',
        'PRICE_INCREASED'           => 'Price Increased for product',
        'INVALID_PROMO_CODE'        => 'Invalid Promo Code',
        'LESS_LOYALTY_POINTS'       => 'Loyalty Points are lesser than added in cart',
        'DELIVERY_LOCATION_BLOCKED' => 'Temporary we are not delivering at this location',
        'CATEGORY_BLOCKED'          => '%s product is not available',
        'STORE_BLOCKED'             => 'Store is blocekd by admin',
        'COUPON_BLOCKED'            => 'Coupon is not exist, please remove to proceed',
    ],
    'INVALID_MOBILE_NUMBER'             => 'Invalid mobile number',
    'USER_SERVICE_UNAVAILABLE'          => 'Your account services are temporary unavailable.',

    'ORDER_STATUS'=>[
        "order_placed"       => "Order Placed",
        "order_confirmed"    => "Order Confirmed",
        "order_verified"     => "Order verified",
        "driver_assigned"    => "Driver assigned",
        "on_delivery"        => "On delivery",
        "delivered"          => "Delivered",
        "amount_received"    => "Amount received",
        "order_cancelled"    => "Order cancelled",
        "amount_refund_init" => "Amount refund init",
        "amount_refunded"    => "Amount refunded"
    ],
];
