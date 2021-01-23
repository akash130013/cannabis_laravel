<?php

return [
    'ENDPOINTS' => [

            'HOME' => [
                'CATEGORY' => "/api/user/categories",
                'ALL_CATEGORY' => "/api/user/all-categories",
                'TRENDING' => "/api/user/trending-products",
                'NEARBY' => "/api/user/get-nearby-stores",
                'TRENDING_CATEGORY'=>"/api/user/store-products",
                'SEARCH'=>"/api/user/global-search",
                'ADD_WISH_LIST'=>"/api/user/add-to-wishlist",
                'REMOVE_WISH_LIST'=>'/api/user/remove-from-wishlist',
                'REMOVE_BOOKMARK_LIST'=>'/api/user/remove-bookmark-store',
                
            ],
            'PRODUCT'=>[
                  'DETAIL'=>"/api/user/product-detail",
                  'SIMILAR'=>'/api/user/get-similar-products',
            ],
            'ORDER'=>[
              'LIST'=>'/api/user/my-orders',
              'RATING'=>'/api/user/rate-order-bulk',
              'CANCEL'=> '/api/user/cancel-order',
              'REORDER'=>'/api/user/re-order',
              'TRACK' =>'/api/user/track-order',
            ],
            'WISHLIST'=>'/api/user/my-wishlist',
            'ADD_CART' => '/api/user/add-to-cart',
            'CLEAR_CART_ADD'=>'/api/user/clear-cart-add-item',
            'CART_LIST' => '/api/user/show-cart',
            "REMOVE_CART" => "/api/user/remove-cart-item",
            "PROMO_CODE_LIST" =>"api/user/show-promo-codes",
            "APPLY_PROMO_CODE" => "/api/user/apply-coupon-code",
            "REMOVE_PROMO_CODE" => "/api/user/remove-coupon-code",
            "UPDATE_QTY_PROMO_CODE" => "/api/user/update-item",
            "ADD_DELIVERY_ADDRESS_TO_ORDER" => "/api/user/update-order-delivery-address",
            "PLACE_ORDER" => "/api/user/place-order",
            
            'GLOBAL_SEARCH'=>'/api/user/global-search',   //for global search
            'SAVE_GLOBAL_SEARCH'=>'/api/user/save-search',   //for save global search
            
           'STORE'=>[
              'DETAIL'=>'/api/user/store-detail',
              'RATING'=>'/api/user/fetch-rating',
           ],

            "PROFILE" => [
                'CONTACT_US' => "/api/contact-query"
            ],

            'BOOKMARK'=>[
                'ADD'=>'/api/user/create-bookmark-store',
                'REMOVE'=>'/api/user/remove-bookmark-store',
                'INDEX' =>'/api/user/my-bookmark',
            ],
            'LOYALITY_POINT'=>[
               'SHOW'=>'/api/user/my-loyalty-points',
               'DETAIL'=>'/api/user/get-loyalty-points-exchange-info',
               'REDEAM'=>'/api/user/redeem-loyalty-points',
               'REMOVE'=>'/api/user/remove-loyalty-points', 
            ],
    ]
];