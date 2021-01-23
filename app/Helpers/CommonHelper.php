<?php

namespace App\Helpers;

use App\Enums\StoreNotificationType;
use App\Http\Services\BookmarkService;
use App\Http\Services\CartService;
use App\Http\Services\WishListService;
use App\Models\Bookmark;
use App\Models\Cart;
use App\Models\DeviceToken;
use App\Models\Rating;
use App\Models\StoreEarning;
use App\Models\WishList;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\StoreDeliveryAddress;
use App\Modules\Store\Models\StoreImages;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use App\Modules\Store\Models\StoreTiming;
use App\Store;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Storage;
use Illuminate\Database\QueryException;
use Auth;
use Exception;
use Illuminate\Http\Response;

class CommonHelper
{


    public static function subscribeUnsubscribeTopic($topic, $registrationTokens, $for)
    {
        try {
            $serviceAccount = ServiceAccount::fromJsonFile(config_path() . '/kingdom420_firebase.json');
            $firebase       = (new Factory)->withServiceAccount($serviceAccount)->create();
            if ($for == config('constants.SUBSCRIPTION_OPTION.ACTIVE')) {
                //print_r($registrationTokens);
                $subscribeData = $firebase->getMessaging()->subscribeToTopic($topic, $registrationTokens);
                //dd($subscribeData);
            } else if ($for == config('constants.SUBSCRIPTION_OPTION.INACTIVE')) {
                $subscribeData = $firebase->getMessaging()->unsubscribeFromTopic($topic, $registrationTokens);
            }
            return $subscribeData;
        } catch (\Exception $e) {
            echo ($e->getMessage());
        }
    }

    /**
     * Rest Based Pagination modification
     * @param $data
     * @return \Illuminate\Support\Collection
     */
    public static function restPagination($data, $finish = null)
    {
        $data               = collect($data);
        $data['isComplete'] = false;

        $data['prevPage'] = null;
        $data['nextPage'] = null;
        if (!is_null($data['next_page_url'])) {
            $explodeArr       = explode('page=', $data['next_page_url']);
            $data['nextPage'] = (int) $explodeArr[1];
        } else {
            $data['isComplete'] = true;
            $data['nextPage']   = 0;
        }
        if (!is_null($data['prev_page_url'])) {
            $explodeArr       = explode('page=', $data['prev_page_url']);
            $data['prevPage'] = (int) $explodeArr[1];
        } else {
            $data['prevPage'] = 0;
        }

        if (isset($finish)) {
            $data['isComplete'] = true;
        }

        return $data;
    }

    /***
     * Sr. no for the simple pagination
     * @param : page and per page
     * @return : serial no.
     */
    public static function generateSerialNumber($page, $per_page): int
    {
        (!empty($per_page)) ? $per_page : $per_page = 10; //Setting default per page limit
        if (isset($page)) {
            if ($page != 1) {
                $SN = ($per_page * ($page - 1)) + 1;
            } else {
                $SN = $page;
            }
        } else {
            $SN = 1;
        }
        return $SN;
    }

    /**
     * @param $storeId
     * @return array
     */
    public static function todayStoreTiming($storeId)
    {
        $storeTimeZone = Store::find($storeId)->time_zone;
        $openingStatus = false;
        $now           = Carbon::now($storeTimeZone);
        $storeTiming   = StoreTiming::where(['store_id' => $storeId, 'day' => $now->dayOfWeek])->first();
        if (!$storeTiming) {
            return [
                'opening_timing' => "00:00",
                'closing_timing' => "00:00",
                'openingStatus'  => false,
            ];
        }
        if ($now->isBetween(Carbon::parse('today ' . $storeTiming->start_time, $storeTimeZone), Carbon::parse('today ' . $storeTiming->end_time, $storeTimeZone), true)) {
            $openingStatus = true;
            $response      = [
                'closing_timing' => $storeTiming->end_time,
                'opening_timing' => $storeTiming->start_time,
                'openingStatus'  => $openingStatus
            ];
        } else {
            $openingStatus = false;
            $response      = [
                'opening_timing' => $storeTiming->start_time,
                'closing_timing' => $storeTiming->end_time,
                'openingStatus'  => $openingStatus
            ];
        }
        return $response;
    }


