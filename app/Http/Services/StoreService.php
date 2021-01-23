<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Product;
use App\Models\StoreDetail;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreTiming;
use App\Store;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StoreService
{
    public $store;
    public $storeDetail;

    public function __construct(Store $store, StoreDetail $storeDetail)
    {
        $this->store       = $store;
        $this->storeDetail = $storeDetail;
    }

    public function getStores($param = [])
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $stores = $this->store->with('store_detail')->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['name']), function ($q) use ($param) {
                return $q->where('name', 'LIKE', $param['name']);
            })
            ->when(isset($param['status']), function ($q) use ($param) {
                return $q->where('status', $param['status']);
            })
            ->when((isset($param['longitude']) && isset($param['latitude'])), function ($q) use ($param) {
                return $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( latitude ) )  *  cos( radians( longitude ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( latitude ) ) ) ) <= 5 "));
            });
        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $stores = CommonHelper::restPagination($stores->paginate($param['pagesize']));
            } else {
                $stores = $stores->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $stores = $stores->get();
        }

        return $stores;

    }

    public function getStoreDetails($param = [])
    {
//        DB::connection()->enableQueryLog();
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $stores = StoreDetail::
        with(['store' => function ($query){$query->with(['storeImages']);}])
//            with(['store', 'store_images' => function ($query){$query->with(['storeImages']);}])
            ->select($selectColumn)
            ->whereHas('store', function ($query) use ($param) {
                $query->where('status', $param['status'] ?? 'active')->where('is_admin_approved', config('constants.YES'));
            })
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['store_id']), function ($q) use ($param) {
                return $q->where('store_id', $param['store_id']);
            })
            ->when((isset($param['rating']) && $param['rating'] != 'all'), function ($q) use ($param) {
                // @todo: when rating module is completed
            })
            ->when((isset($param['search']) && $param['search'] != ''), function ($q) use ($param) {
                return $q->where('store_name', 'like', '%' . $param['search'] . '%');
            })
            ->when(isset($param['storeIds']), function ($q) use ($param) {
                return $q->whereIn('store_id', $param['storeIds']);
            })
            ->when(isset($param['name']), function ($q) use ($param) {
                return $q->where('name', 'LIKE', $param['name']);
            })
            ->when((isset($param['longitude']) && isset($param['latitude'])), function ($q) use ($param) {
                return $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
            });
        if (isset($param['longitude']) && isset($param['latitude'])) {
            $stores = $stores->addSelect(DB::raw('( 6367 * acos( cos( radians( '.$param['latitude'].' ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( '.$param['longitude'].' ) ) + sin( radians( '.$param['latitude'].' ) ) * sin( radians( lat ) ) ) ) AS distance'))->orderBy('distance', 'asc');
        }

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $stores = CommonHelper::restPagination($stores->paginate($param['pagesize']));
            } else {
                $stores = $stores->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $stores = $stores->get();
        }

//        return DB::getQueryLog();
        return $stores;

    }

    /**
     * get storeIds by productId
     * @param int $productId
     * @return array
     */
    public function getStoreIdByProductId(int $productId)
    {
        $storeIds = StoreProductStock::with('store')
            ->whereHas('store', function ($query) {
                return $query->where('status', 'active');
            })
            ->where('product_id', $productId)->get(['store_id']);
        return Arr::pluck($storeIds, 'store_id');
    }

    /**
     * @param $categoryIds
     * @return array
     */
    public function getStoreIdByCategoryId($categoryIds)
    {
        $where = Product::where('category_id', $categoryIds);
        if (is_array($categoryIds)) {
            $where = Product::whereIn('category_id', $categoryIds);
        }

        $productIds      = $where->get(['id']);
        $productIdsArray = Arr::pluck($productIds, 'id');
        $productIdArr = [];
        foreach ($productIdsArray as $data) {
            $productIdArr[] = $this->getStoreIdByProductId($data);
        }
        return array_values(array_unique(Arr::collapse($productIdArr)));

    }

    /**
     * @param $storeId
     * @return array
     */
    public function fetchStoreTimeTable($storeId)
    {
        $storeTimeTable = StoreTiming::where('store_id', $storeId)->get();
        foreach ($storeTimeTable as $data) {
            $timeTable[] = [
                'day'            => $this->convertDay($data->day),
                'start_time'     => Carbon::parse($data->start_time)->format('h:i A'),
                'end_time'       => Carbon::parse($data->end_time)->format('h:i A'),
                'working_status' => $data->working_status,
            ];
        }
        return $timeTable;
    }

    /**
     * @param $dayId
     * @return string
     */
    protected function convertDay($dayId)
    {
        switch ($dayId) {
            case 1:
                $dayName = "Monday";
                break;
            case 2:
                $dayName = "Tuesday";
                break;
            case 3:
                $dayName = "Wednesday";
                break;
            case 4:
                $dayName = "Thursday";
                break;
            case 5:
                $dayName = "Friday";
                break;
            case 6:
                $dayName = "Saturday";
                break;
            default:
                $dayName = "Sunday";

        }

        return $dayName;

    }

}
