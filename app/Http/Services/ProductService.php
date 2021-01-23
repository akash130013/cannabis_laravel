<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Product;
use App\Models\StoreDetail;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\StoreProductStock;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * @var $product
     */
    public $product;

    protected $order = [
        '1' => 'max',
        '2' => 'max',
        '3' => 'created_at',
        '4' => 'created_at',
        '5' => 'is_trending',
        '6' => 'created_at',
        '7' => 'avg_rate',
    ];

    protected $ascDesc = [
        '1' => 'desc',
        '2' => 'asc',
        '3' => 'asc',
        '4' => 'desc',
        '5' => 'asc',
        '6' => 'desc',
        '7' => 'desc',
    ];

    /**
     * ProductService constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function getProducts($param = [])
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $products = $this->product->with(['category', 'product_images'])->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                if (is_array($param['id']))
                    return $q->whereIn('id', $param['id']);
                else
                    return $q->where('id', $param['id']);
            })
            ->when(isset($param['name']), function ($q) use ($param) {
                return $q->where('name', 'LIKE', $param['name']);
            })
            ->when(isset($param['status']), function ($q) use ($param) {
                return $q->where('status', $param['status']);
            })->when(isset($param['is_trending']), function ($q) use ($param) {
                return $q->where('is_trending', $param['is_trending']);
            })->when(isset($param['category_id']), function ($q) use ($param) {
                return $q->where('category_id', $param['category_id']);
            })->when(isset($param['excludeIds']), function ($q) use ($param) {
                return $q->whereNotIn('id', $param['excludeIds']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $products = CommonHelper::restPagination($products->paginate($param['pagesize']));
            } else {
                $products = $products->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $products = $products->get();
        }

        return $products;
    }

    public function productPriceRange($productId)
    {
        $priceRange = StoreProductStock::where(['product_id' => $productId])->first();
        if ($priceRange) {
            return $priceRange->price_range;
        }
        return "0 - 0";
    }

    public function getTrendingProducts()
    {
        $products = $this->product->all();
        $products->map(function ($item) {
            return $item->category->name;
        });

        return $products;
    }

    /**
     * @param array $param
     * @return StoreProductStock
     */
    public function getStoreProducts($param = [])
    {
        $products = StoreProductStock::select('store_product_stock.*', 'category_products.id','category_products.avg_rate', 'category_products.is_trending')
            ->join('category_products', 'category_products.id', '=', 'store_product_stock.product_id')
            ->with(['store'         => function ($query) use ($param) {
                $query->with(['storeImages']);
            }, 'storeDetail', 'delivery', 'product' => function ($query) use ($param) {
                $query->with(['getCategory', 'getImage']);
            }])->whereHas('product', function ($query) use ($param) {
                if (isset($param['search']) && !empty(isset($param['search']))) {
                    $query->where('product_name', 'LIKE', '%' . $param['search'] . '%');
                }
                $query->when(isset($param['store_id']), function ($q) use ($param) {
                    if (is_array($param['store_id'])) {
                        $q->whereIn('store_id', $param['store_id']);
                    } else {
                        $q->where('store_id', $param['store_id']);
                    }
                });

                $query->when((isset($param['status']) && !empty($param['status'])), function ($q) use ($param) {
                    return $q->where('status', $param['status']);
                })->when((isset($param['is_trending']) && !empty($param['is_trending'])), function ($q) use ($param) {
                    return $q->where('is_trending', $param['is_trending']);
                });
            })->whereHas('product.getCategory', function ($query) use ($param) {
                $query->where('status', 'active');
                if (isset($param['cannabis_type']) && !empty($param['cannabis_type'])) {
                    if (is_array($param['cannabis_type']))
                        $query->whereIn('category_id', $param['cannabis_type']);
                    else
                        $query->where('category_id', $param['cannabis_type']);
                }
            })->when((isset($param['store_id']) && !empty($param['store_id'])), function ($query) use ($param) {
                if (is_array($param['store_id']))
                    $query->whereIn('store_id', $param['store_id']);
                else
                    $query->where('store_id', $param['store_id']);
            })
            ->when((isset($param['product_id']) && !empty($param['product_id'])), function ($query) use ($param) {
                if (is_array($param['product_id']))
                    $query->whereIn('product_id', $param['product_id']);
                else
                    $query->where('product_id', $param['product_id']);
            })
            ->when((isset($param['sorting_id']) && !empty($param['sorting_id'])), function ($query) use ($param) {
                if ($param['sorting_id'] !== 7 || $param['sorting_id'] !== 5) {
                    $query->orderBy($this->order[$param['sorting_id']], $this->ascDesc[$param['sorting_id']]);
                }
            })
            ->when((isset($param['dealonly']) && $param['dealonly'] == true), function ($q) {
                return $q->whereDate('offer_start', '<=', now())
                    ->whereDate('offer_end', '>=', now());
            })
            ->where('store_product_stock.status', 'active')
            ->when((isset($param['longitude']) && isset($param['latitude'])), function ($query) use ($param) {
                $query->whereHas('storeDetail', function ($q) use ($param) {
                    $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
                });
            })
            ->whereHas('store', function ($query) {
                $query->where(['status'=>'active', 'is_admin_approved' => 1]);
            });

        if (isset($param['zipcode']) && !empty($param['zipcode'])) {
            $products->where(function ($q) use ($param) {
                $q->whereHas('delivery', function ($query) use ($param) {
                    $query->where('zip_code', $param['zipcode']);
                });
            });
        }

        if (isset($param['stock_availability']) && $param['stock_availability'] == config('constants.STOCK.INSTOCK')) {  //for instock
            $products->where('available_stock', '>', 0);
        }
        if (isset($param['stock_availability']) && $param['stock_availability'] == config('constants.STOCK.OUTSTOCK')) {  //for out of stock
            $products->where('available_stock', '=', 0);
        }


        if (isset($param['price_range']) && is_array($param['price_range']) && count($param['price_range']) === 2) {  //for out of stock
            $products->where(function ($q) use ($param) {
                $q->whereBetween('min', $param['price_range'])
                    ->orWhereBetween('max', $param['price_range']);
            });
        }
        if (isset($param['sorting_id']) && $param['sorting_id'] == 7) {
            $products->orderBy('avg_rate', $this->ascDesc[$param['sorting_id']]);
        }
        if (isset($param['sorting_id']) && $param['sorting_id'] == 5) {
            $products->orderBy('is_trending', $this->ascDesc[$param['sorting_id']]);
        }
        if (isset($param['unique']) && $param['unique'] == "product_id") {
            $products->distinct('category_products.id');
        }

//        $products->distinct('product_id');

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $products = CommonHelper::restPagination($products->paginate($param['pagesize']));
            } else {
                $products = $products->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $products = $products->get();
        }
        return $products;
    }


    /**
     * @param array $param
     * @return StoreProductStock
     */
    public static function getStoreProductByID($param = [])
    {
        $query = StoreProductStock::with(['storeDetail', 'product' => function ($query) {

            $query->with('getCategory');

            $query->with('getImage');
        }])
            ->with(['currentstock'])
            ->has('currentstock')
            ->when(isset($param['store_id']), function ($query) use ($param) {
                $query->where('store_id', $param['store_id']);
            })
            ->when(isset($param['id']), function ($query) use ($param) {
                $query->where('product_id', $param['id']);
            })
            ->when((isset($param['longitude']) && isset($param['latitude']) && !isset($param['store_id'])), function ($query) use ($param) {
                $query->whereHas('storeDetail', function ($q) use ($param) {
                    return $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
                });
            });

        return $query->first();
    }


    /**
     * @param array $param
     * @return StoreProductStock
     */
    public static function getFirstStoreByProductID($param = [])
    {
        return StoreProductStock::with(['storeDetail', 'currentstock', 'store' => function ($query) use ($param) {
            $query->with(['storeImages', 'storeDetail'])->whereStatus('active');
        }])
            ->when(isset($param['id']), function ($query) use ($param) {
                $query->where('product_id', $param['id']);
            })
            ->when((isset($param['longitude']) && isset($param['latitude']) && !isset($param['store_id'])), function ($query) use ($param) {
                $query->whereHas('storeDetail', function ($q) use ($param) {
                    return $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
                });
            })
            ->when(isset($param['store_id']), function ($query) use ($param) {
                //                $query->where('store_id', '!=', $param['store_id']);
                $query->where('store_id', $param['store_id']);
            })
            ->first();
    }

    /**
     * count products as per store.
     * @param $storeId
     * @return mixed
     */
    public function countProductByStoreId($storeId)
    {
        $query= StoreProductStock::with(['product.getCategory'])
        ->where(['status' =>'active'])
        ->where(['store_id' => $storeId]);
       
       $query =$query->whereHas('product.getCategory',function($q){
            return $q->where('status','active');
        });

        return $query->count();
    }

    /**
     * count stores as per product.
     * @param $productId
     * @return mixed
     */
    public function countStoreByProductId($productId, $longitude, $latitude)
    {
        return StoreProductStock::with('storeDetail')
            ->when((isset($longitude) && isset($latitude)) && !empty($latitude) && !empty($longitude), function ($q) use ($longitude, $latitude) {
                $q->whereHas('storeDetail', function ($query) use ($longitude, $latitude) {
                    $query->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $latitude . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
                });
            })
            ->where(['product_id' => $productId])
            ->count();
    }

    /**
     * Min and Max Price across the system for filter purpose
     * @return mixed
     */
    public function filterMinMaxPrices()
    {
        return StoreProductStock::selectRaw(" IFNULL(MIN(min),0) AS StartFrom, IFNULL(MAX(max),0) AS EndTo")->first();
    }


    public function getStoreByLocationProductId(array $param)
    {
        $storeIds                   = StoreDetail::select('store_id')
            ->when((isset($param['longitude']) && isset($param['latitude'])), function ($q) use ($param) {
                return $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
            })
            ->get()->pluck('store_id')->toArray();
        $storeProductStock_storeIds = StoreProductStock::where('product_id', $param['product_id'])->get()->pluck('store_id')->toArray();
        $firstStoreId               = @array_values(array_intersect($storeIds, $storeProductStock_storeIds))[0];
        return @StoreDetail::where('store_id', $firstStoreId)->first();

    }
}