    /**
     * @param $storeId
     * @param $userId
     * @return bool
     */
    public static function checkBookMark($storeId, $userId)
    {
        $bookmarkService = new BookmarkService(new Bookmark());
        return $bookmarkService->checkBookmarked(['store_id' => $storeId, 'user_id' => $userId]);
    }

    /**
     * @param $storeId
     * @param $userId
     * @return bool
     */
    public static function checkWishList($productId, $userId)
    {
        $wishListService = new WishListService(new WishList());
        return $wishListService->checkWishList(['product_id' => $productId, 'user_id' => $userId]);
    }


    /**
     * @param $lat1 source latitude
     * @param $lon1 source longitude
     * @param $lat2 destination latitude
     * @param $lon2 destination latitude
     * @param $unit 'M' is statute miles | 'K' is kilometers | 'N' is nautical miles
     * @return bool
     */
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit = "K")
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist  = acos($dist);
            $dist  = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit  = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } elseif ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    /**
     * @param $productId
     * @param $storeId
     * @param $size
     * @return mixed
     */
    public static function calculateCartPriceData($productId, $storeId, $size, $unit)
    {
        $cartService = new CartService();
        return $cartService->cartPriceData($productId, $storeId, $size, $unit);
    }

    /**
     * check stock available
     * @param $productId
     * @param $storeId
     * @param $size
     * @return int
     */
    public static function checkStockAvailable($productId, $storeId, $size): int
    {
        return StoreProductStockUnit::with('storeProductStock')
            ->whereHas('storeProductStock', function ($query) use ($productId, $storeId, $size) {
                $query->where(['store_id' => $storeId, 'product_id' => $productId]);
            })
            ->where('quant_unit', $size)
            ->where('total_stock', '>', 0)
            ->exists();
    }

    /**
     * check stock available
     * @param $productId
     * @param $storeId
     * @param $size
     * @return int
     */
    public static function productStock($productId, $storeId)
    {
        return StoreProductStockUnit::whereHas('storeProductStock', function ($query) use ($productId, $storeId) {
            $query->where(['store_id' => $storeId, 'product_id' => $productId]);
        })
            ->get();
    }


    /**
     * cart summary as per user Web design
     * @param $cart
     * @return array
     */
    public static function cartSummary($cart)
    {
        $cartData = [];
        foreach ($cart as $data) {
            $cartData[] = [
                'product_id'    => $data->product_id,
                'product_name'  => $data->product_name,
                'size'          => $data->size,
                'size_unit'     => $data->size_unit,
                'quantity'      => $data->quantity,
                'item_subtotal' => $data->item_subtotal,

            ];
        }
        return $cartData;
    }

    /**
     * @param $productId
     * @param $userId
     * @return mixed
     */
    public static function checkCartAdded($productId, $userId, $storeId = null, array $stockArray)
    {
        $data = [];
        foreach ($stockArray as $key => $value) {
            $data[$key] = Cart::where(['product_id' => $productId, 'user_id' => $userId, 'store_id' => $storeId, 'size' => $value])->exists();
        }
        return $data;
    }

    /**
     * @param $date
     * @param null $format
     * @return string
     */
    public static function convertFormat($date, $format = null)
    {
        if (!$format) {
            $format = 'M d, Y h:i A';
        }

        return Carbon::parse($date)->format($format);
    }

    public static function s3FileUpload(UploadedFile $image, string $directory)
    {

        $name     = $directory . time() . '.' . $image->getClientOriginalExtension();
        $filePath = "cannabis/$directory/" . $name;

        $uploaded = Storage::disk('s3')->put($filePath, file_get_contents($image), 'public');

        /**throw exception in case image upload fails */
        if (!$uploaded) {
            throw new Exception(__('message.image-upload.failed'));
        }
        return config('filesystems.disks.s3.url') . '/' . $filePath;
    }

    /**
     * @param $storeId
     * @param null $storeName
     * @return mixed
     */
    public static function getStoreData($storeId, $storeName = null)
    {
        $store = Store::find($storeId);
        if (!$storeName) {
            return $store;
        }

        return $store->storeDetail->store_name;
    }

    /**
     * @param \Exception $exception
     * @param null $message
     * @return mixed
     */
    public static function catchException(\Exception $exception, $message = null)
    {
        $error['statusCode'] = $exception->getCode();
        $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
        \Log::error('error: ', $error);
        return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
    }

    /**
     * get avg rating for driver/store/product
     * @param int $id
     * @param string $type
     * @param null $store_id
     * @return int
     */
    public static function fetchAvgRating(int $id, string $type, $store_id = null): float
    {
        $rating = Rating::where(['rated_id' => $id, 'type' => $type])
            ->when(isset($store_id), function ($query) use ($store_id) {
                return $query->where('store_id', $store_id);
            })
            ->get()->avg('rate');
        return round((float) $rating, 1);
    }

    /**
     * fetch rating
     * @param $param
     * @return mixed
     */
    public static function fetchRatingData($param)
    {
        return Rating::where($param)->get();
    }

    /**
     * @param int $id
     * @param string $type
     * @param null $review
     * @return mixed
     */
    public static function ratingReviewCount(int $id, string $type, $review = null, $store_id = null)
    {
        $data = Rating::where(['rated_id' => $id, 'type' => $type]);
        if ($review) {
            $data = $data->whereNotNull('review');
        }

        if ($store_id) {
            $data = $data->where(['store_id' => $store_id]);
        }

        return $data->count();
    }

    /**
     * @request date-time string
     * @return :date string
     */

    public static function dateformat($date, $format = null)
    {
        if (!$format) {
            $format = 'M d, Y';
        }

        return Carbon::parse($date)->format($format);
    }

    /**
     * @desc convert status order
     * @param string $status
     * @return string $label
     */

    public static function getOrderStatusLabel(string $status)
    {
        $label = "";
        switch ($status) {
            case ($status == 'order_placed' || $status == 'order_verified'):
                $label = "pending";
                break;
            case ($status == 'driver_assigned' || $status == 'on_delivery'):
                $label = "on-going";
                break;
            case ($status == 'delivered' || $status == 'amount_received'):
                $label = "completed";
                break;
            case ($status == 'order_cancelled' || $status == 'amount_refund_init' || $status == 'amount_refunded'):
                $label = "cancelled";
                break;
        }
        return $label;
    }

    /**
     * @desc convert status order
     * @return status
     */

    public static function orderStatus($status = null)
    {
        $order = '';
        switch ($status) {
            case 'order_placed':
                $order = 'Processing';
                break;

            case 'driver_assigned':
                $order = 'Deliverd';
                break;
            default:
                $order = 'Cancelled';
                break;
        }
        return $order;
    }

    /**
     * to get array according to requested order type
     *
     * @param $status as a string
     * @return array
     */
    public static function getStatusArray($status)
    {
        switch ($status) {
            case "pending":
                $status = ['order_placed', 'order_verified'];
                break;
            case "ongoing":
                $status = ['driver_assigned', 'on_delivery', 'order_confirmed'];
                break;
            case "complete":
                $status = ['delivered', 'amount_received'];
                break;
            case "cancelled":
                $status = ['order_cancelled', 'amount_refund_init', 'amount_refunded'];
                break;
            default:
                $status = [];
        }
        return $status;
    }

    /****
     * To send Push Notifications to devices
     * @param deviceTokens & $data
     * @param array $param
     * @return null
     */

    public static function sendPushNotification($data, array $param)
    {
        $tokens = self::getDeviceToken($param);
        if (!$tokens || $tokens->count() == 0) {
            return 'success';
        }
        $message['title']          = $data->title;
        $message['notify_type']    = $data->notify_type;
        $message['notify_type_id'] = $data->notify_type_id;
        $message['message']        = $data->description;
        $message['image_url']      = $data->url;
        // $url = config('app.FCM.BASE_URL');

        $notification = [
            'body'  => $message['message'],
            'sound' => true,
        ];

        $extraNotificationData = $message;
        foreach ($tokens as $item) {
            $fcmNotification = [
                'registration_ids' => [$item->device_token],
                'data'             => $extraNotificationData
            ];
            if ($item->device_type == "ios") {
                $fcmNotification['notification'] = $notification;
            }
            $fields = json_encode($fcmNotification);
            self::curlRequestPushNotification($fields);
        }
    }

    /****
     * To send Push Notifications to all user devices
     * @param notification data and device type
     * @param array $param
     * @return null
     */

    public static function sendUserPushNotification($data, array $param)
    {
        $deviceType = $param['deviceType'];
        if ($deviceType == '') {
            return 'success';
        }
        $message['title']          = $data->title;
        $message['notify_type']    = $data->notify_type;
        $message['notify_type_id'] = $data->notify_type_id;
        $message['message']        = $data->description;
        $message['image_url']      = $data->url;
        // $url = config('app.FCM.BASE_URL');

        $notification          = [
            'body'  => $message['message'],
            'sound' => true,
        ];
        $extraNotificationData = $message;

        if ($deviceType == 'both') {
            $subscribers = ['android', 'ios'];
            foreach ($subscribers as $key => $subscriber) {
                $fcmNotification = [
                    'to'           => '/topics/' . $subscriber,
                    "collapse_key" => "type_a",
                    'data'         => $extraNotificationData
                ];
                if ($subscriber == 'ios') {
                    $fcmNotification['notification'] = $notification;
                }
                $fields = json_encode($fcmNotification);
                self::curlRequestPushNotification($fields);
            }
        } else {
            $fcmNotification = [
                'to'           => '/topics/' . $deviceType,
                "collapse_key" => "type_a",
                'data'         => $extraNotificationData
            ];
            if ($deviceType == 'ios') {
                $fcmNotification['notification'] = $notification;
            }
            $fields = json_encode($fcmNotification);
            self::curlRequestPushNotification($fields);
        }
    }

    /****
     * to get device tokens to whom we have to send notifications
     * @param array $param
     * @return : array
     *
     */
    protected static function getDeviceToken(array $param)
    {
        if (isset($param['user_id'])) {
            $user = User::find($param['user_id']);
            if (!$user || $user->push_status !== config('constants.STATUS.ACTIVE')) {
                return;
            }
        }

        $types = [''];
        if (isset($param['deviceType'])) {
            switch ($param['deviceType']) {
                case 'ios':
                    $types = ['ios'];
                    break;

                case 'android':
                    $types = ['android'];
                    break;

                default:
                    $types = ['android', 'ios'];
                    break;
            }
        }

        $tokens = DeviceToken::select('device_type', 'device_token')
            ->when(isset($param['deviceType']), function ($query) use ($types) {
                $query->whereIn('device_type', $types);
            })->when(isset($param['user_type']), function ($query) use ($param) {
                $query->where('user_type', $param['user_type']);
            })->when(isset($param['user_id']), function ($query) use ($param) {
                $query->where('user_id', $param['user_id']);
            })
            ->get();
        return $tokens;
    }


    /***
     * To hit CURL request for push notifications
     * @params json array of sending data
     * @return null
     */

    private static function curlRequestPushNotification($fields)
    {
        try {
            $url       = config('app.FCM.BASE_URL');
            $headers   = [
                'Authorization: key=' . config('app.FCM.FCM_KEY'),
                'Content-Type: application/json'
            ];
            $error_msg = null;
            $ch        = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            ($result);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }
            curl_close($ch);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            Log::error($response);
            //            CannabisLog::create($response); //inserting logs in the table

        }
    }

    /**
     * check if product of category_id status is active
     * @param $categoryId
     * @return bool
     */
    public static function checkProductAvailability($categoryId): bool
    {
        return CategoryProduct::where(['category_id' => $categoryId, 'status' => 'active'])->exists();
    }

    /**
     * @desc calculte percentage
     * @param $categoryId
     * @return bool
     */
    public static function getPercentageReview($percentage, $totalWidth)
    {


        if ($totalWidth == 0) {
            return 0;
        }
        $new_width = ($percentage / $totalWidth) * 100;

        return $new_width;
    }


    /**
     * @desc get first and last letter from full name
     * @param $categoryId
     * @return bool
     */
    public static function getfirstLastLetter()
    {
        $fullname     = Auth::guard("users")->user()->name;
        $string       = explode(' ', $fullname);
        $firstLetter  = ucfirst($string[0][0]);
        $secondLetter = '';
        if (!empty($string[1][0])) {
            $secondLetter = ucfirst($string[1][0]);
        }

        return $firstLetter . '' . $secondLetter;
    }

    /**
     * @param $storeId
     * @return bool
     */
    public static function getFirstStoreImage($storeId)
    {
        $storeImage = StoreImages::where('store_id', $storeId)->first();
        if ($storeImage)
            return $storeImage->file_url;

        return false;
    }

    /**
     * @param int $productId
     * @param int $storeId
     * @return bool
     */
    public static function checkSoldOutProduct(int $productId, int $storeId): bool
    {
        $storeProductStock = StoreProductStock::withCount('currentstock')->where(['product_id' => $productId, 'store_id' => $storeId])->first();
        $stock             = $storeProductStock->currentstock->sum('total_stock');
        if ($stock) return false;
        return true;
    }


    /**
     * @param int $productId
     * @param int $storeId
     * @return bool
     */
    public static function getStasticData($rated_id, $store_id = null, $type)
    {
        $initialRatings = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0
        ];

        $query = Rating::select('rate', DB::raw('count(*) as total'))
            ->where(['rated_id' => $rated_id, 'type' => $type]);

        if (isset($store_id) && !empty($store_id)) {

            $query = $query->where('store_id', $store_id);
        }

        $ratingsData = $query->groupBy('rate')->pluck('total', 'rate')->toArray();

        $ratingArray = $ratingsData + $initialRatings;
        krsort($ratingArray);

        return $ratingArray;
    }




    /**
     * @param int $productId
     * @param int $storeId
     * @return bool
     */
    public static function getStasticDataProduct($rated_id, $store_id = null, $type)
    {
        $initialRatings = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0
        ];

        $query = Rating::select('rate', DB::raw('count(*) as total'))
            ->where(['rated_id' => $rated_id, 'type' => $type]);

        // if (isset($store_id) && !empty($store_id)) {

        //     $query = $query->where('store_id', $store_id);

        // }

        $ratingsData = $query->groupBy('rate')->pluck('total', 'rate')->toArray();

        $ratingArray = $ratingsData + $initialRatings;
        krsort($ratingArray);

        return $ratingArray;
    }




    /****
     * Function getAvgRating to get average rating
     * @param : ratings array
     * @response: average value
     */

    public static function getAvgRating($ratings)
    {
        $count = 0;
        $sum   = 0;
        foreach ($ratings as $key => $value) {
            $count = $count + 1;
            $sum   = $sum + (int) $value->rate;
        }
        $result = 0;
        if ($count != 0) {
            $result = $sum / $count;
        }
        return $result;
    }

    /**
     * storeEarning function to get Total earning of the admin
     * @param : earning array
     * @return : float
     */
    public static function storeEarning($storeId)
    {
        $data            = StoreEarning::where('store_id', $storeId)->get();
        $last_settlement = $data->where('status', 'closed')->max('settlement_at');
        $amount_pending  = $data->where('status', 'open')->sum('commission');
        $total_earning   = $data->where('status', 'closed')->sum('commission');
        return [$amount_pending, $total_earning, $last_settlement];
    }

    /***
     * getOrderRelatedData function to get total no. & product detail sales and total discount
     * @request : encoded order data json
     * @response : total item count and total discount
     *
     */
    public static function getOrderRelatedData($orderData, $discount)
    {
        $decodedOrderData   = json_decode($orderData, true);
        $decodeDiscountData = json_decode($discount, true);
        $totalItemCount     = $decodedOrderData['itemCount'];
        $discount           = isset($decodeDiscountData['promo_discount']) ? (float) $decodeDiscountData['promo_discount'] : 0;
        $loyalityPoints     = isset($decodeDiscountData['loyaltyPoint']) ? (float) $decodeDiscountData['loyaltyPoint'] : 0;
        $totalDiscount      = $discount + $loyalityPoints;
        return [$totalItemCount, $totalDiscount];
    }

    /**
     * scheduler function for setting offered price.
     * @return void
     */
    public static function setRemoveOfferedPrice()
    {
        $now                = today(config('constants.SCHEDULER_DEFAULT_TIME_ZONE'));
        $storeProductStocks = StoreProductStock::with('currentstock')->whereDate('offer_start', '<=', $now)->whereDate('offer_end', '>=', $now)->get();
        if ($storeProductStocks->count() > 0) {
            foreach ($storeProductStocks as $storeProductStock) {
                foreach ($storeProductStock->currentstock as $currentstock) {
                    $storeProductStockUnit = StoreProductStockUnit::find($currentstock->id);
                    if ($currentstock->timely_offered_price) {
                        $storeProductStockUnit->offered_price     = $currentstock->timely_offered_price;
                        $storeProductStockUnit->price             = $currentstock->timely_offered_price;
                        $storeProductStockUnit->is_timely_offered = config('constants.ACTIVE');
                        $storeProductStockUnit->save();
                    }
                }
            }
        }

        $storeProductStocks = StoreProductStock::with('currentstock')->whereDate('offer_end', '<=', $now)->get();
        if ($storeProductStocks->count() > 0) {
            foreach ($storeProductStocks as $storeProductStock) {
                foreach ($storeProductStock->currentstock as $currentstock) {
                    $storeProductStockUnit = StoreProductStockUnit::find($currentstock->id);
                    if ($storeProductStockUnit->is_timely_offered == config('constants.ACTIVE')) {
                        $storeProductStockUnit->offered_price     = null;
                        $storeProductStockUnit->price             = $currentstock->actual_price;
                        $storeProductStockUnit->is_timely_offered = config('constants.NO');
                        $storeProductStockUnit->save();
                    }
                }
            }
        }
    }

    /***
     * deactivateStoreDelieveryLocation function is to deactivate store deliever location
     * and store cannot deliver product on that location.
     * @param : zipcode
     * @return 'success'
     * 
     */
    public static function deactivateStoreDelieveryLocation($zipcode)
    {
        $data = [
            'status' => config('constants.STATUS.BLOCKED')
        ];
        try {
            StoreDeliveryAddress::where('zip_code', $zipcode)->update($data);
        } catch (Exception $e) {
        }
        return 'success';
    }

    /**
     * getProductUnit to show product unit on ui
     * @param : database unit value
     * @return: string
     */

    public static function getProductUnit($unit)
    {
        if ('milligrams' == $unit) {
            return 'mg';
        }
        if ('grams' == $unit) {
            return 'g';
        }
        return $unit;
    }



    /**
     * @desc check if array  has duplicate
     */
    public static function checkDuplicate($array)
    {

        // streamline per @Felix
        return count($array) !== count(array_unique($array));
    }

    public static function updateQuantityOnCancelledOrder($storeId, $orderDetails)
    {
        foreach ($orderDetails as $key => $product) {
            $unit       = $product->unit;
            $size       = $product->size;
            $quantity   = $product->quantity;
            $productId  = $product->product_id;

            $stock =  StoreProductStockUnit::where(['quant_unit' => $unit, 'unit' => $size])
                ->whereHas('storeProductStock', function ($query) use ($storeId, $productId) {
                    $query->where(['store_id' => $storeId, 'product_id' => $productId]);
                })->first();
            $stock->total_stock = (int) $quantity + $stock->total_stock;
            $stock->save();
            $storeProduct                   = StoreProductStock::where(['store_id' => $storeId, 'product_id' => $productId])->first();
            $totalStock                     = (int) $quantity + $storeProduct->available_stock;
            $storeProduct->available_stock  = $totalStock;
            $storeProduct->save();
        }
        // return true;
    }



    /**
     * @desc handle exception
     * @param object of exception
     */
    public static function handleException($e)
    {
        $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        Log::error(trans('User::home.error_processing_request'), $errors);
        abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
