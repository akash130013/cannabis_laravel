<?php


namespace App\Modules\Admin\Controllers;
 
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Admin\Models\Category;
use App\Models\Distributor;
use App\Adaptors\CommonAdaptor;
use App\Models\Order;
use App\Helpers\CommonHelper;
use App\Models\StaticPage;
use App\Modules\Store\Models\StoreProductRequest;
use App\User;
use App\AdminDeliveryAddress;
use App\Models\ContactQuery;
use App\Store;
use Illuminate\Support\Str;
use App\Models\PromoCode;
use App\Models\StoreEarning;
use App\Modules\Admin\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AjaxController extends Controller
{

    /**
     * @param Request $request
     * @return filtered sequence data
     */




    /**
     * Get usrs list data on product tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function productData(Request $request)
    {
         //Check is request is Ajax
         $validateAjax = CommonAdaptor::validateAjax($request);

         if(!$validateAjax['status']) 
         {
             return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                 ->header('Content-Type', 'application/json');
         } // End Check
        
        $createdFilters = CommonAdaptor::getFilters($request);
        $storeId        = '';
        if ('' != $request->encryptStoreId) {
            $storeId = $request->encryptStoreId;
            try {
                $storeId = decrypt($request->encryptStoreId) ?? '';
            } catch (\Exception $e) {
                abort(Response::HTTP_NOT_FOUND);
            }
        }
        $draw       = $createdFilters['draw'];
        $offset     = $createdFilters['offset'];
        $orderBy    = $createdFilters['orderBy'];
        $search     = $createdFilters['search']; 
        $filter     = $createdFilters['filter']; 

        //Adding more filters in basic filter
        $filter['store_id']        = $storeId;
        $filter['category_id']     = $request->get("category_id");
        $filter['minStore']        = $request->get("minStore") ;
        $filter['maxStore']        = $request->get("maxStore");
        $filter['min_order']       = $request->get("minOrder")??'';
        $filter['max_order']       = $request->get("maxOrder")??'';
        $productData = CategoryProduct::getCategoryProductData($offset,  $request->get("length"),$search, $orderBy[0], $filter);
        $data = [];
        $snStart = (int) ($offset) + (int) 1;
        foreach ($productData['data'] as $Data) {
            $temp                   = [];
            $temp['sn']             = $snStart++;
            $temp['Id']             = $Data->id;
            $temp['product_name']   = Str::title($Data->product_name);
            $temp['category_name']  = Str::title($Data->category_name);
            // $temp['category_image'] = $Data->file_url ?? config('constants.DEAFULT_IMAGE.PRODUCT_IMAGE');
            $temp['total_product']  = $Data->total_placed_order??0;
            $temp['total_store']    = $Data->get_product_stock_count;
            $temp['created_at']     = CommonHelper::dateFormat($Data->created_at);
            $temp['p_status']       = $Data->status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->status);
            $temp['action']         = [
                                            "id" => encrypt($Data->id),
                                            "status"=>$Data->status,
                                      ];
            $temp['extra']          = "Extra Col.";
            $data[]                 = $temp;
        }
        // Response Array
        $productDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $productData, $data);

        return (new Response($productDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }


      /**
     * Get usrs list data on category tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function categoryData(Request $request)
    {
       
         //Check is request is Ajax
         $validateAjax = CommonAdaptor::validateAjax($request);
         if(!$validateAjax['status']) {
             return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                 ->header('Content-Type', 'application/json');
         } // End Check
        
         $createdFilters = CommonAdaptor::getFilters($request);

         $draw       = $createdFilters['draw'];
         $offset     = $createdFilters['offset'];
         $orderBy    = $createdFilters['orderBy'];
         $search     = $createdFilters['search']; 
         $filter     = $createdFilters['filter']; 

         $filter['minProduct']     = $request->get("minProduct");
         $filter['maxProduct']     = $request->get("maxProduct");
     
        $categoryData = Category::getCategoryData($offset, $request->get("length"), $search, [] , $filter);
        $data = [];
        
        $snStart = (int) ($offset) + (int) 1;
        foreach ($categoryData['data'] as $Data) {
            $temp                   = [];
            $temp['sn']             = $snStart++;
            $temp['Id']             = $Data->id;
            $temp['category_name']  = Str::title($Data->category_name);
            $temp['category_image'] = $Data->image_url ?? config('constants.DEAFULT_IMAGE.CATEGORY_IMAGE');
            $temp['total_product']  = $Data->get_product_count;
            $temp['created_at']     = CommonHelper::dateFormat($Data->created_at);
            $temp['c_status']       = $Data->status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->status);
            $temp['action']         = [
                                            "id" => encrypt($Data->id),
                                            "status"=>$Data->status,
                                      ];
            $temp['extra']          = "Extra Col.";
            $data[]                 = $temp;
        }

        // Response Array
        $categoryDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $categoryData, $data);
        return (new Response($categoryDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }


    /**
     * get users list on user tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function userData(Request $request)
    {
         //Check is request is Ajax
         $validateAjax = CommonAdaptor::validateAjax($request);
         if(!$validateAjax['status']) {
             return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                 ->header('Content-Type', 'application/json');
         } // End Check

         $createdFilters = CommonAdaptor::getFilters($request);

         $draw                      = $createdFilters['draw'];
         $offset                    = $createdFilters['offset'];
         $orderBy                   = $createdFilters['orderBy'];
         $search                    = $createdFilters['search']; 
         $filter                    = $createdFilters['filter']; 
         $filter['promoCode']       = $request->get("promoCode");
         $filter['startDOB']        = $request->get("startDOB");
         $filter['endDOB']          = $request->get("endDOB");
        $userData = User::getUserData($offset, $request->get("length"), $search, $orderBy[0], $filter);
        $data     = [];
        
        $snStart = (int) ($offset) + (int) 1;
        foreach ($userData['data'] as $Data) 
        {
            $temp               = [];
            $temp['sn']         = $snStart++;
            $temp['user_name']  = Str::title($Data->name);
            $temp['email']      = $Data->email?$Data->email:'--';
            $temp['phone']      = $Data->phone_number??'--';
            $temp['dob']        = CommonHelper::dateFormat($Data->dob);
            $temp['user_image'] = $Data->profile_pic ?? config('constants.DEAFULT_IMAGE.USER_IMAGE');
            $temp['created_at'] = CommonHelper::dateFormat($Data->created_at);
            $temp['c_status']   = $Data->status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->status);
            $temp['action']     = [
                                    "id" => encrypt($Data->id),
                                    "status"=>$Data->status,
                                  ];
            $temp['extra']      = "Extra Col.";
            $data[]             = $temp;
        }
        // Response Array
        $UserDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $userData, $data);

        return (new Response($UserDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * get stores list on store tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeData(Request $request)
    {
         //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);

        $draw                   = $createdFilters['draw'];
        $offset                 = $createdFilters['offset'];
        $orderBy                = $createdFilters['orderBy'];
        $search                 = $createdFilters['search']; 
        $filter                 = $createdFilters['filter']; 
        $filter['productId']    = $request->productId ??'';
        
        $storeData = Store::getStoreData($offset,  $request->get("length"), $search , $orderBy[0], $filter);
        // dd($storeData);
        $data      = [];
        
        $snStart = (int) ($offset) + (int) 1;
        foreach ($storeData['data'] as $Data) 
        { 
            [$amount_pending,$total_earning,$last_settlement] = CommonHelper::storeEarning($Data->id);
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            // $temp['store_id']               = $Data->storeDetail?$Data->storeDetail->store_id:'--';
            $temp['store_name']             = $Data->storeDetail?Str::title($Data->storeDetail->store_name):'--';
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at);
            $temp['email']                  = $Data->email??'N/A';
            $temp['phone']                  = $Data->phone;
            $temp['avatar']                 = $Data->avatar ?? config('constants.DEAFULT_IMAGE.STORE_IMAGE');
            $temp['commission_percentage']  = $Data->commission?$Data->commission->commison_percentage:'N/A';
            $temp['total_earning']          = $total_earning;
            $temp['drivers_nos']            = '--';
            $temp['last_settlement_date']   = $last_settlement?CommonHelper::dateFormat($last_settlement):'N/A';
            $temp['amount_pending']         = round($amount_pending,2);
            $temp['c_status']               = $Data->status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->status);
            $temp['action']                 = [
                                                "id" => encrypt($Data->id),
                                                "status"=>$Data->status,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }

        // Response Array
        $storeDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $storeData, $data);

        return (new Response($storeDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * get requested stores 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function requestedStoreList(Request $request)
    {
         //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);

        $draw       = $createdFilters['draw'];
        $offset     = $createdFilters['offset'];
        $orderBy    = $createdFilters['orderBy'];
        $search     = $createdFilters['search']; 
        $filter     = $createdFilters['filter']; 

        $storeData = Store::getRequestedStoreData($offset,  $request->get("length"), $search , $orderBy[0], $filter);
        $data      = [];
        $snStart   = (int) ($offset) + (int) 1;
        foreach ($storeData['data'] as $Data) 
        { 
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['store_name']             = $Data->storeDetail?Str::title($Data->storeDetail->store_name):'--';
            $temp['addr']                   = $Data->storeDetail?Str::title($Data->storeDetail->formatted_address):'--';
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at);
            $temp['email']                  = $Data->email??'--';
            $temp['phone']                  = $Data->phone??'--';
            $temp['avatar']                 = $Data->avatar ?? config('constants.DEAFULT_IMAGE.STORE_IMAGE');
            $temp['business_name']          = $Data->business_name??'--';
            $temp['locations']               = [
                                                "id" => encrypt($Data->id),
                                                'count'=>count($Data->deliveryLocations)??0,
                                              ];
            $temp['c_status']               = Str::title($Data->admin_action);
            $temp['action']                 = [
                                                "id"            => encrypt($Data->id),
                                                "status"        => $Data->admin_action,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }
        // Response Array
        $storeDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $storeData, $data);

        return (new Response($storeDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    protected function getDeliveryLocationData($collection)
    {
        $data =[];

        foreach ($collection as $key => $item) {
           $data [] = [
                            's_no'      => ++$key,
                            'address'   => $item->formatted_address
           ];
        }
        return $data;
    }

    /**
     * Get usrs list data on product tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function productRequestData(Request $request)
    {
       
        //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);
        
         $draw       = $createdFilters['draw'];
         $offset     = $createdFilters['offset'];
         $orderBy    = $createdFilters['orderBy'];
         $search     = $createdFilters['search']; 
         $filter     = $createdFilters['filter']; 

         $filter['category_id']     = $request->get("category_id");
     
        $productRequestData = StoreProductRequest::getProductRequestedData($offset,$request->get("length"), $search , $orderBy[0], $filter);
        $data               = [];
      
        $snStart = (int) ($offset) + (int) 1;
        foreach ($productRequestData['data'] as $Data) {
            $temp                   = [];
            $temp['sn']             = $snStart++;
            $temp['Id']             = $Data->id;
            $temp['product_name']   = Str::title($Data->product_name ?? '--');
            $temp['thc']            = $Data->thc;
            $temp['cbd']            = $Data->cbd;
            $temp['store_name']     = Str::title($Data->store_name ?? '--');
            $temp['created_at']     = CommonHelper::dateFormat($Data->created_at);
            $temp['p_status']       = $Data->status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->status);
            $temp['action']         = [
                                        "id" => encrypt($Data->id),
                                        "status"=>$Data->status,
                                      ];
            $temp['extra']          = "Extra Col.";
            $data[]                 = $temp;
        }

        // Response Array
        $UserDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $productRequestData, $data);

        return (new Response($UserDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * get promocodes list on promocode tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function promocodeData(Request $request)
    {
         //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);

        $draw       = $createdFilters['draw'];
        $offset     = $createdFilters['offset'];
        $orderBy    = $createdFilters['orderBy'];
        $search     = $createdFilters['search']; 
        $filter     = $createdFilters['filter']; 
        
        $filter['couponDateType']     = $request->get("couponDateType");
        $filter['promotionalType']    = $request->get("promotionalType");
        $filter['minAmount']          = $request->get("minAmount");
        $filter['maxAmount']          = $request->get("maxAmount");
       
        $promocodeData = PromoCode::getPromocodeData($offset,  $request->get("length"), $search, $orderBy[0], $filter);
        $data      = [];
         
        $snStart = (int) ($offset) + (int) 1;
        foreach ($promocodeData['data'] as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['promo_name']             = Str::title($Data->promo_name);
            $temp['coupon_code']            = $Data->coupon_code;
            $temp['total_coupon']           = $Data->total_coupon?$Data->total_coupon:0;
            $temp['max_cap']                = $Data->coupon_code;
            $temp['promotional_type']       = $Data->promotional_type == 'fixed'?'Flat':'Percentage';
            $temp['discount_percentage']    = $Data->promotional_type == 'percentage'?$Data->amount.'%':'NA';
            $temp['amount']                 = $Data->promotional_type == 'percentage'?'upto '.$Data->max_cap:$Data->max_cap;
            $temp['start_time']             = CommonHelper::dateFormat($Data->start_time);
            $temp['end_time']               = CommonHelper::dateFormat($Data->end_time);
            $temp['offer_status']           = $Data->offer_status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->offer_status);
            $temp['action']                 = [
                                                "id" => encrypt($Data->id),
                                                "offer_status"=>$Data->offer_status,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }

        // Response Array
        $promocodeDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $promocodeData, $data);
        
        return (new Response($promocodeDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

     /**
     * get cms list on cms tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    
    public function cmsData(Request $request)
    {
         //Check is request is Ajax
         $validateAjax = CommonAdaptor::validateAjax($request);
         if(!$validateAjax['status']) 
         {
             return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                 ->header('Content-Type', 'application/json');
         } // End Check

         $createdFilters = CommonAdaptor::getFilters($request);

         $draw       = $createdFilters['draw'];
         $offset     = $createdFilters['offset'];
         $orderBy    = $createdFilters['orderBy'];
         $search     = $createdFilters['search']; 
         $filter     = $createdFilters['filter']; 

        $cmsData = StaticPage::getCMSData($offset,  $request->get("length"), $search , $filter);
        $data      = [];
        
        $snStart = (int) ($offset) + (int) 1;
        foreach ($cmsData['data'] as $Data) 
        {
            $temp                = [];
            $temp['sn']          = $snStart++;
            $temp['name']        = Str::title($Data->name);
            $temp['slug']        = $Data->slug;
            $temp['content']     = $Data->content;
            $temp['panel']       = Str::title($Data->panel);
            $temp['action']      = [
                                      "id" => encrypt($Data->id),
                                      "status"=>$Data->status,
                                    ];
            $temp['extra']       = "Extra Col.";
            $data[]              = $temp;
        }

        // Response Array
        $cmsDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $cmsData, $data);
      
        return (new Response($cmsDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * get driver list on driver tab
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    
    public function distributorData(Request $request)
    {
         //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) 
        {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check

        $createdFilters = CommonAdaptor::getFilters($request);

        $draw               = $createdFilters['draw'];
        $offset             = $createdFilters['offset'];
        $orderBy            = $createdFilters['orderBy'];
        $search             = $createdFilters['search']; 
        $filter             = $createdFilters['filter']; 
        $storeId            = $request->get('storeId')?decrypt($request->get('storeId')):null; 
     
        $distributorData = Distributor::getdistributorData($offset,  $request->get("length"), $search, $orderBy[0], $filter,$storeId);
        $data      = [];
        
        $snStart = (int) ($offset) + (int) 1;
        foreach ($distributorData['data'] as $Data) {
            $storeDetail = $Data->stores->first()->storeDetail??'';
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['name']                   = Str::title($Data->name);
            $temp['email']                  = $Data->email??'--';
            $temp['store_id']               = '' != $storeDetail?$storeDetail->id:'';
            $temp['store_name']             = '' != $storeDetail?Str::title($storeDetail->store_name):'--';
            $temp['phone']                  = $Data->phone_number??'--';
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at);
            $temp['status']                 = $Data->admin_status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->admin_status);
            $temp['action']                 = [
                                                "id" => encrypt($Data->id),
                                                "status"=>$Data->admin_status,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }

        // Response Array
        $distributorDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $distributorData, $data);

        return (new Response($distributorDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * get distributor order list on distributor detail screen
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    
    public function distributorOrderListData($offset,$collection)
    {
        $data      = [];
        $snStart = (int) ($offset) + (int) 1;
        foreach ($collection as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['order_id']               = $Data->order_uid;
            $temp['net_amount']             = $Data->net_amount;
            $temp['payment_method']         = $Data->payment_method??'--';
            $temp['total_product']          = $Data->order_data['itemCount']??0;
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at);
            $temp['status']                 = Str::title(str_replace('_', ' ', $Data->order_status));
            $temp['action']                 = [
                                                "id" => encrypt($Data->id),
                                                "status"=>$Data->status,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }
        return $data;
       
    }

    /**
     *this function is used to getfiltered order list 
     * @param Request $list offset and collection of data
     * @return :array of filtered data
     */
    public function filteredorderListData($offset,$collection)
    {
        $data      = [];
        $snStart = (int) ($offset) + (int) 1;
        foreach ($collection as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['order_id']               = $Data->order_uid;
            $temp['store_detail']           = [
                                                'name' => !empty($Data->stores)&&!empty($Data->stores->storeDetail)?$Data->stores->storeDetail->store_name:'--',
                                                'id'   => !empty($Data->stores)?encrypt($Data->stores->id):null
                                              ];
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at,'M d, Y');
            $temp['customer_detail']          = [
                                                    'name' => !empty($Data->user)?$Data->user->name:'--',
                                                    'id'   =>  !empty($Data->user)?encrypt($Data->user->id):null
                                                ];
            $temp['customer_id']            = !empty($Data->user)?encrypt($Data->user->id):null;
            $temp['location']               = $Data->delivery_address['formatted_address']??'--';
            $temp['amount']                 = $Data->net_amount;
            $temp['status']                 = Str::title(str_replace('_', ' ', $Data->order_status));
            $temp['action']                 = [
                                                "id" => encrypt($Data->id),
                                                "status"=>$Data->status,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }
        return $data;
    }



    public function orderList(Request $request)
    {
          //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check

        $createdFilters = CommonAdaptor::getFilters($request);

        $draw           = $createdFilters['draw'];
        $offset         = $createdFilters['offset'];
        $orderBy        = $createdFilters['orderBy'];
        $search         = $createdFilters['search']; 
        $filter         = $createdFilters['filter']; 
        $distributorId  = $request->get('distributorId')?$request->get('distributorId'):null; 
        $userId         = $request->get('userId')?decrypt($request->get('userId')):null; 
        $storeId        = $request->get('storeId')?decrypt($request->get('storeId')):null; 
        $productId      = $request->get('productId')?decrypt($request->get('productId')):null; 
        

        $filter['minAmount']     = $request->get("minAmount");
        $filter['maxAmount']     = $request->get("maxAmount");
     
         $orderData = Order::getOrderListData($offset,  $request->get("length"), $search, $orderBy[0], $filter,$distributorId, $userId,$storeId,$productId);

         if(null != $distributorId)
        {
            $data = $this->distributorOrderListData($offset,$orderData['data']);
        }
        else{
            $orderData['data']->load(['stores.storeDetail','user']);
            $data = $this->filteredorderListData($offset,$orderData['data']);
        }
        // Response Array
         $orderDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $orderData, $data);
        
        return (new Response($orderDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * get deliver location  list on location list screen
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function deliverLocationData(Request $request)
    {  //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) 
        {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check

        $createdFilters = CommonAdaptor::getFilters($request);

        $draw       = $createdFilters['draw'];
        $offset     = $createdFilters['offset'];
        $orderBy    = $createdFilters['orderBy'];
        $search     = $createdFilters['search']; 
        // $filter     = $createdFilters['filter']; 
     
        $locationData = AdminDeliveryAddress::getdeliverLocationData($offset,  $request->get("length"), $search, []);
        $data      = [];
        $snStart = (int) ($offset) + (int) 1;
        foreach ($locationData['data'] as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['address']                = $Data->address?Str::title($Data->address):'--';
            $temp['city']                   = Str::title($Data->city??'--');
            $temp['state']                  = Str::title($Data->state??'--');
            $temp['zipcode']                = Str::title($Data->zipcode??'--');
            $temp['country']                = Str::title($Data->country??'--');
            $temp['timezone']               = Str::title($Data->timezone??'--');
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at);
            $temp['status']                 = $Data->status == config('constants.STATUS.BLOCKED')? 'Inactive': Str::title($Data->status);
            $temp['action']                 = [
                                                "id" => encrypt($Data->id),
                                                "status"=>$Data->status,
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }

        // Response Array
        $distributorDataResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $locationData, $data);

        return (new Response($distributorDataResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }



    /***
     * to get product wise rating and review list
     * @request : $request
     * @return : application/json
     */

    public function getProductRatingList(Request $request)
    {
          //Check is request is Ajax
          $validateAjax = CommonAdaptor::validateAjax($request);
          if(!$validateAjax['status']) {
              return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                  ->header('Content-Type', 'application/json');
          } // End Check
          $createdFilters = CommonAdaptor::getFilters($request);
  
          $draw       = $createdFilters['draw'];
          $offset     = $createdFilters['offset'];
          $orderBy    = $createdFilters['orderBy'];
          $search     = $createdFilters['search']; 
          $filter     = $createdFilters['filter']; 
          
          $filter['encryptProductId']   = $request->get("encryptProductId");
          $filter['minRate']            = $request->get("minRate");
          $filter['maxRate']            = $request->get("maxRate");
         
          $productRatingData = CategoryProduct::getProductRatingsData($offset,  $request->get("length"), $search, $orderBy[0], $filter);
          $data      = [];
           
          $snStart = (int) ($offset) + (int) 1;
          foreach ($productRatingData['data'] as $Data) {
              $temp                           = [];
              $temp['sn']                     = $snStart++;
              $temp['order_date']             = $Data->order?CommonHelper::dateFormat($Data->order->created_at):'--';
              $temp['order']                  = [
                                                    'order_id' => $Data->order?encrypt($Data->order->id):'--',
                                                    'order_uid'=> $Data->order?$Data->order_uid:'--',
                                                ];
              $temp['user']                   = [
                                                    'user_id'    => encrypt($Data->created_by),
                                                    'user_name'  => $Data->user?$Data->user->name:'--'
                                                ];
              $temp['review']                 = $Data->review;
              $temp['rate']                   = $Data->rate.'/5';
              $temp['extra']                  = "Extra Col.";
              $data[]                         = $temp;
          }
  
          // Response Array
          $productRatingResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $productRatingData, $data);
          
          return (new Response($productRatingResponse, Response::HTTP_OK))
              ->header('Content-Type', 'application/json');
    }

    /***
     * To get Notification List of push Notifications
     * @request :request
     * @return  : application/json
     */
    public function notificationList(Request $request)
    {
        //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);

        $draw       = $createdFilters['draw'];
        $offset     = $createdFilters['offset'];
        $orderBy    = $createdFilters['orderBy'];
        $search     = $createdFilters['search']; 
        $filter     = $createdFilters['filter']; 
        
        $productRatingData = Notification::getNotificationData($offset,  $request->get("length"), $search, $orderBy[0], $filter);
        $data      = [];
         
        $snStart = (int) ($offset) + (int) 1;
        foreach ($productRatingData['data'] as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at)??'--';
            $temp['message']                = $Data->description??'--';
            $temp['platform']               = Str::title($Data->platform);
            $temp['action']                 = [
                                                'id' => encrypt($Data->id),
                                              ];
            $temp['rate']                   = $Data->rate.'/5';
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }

        // Response Array
        $productRatingResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $productRatingData, $data);
        
        return (new Response($productRatingResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }

    /**
     * settlementData function for list of settlement 
     * @request: request
     * @return : application/json
     * 
     */
    public function settlementData(Request $request)
    {
        //Check is request is Ajax
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);

        $draw                           = $createdFilters['draw'];
        $offset                         = $createdFilters['offset'];
        $orderBy                        = $createdFilters['orderBy'];
        $search                         = $createdFilters['search']; 
        $filter                         = $createdFilters['filter']; 
        $filter['encryptStoreId']       = $request->get("encryptStoreId");
        $productRatingData = StoreEarning::getSettlement($offset,  $request->get("length"), $search, $orderBy[0], $filter);
        
        $snStart = (int) ($offset) + (int) 1;
        // if($filter['status'] == config('constants.STATUS.OPEN'))
        // {
        //     $data  = $this->getopenSettlementData($snStart,$productRatingData['data']);
        // }
        // else{
            $data  = $this->getopenSettlementData($snStart,$productRatingData['data']);
        // }
        // Response Array
        $productRatingResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $productRatingData, $data);
        
        return (new Response($productRatingResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }


    /**
     *this function is used to getfiltered order list 
     * @param Request $list offset and collection of data
     * @return :array of filtered data
     */
    public function getOpenSettlementData($snStart,$collection)
    {
        $data      = [];
        foreach ($collection as $Data) {
            
            [$itemCount,$totalDiscount] = CommonHelper::getOrderRelatedData($Data->order_data,$Data->discounts);

            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['order_created_at']       = CommonHelper::dateFormat($Data->created_at)??'--';
            $temp['order_uid']              = [
                                                    'order_uid'     => $Data->order_uid??'--',
                                                    'order_id'  =>encrypt($Data->id)
                                                ];
            $temp['product_count']          = [
                                                'count'     => $itemCount,
                                                'order_id'  =>encrypt($Data->id)
                                              ];
            $temp['order_status']           = Str::title(str_replace('_', ' ', $Data->order_status));
            
            $temp['total_amount']           = $Data->cart_subtotal;
            $temp['amount_received']        = $Data->amount_received;
            $temp['discount']               = $totalDiscount;
            $temp['commission']             = $Data->commission;
            $temp['earning_status']         = Str::title($Data->status);
            $temp['settlement_at']          = CommonHelper::dateFormat($Data->settlement_at);
            $temp['action']                 = [
                                                'store_earning_id'  => encrypt($Data->store_earning_id),
                                                'earning_status'    => $Data->status
                                              ];
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }
        return $data;
    }


    public function contactQueryList(Request $request)
    {
        $validateAjax = CommonAdaptor::validateAjax($request);
        if(!$validateAjax['status']) {
            return (new Response($validateAjax, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        $createdFilters = CommonAdaptor::getFilters($request);

        $draw       = $createdFilters['draw'];
        $offset     = $createdFilters['offset'];
        $orderBy    = $createdFilters['orderBy'];
        $search     = $createdFilters['search']; 
        $filter     = $createdFilters['filter']; 
        
        $productRatingData = ContactQuery::getContactQueryData($offset,  $request->get("length"), $search , $filter);
        $data      = [];
         
        $snStart = (int) ($offset) + (int) 1;
        foreach ($productRatingData['data'] as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['created_at']             = CommonHelper::dateFormat($Data->created_at)??'--';
            $temp['message']                = $Data->message??'--';
            $temp['reason']                 = $Data->reason;
            $temp['name']                   = Str::title($Data->name);
            $temp['email']                  = $Data->email;
            $temp['extra']                  = "Extra Col.";
            $data[]                         = $temp;
        }

        // Response Array
        $productRatingResponse = CommonAdaptor::getFilteredFooter($offset,$draw, $productRatingData, $data);
        
        return (new Response($productRatingResponse, Response::HTTP_OK))
            ->header('Content-Type', 'application/json');
    }
    
}
