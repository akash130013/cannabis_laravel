<?php


namespace App\Modules\Store\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use App\Modules\Store\Models\StoreProductRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * index
     * @param : null
     * @return : application/json
     *
     */


    public function index(Request $request)
    {
        try {

            $category              = Category::getStoreCategory(Auth::guard('store')->user()->id)->sortBy('category_name');
            $query                 = Input::get();
            $page                  = $request->page;
            $condition             = [];
            $condition['search']   = isset($query['search']) ? $query['search'] : null;
            $condition['stock']    = isset($query['stock']) ? $query['stock'] : config('constants.STOCK.ALL');
            $condition['category'] = isset($query['category']) ? $query['category'] : null;
            $data                  = StoreProductStock::getProductListing($condition);

            $countArr  = $this->showCount();
            $pageinate = $data->toArray();
            return view('Store::product.index', compact('category', 'data', 'pageinate', 'query', 'countArr'));
        } catch (QueryException $e) {

            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];

            Log::error(trans('User::home.error_processing_request'), $http_response_header);

            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


        /**
     * index
     * @param : null
     * @return : application/json
     *
     */

    public function requestedProduct(Request $request)
    {
        try {

            $query                 = Input::get();
            $page                  = $request->page;
            $condition             = [];
            $condition['search']   = isset($query['search']) ? $query['search'] : null;
            $condition['stock']    = isset($query['stock']) ? $query['stock'] : config('constants.STOCK.ALL');
            $condition['category'] = isset($query['category']) ? $query['category'] : null;
            $data                  = StoreProductRequest::getStoreRequestedProduct($condition);
            
            $countArr  = $this->showCount();
            $pageinate = $data->toArray();
            return view('Store::product.requested-product', compact('data', 'pageinate', 'query', 'countArr'));
        } catch (QueryException $e) {

            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];

            Log::error(trans('User::home.error_processing_request'), $http_response_header);

            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @desc get all count displaying in the listing filter
     */
    public function showCount()
    {

        $countArr['allCount']       = StoreProductStock::where('store_id', Auth::guard('store')->user()->id)->count();
        $countArr['instock_count']  = StoreProductStock::where('store_id', Auth::guard('store')->user()->id)->where('available_stock', '>', 0)->count();
        $countArr['outstock_count'] = StoreProductStock::where('store_id', Auth::guard('store')->user()->id)->where('available_stock', '=', 0)->count();

        return $countArr;
    }

    /**
     * showAddProduct
     * @param : null
     * @return : application/html
     */

    public function showAddProduct()
    {
        $category = Category::where('status', config('constants.STATUS.ACTIVE') )->get();

        return view('Store::product.add-product', ['category' => $category]);
    }

    /**
     * showProductList
     * @param : null
     * @return : application/html
     */

    public function showProductList(Request $request)
    {
        try {

            /*
            |
            | show user list of products used.
            |
            */

            $condition             = [];
            $condition['search']   = $request->get('term', '');
            $condition['category'] = $request->get('category_id', '');
            $condition['store_id'] = Auth::guard('store')->user()->id;

            $products = CategoryProduct::showProductList($condition);


            if (empty($products)) {

                return response()->json(['value' => 'Add New', 'category_id' => '', 'id' => '', 'thc' => 0, 'cbd' => 0]);
            }

            $data = array();


            foreach ($products as $product) {
                $data[] = array(
                    'value'       => $product->product_name,
                    'image'       => @$product->getImage->first()->file_url,
                    'category_id' => $product->category_id,
                    'thc'         => $product->thc_per . '%',
                    'cbd'         => $product->cbd_per . '%',
                    'id'          => $product->id
                );
            }

            if (count($data))
                $http_response_header = $data;
            else
                $http_response_header = ['value' => 'Add New', 'id' => '', 'thc' => 0, 'cbd' => 0];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }


    /**
     * showQuantity
     * @param : product_id
     * @return : application/json
     */

    public function showQuantity(Request $request)
    {

        try {


            $id = $request->get('id', '');

            $products = CategoryProduct::where('id', $id)->first();


            if (empty($products)) {

                throw new Exception(trans('Store::home.no_product_available_for_add'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data = array('quantity_json' => json_decode($products->quantity_json), 'id' => $products->id);

            $http_response_header = ['code' => Response::HTTP_OK, 'data' => $data];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }

    /**
     * showDataImagesPrice
     * @param : product_id
     * @return : application/json
     */

    public function showDataImagesPrice(Request $request)
    {

        try {


            $id = $request->get('id', '');

            $products = CategoryProduct::getProductImagesDataByID($id);

            if (empty($products)) {

                throw new Exception('Error processing request', Response::HTTP_BAD_REQUEST);
            }

            $data = array(
                'quantity_json' => json_decode($products->quantity_json),

                'product_desc' => $products->product_desc,

                'product_name' => $products->product_name,

                'thc_per' => $products->thc_per,

                'cbd_per' => $products->cbd_per,

                'category_id' => $products->category_id,

                'file_url' => $products->file_url,

                'category_name' => $products->category_name,

                'image_url' => $products->image_url,

                'id' => $products->id
            );

            $http_response_header = ['code' => Response::HTTP_OK, 'data' => $data];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }

    /**
     * submitStoreProductData
     * @param : post array of data
     * @return : application/json
     */

    public function submitStoreProductData(Request $request)
    {

        $rules = [
            'product_id' => 'required',
            'store_id'   => 'required',
            'price'      => 'required',
            'pro_desc'   => 'required',
        ];


        $validation = Validator::make($request->all(), $rules);

        try {

            if ($validation->fails()) {
                return response()->json(['code' => Response::HTTP_BAD_REQUEST, 'errors' => $validation->errors()]);
            }


            /*
            |
            | iterate over price data for cumulative result
            |
            */

            $price = $request->get('price');

            $data = array();

            $stockSum  = array_sum($price['packet']);
            $priceSort = $price['price'];

            // loop through the price and offered price to get the final selling price of the product //

            foreach ($priceSort as $key => $val) {
                if (!empty($price['offered'][$key])) {
                    $priceSort[$key] = $price['offered'][$key];
                }
            }

            sort($priceSort);

            $is_single_product = sizeof($priceSort);

            $min = ($is_single_product == 1) ? 0 : $priceSort[0];
            $max = ($is_single_product == 1) ? $priceSort[0] : $priceSort[sizeof($priceSort) - 1];

            $priceRange = ($is_single_product == 1) ? '$' . number_format($priceSort[sizeof($priceSort) - 1],2) : '$' . number_format($priceSort[0],2) . ' - ' . '$' . number_format($priceSort[sizeof($priceSort) - 1],2);


            $storeProData = [
                'product_id'      => $request->get('product_id'),
                'store_id'        => $request->get('store_id'),
                'available_stock' => $stockSum,
                'total_stock'     => $stockSum,
                'price_range'     => $priceRange,
                'min'             => $min,
                'max'             => $max,
                'pro_desc'        => $request->get('pro_desc', ''),
                // 'status'          => config('constants.STATUS.BLOCKED')
            ];
            if(Auth::guard('store')->user()->admin_action == config('constants.STATUS.PENDING'))
            {
                $storeProData['status'] = config('constants.STATUS.BLOCKED');
            }

            /*
            |
            | remove any of the existing same products.
            |
            */

            $productID = $request->get('product_id');
            $storeID   = $request->get('store_id');
            StoreProductStock::where('product_id', $productID)->where('store_id', $storeID)->delete();

            $createStoreProduct = StoreProductStock::create($storeProData);

            foreach ($price['unit'] as $key => $val) {

                $offeredPrice = empty($price['offered'][$key]) ? null : $price['offered'][$key];
                $priceNew     = empty($price['price'][$key]) ? $price['offered'][$key] : $price['price'][$key];

                $data = [
                    'stock_id'      => $createStoreProduct->id,
                    'unit'          => $price['unit'][$key],
                    'quant_unit'    => $price['quant_unit'][$key],
                    'price'         => $priceNew,
                    'actual_price'  => $price['price'][$key],
                    'offered_price' => $offeredPrice,
                    'total_stock'   => $price['packet'][$key]
                ];

                StoreProductStockUnit::create($data);
            }

            $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.product_added')];


        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }

    /**
     * updateStoreProduct
     * @param : request array
     * @return : application/json
     */

    public function updateStoreProduct(Request $request)
    {

        $rules = [
            'id'         => 'required',
            'product_id' => 'required',
            'price*'     => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        try {

            if ($validation->fails()) {
                return response()->json(['code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'errors' => $validation->errors()]);
            }
            /*
            |
            | iterate over price data for cumulative result
            |
            */
            $price = $request->get('price');
            $data  = array();
            // foreach ($price['price'] as $key => $val) {
            //     // dd([$price['offered'][$key],$price['price'][$key]]);

            //     if(!empty($price['offered'][$key]))
            //     {
            //         if($price['offered'][$key]>$price['price'][$key])
            //         {
            //             return response()->json(['code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'message' => sprintf(trans('Store::home.actual_prize_less_then_error'),++$key)],Response::HTTP_UNPROCESSABLE_ENTITY);
            //         }
            //     }
            //  }
            $stockSum  = array_sum($price['packet']);
            $priceSort = $price['price'];

            // loop through the price and offered price to get the final selling price of the product //

            foreach ($priceSort as $key => $val) {
                if (!empty($price['offered'][$key])) {
                    $priceSort[$key] = $price['offered'][$key];
                }
            }


            sort($priceSort);

            $stockID   = $request->get('id');
            $productID = $request->get('product_id');

            $is_single_product = sizeof($priceSort);


            $min = ($is_single_product == 1) ? 0 : $priceSort[0];
            $max = ($is_single_product == 1) ? $priceSort[0] : $priceSort[sizeof($priceSort) - 1];

            $priceRange = ($is_single_product == 1) ? '$' . number_format($priceSort[sizeof($priceSort) - 1],2) : '$' . number_format($priceSort[0],2) . ' - ' . '$' . number_format($priceSort[sizeof($priceSort) - 1],2);


            $storeProData = [
                'product_id'      => $productID,
                'store_id'        => $request->get('store_id'),
                'available_stock' => $stockSum,
                'total_stock'     => $stockSum,
                'price_range'     => $priceRange,
                'min'             => $min,
                'max'             => $max,
                'pro_desc'        => $request->get('pro_desc', '')
            ];

            /*
            |
            | update product information with the lastes info.
            |
            */

            StoreProductStock::where('id', $stockID)->update($storeProData);

            StoreProductStockUnit::where('stock_id', $stockID)->delete();


            foreach ($price['unit'] as $key => $val) {

                $offeredPrice = empty($price['offered'][$key]) ? null : $price['offered'][$key];
                $priceNew     = empty($price['price'][$key]) ? $price['offered'][$key] : $price['price'][$key];

                $data = [
                    'stock_id'      => $stockID,
                    'unit'          => $price['unit'][$key],
                    'quant_unit'    => $price['quant_unit'][$key],
                    'price'         => $priceNew,
                    'total_stock'   => $price['packet'][$key],
                    'actual_price'  => $price['price'][$key],
                    'offered_price' => $offeredPrice
                ];

                StoreProductStockUnit::create($data);
            }

            $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.product_edited')];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }

    /**
     * showProductDetail
     * @param : encrypted product id
     * @return : application/html
     */

    public function showProductDetail(Request $request, $id)
    {
        $product = StoreProductStock::getStoreProductByID($id);

        $reviews = Rating::withProduct($id)->where('store_id', $product->store_id)->where('review', '!=', null)->with('user')->paginate(5);

        $stasticData = CommonHelper::getStasticData($product->product_id, $product->store_id, config('constants.ratingType.product'));
       
        $avgRating = CommonHelper::fetchAvgRating($product->product_id, config('constants.ratingType.product'), $product->store_id);
        $ratingCount = Rating::where(['type'=>config('constants.ratingType.product'),'rated_id'=> $product->product_id])->count();
        $reviewCount = Rating::where(['type'=>config('constants.ratingType.product'),'rated_id'=> $product->product_id,'store_id'=>$product->store_id])->where('review','!=',null)->count();

        
        $ratingReviewCount = CommonHelper::ratingReviewCount($product->product_id, config('constants.ratingType.product'), null, $product->store_id);

       
        if (empty($product) || empty($product->product) || $product->product->status ==  config('constants.STATUS.BLOCKED')) {
            return Redirect()->route('store.product.dashboard');
        }

        return view('Store::product.product-detail', [
            'product'           => $product,
            'ratings'           => $reviews,
            'avgRating'         => $avgRating,
            'statsticData'      => $stasticData,
            'ratingReviewCount' => $ratingReviewCount,
            'ratingCount' =>  $ratingCount,
            'reviewCount' =>  $reviewCount,
        ]);
    }

    /**
     * showEditProduct
     * @param : id
     * @return : application/html
     */

    public function showEditProduct($id)
    {

        $product = StoreProductStock::getStoreProductByID($id);

        if (empty($product)) {
            return Redirect()->route('store.product.dashboard');
        }

        return view('Store::product.product-edit', ['product' => $product]);
    }

    /**
     * deleteStoreProduct
     * @param : request param
     * @return : application/json
     */

    public function deleteStoreProduct(Request $request)
    {

       
        $rules = [
            'productID' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        try {

            if ($validation->fails()) {
                return response()->json(['code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'errors' => $validation->errors()]);
            }

            /*
            |
            | update product information with the lastes info.
            |
            */

            $stockID = $request->get('productID');

            StoreProductStock::where('id', $stockID)->delete();

            $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.product_removed')];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }

    /**
     * getProductAddMoreOptions
     * @param : null
     * @return : application/json
     *
     */

    public function getProductAddMoreOptions(Request $request)
    {
        $productID = $request->get('id');

        $product = CategoryProduct::where('id', $productID)->first();

        $data = view('Store::product.edit-add-more-price', ['hash' => time(), 'productArr' => json_decode($product->quantity_json)])->render();

        $http_response_header = ['code' => Response::HTTP_OK, 'html' => $data];

        return response()->json($http_response_header);
    }


    /**
     * @desc used for the adding more product on the data
     */
    public function requestedProductCreate(Request $request)
    {

        $rules = [
            'product_name' => 'required',
            'thc'          => 'required',
            'cbd'          => 'required',
            'product_desc' => 'required',
            'category_id'  => 'nullable|integer',
        ];
  
       
        $validation = Validator::make($request->all(), $rules);

        try {

            if ($validation->fails()) {
                return redirect()->back()->with('errors', $validation->errors())->withInput();
            }

            /*
            |
            | insert product information
            |
            */
            DB::beginTransaction();

            $requestProduct               = new StoreProductRequest();
            $requestProduct->store_id     = Auth::guard('store')->user()->id;
            $requestProduct->product_name = $request->product_name;
            $requestProduct->thc          = $request->thc;
            $requestProduct->cbd          = $request->cbd;
            $requestProduct->category_id  = $request->category_id ?? null;
            $requestProduct->product_desc = $request->product_desc;
            $result                       = $requestProduct->save();
            if (!$result) {
                throw new Exception(trans('User::home.error'), Response::HTTP_NOT_FOUND);
            }

            DB::commit();
            $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.product_request_success')];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
         
            return redirect()->back()->with('error', $http_response_header);
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
           
            return redirect()->back()->with('error', $http_response_header);
        }

        return redirect()->route('store.product.add-page')->with('success', $http_response_header);
    }


    /**
     * searchProduct
     * @param : query string
     * @return : application/json_
     */

    public function searchProduct(Request $request)
    {

        $searchTerm          = $request->get('q', '');
        $condition           = [];
        $condition['search'] = $searchTerm;
        $result              = StoreProductStock::getProductNameAndCategory($condition);

        $data = [];

        if ($result->count()) {

            foreach ($result as $key => $row) {
                $data[$key]['category'] = $row->category_name;
                $data[$key]['title']    = $row->product_name;
            }
        }

        return response()->json($data);
    }
}
