<?php

namespace App\Modules\Store\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Admin\Models\Category;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use App\Modules\Admin\Models\CategoryProduct;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exact;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{

    /**
     * index
     * @param : null
     * @return : application/html
     */


    public function index(Request $request)
    {
        $condition = [];
        $condition['store_id'] = Auth::guard('store')->user()->id;

        $condition['start'] = $request->has('start') && !empty($request->get('start')) ? date('Y-m-d', strtotime($request->get('start'))) : '';

        $condition['end'] = $request->has('end')  && !empty($request->get('end')) ? date('Y-m-d', strtotime($request->get('end'))) : '';

        $condition['status'] = empty($request->get('status')) ? "" :  $request->get('status');

        $condition['search'] = $request->has('search') ? $request->get('search') : "";

        $storeProduct = StoreProductStock::getAvailableStoreOffers($condition);
        //    dd($storeProduct);
        return view('Store::offers.index', compact('storeProduct'));
    }

    /**
     * showAdd
     *  @param : null
     *  @return : application/html
     */


    public function showAdd()
    {
        $category = Category::where('status', 'active')->get();

        return view('Store::offers.add', compact('category'));
    }


    /**
     * showOfferProducts
     * @param : search term
     * @return : application/json
     */

    public function showOfferProducts(Request $request)
    {
        try {

            /*
             |
             | show user list of products used.
             |
             */

            $condition = [];
            $condition['search'] = $request->get('term', '');
            $condition['category']   = $request->get('category_id', '');

            $products = StoreProductStock::getProductListingByOffer($condition);


            if (empty($products)) {

                return response()->json(['value' => 'No Product Found.', 'id' => '0', 'thc' => 0, 'cbd' => 0]);
            }

            $data = array();


            foreach ($products as $key => $product) {
                $data[] = array(
                    'value' => $product->product->product_name,
                    'thc' => $product->product->thc_per . '%',
                    'cbd' => $product->product->cbd_per . '%',
                    'image' => $product->product->getImage[0]->file_url,
                    'product_id' => $product->product->id,
                    'id' => $product->id
                );
            }

            if (count($data))
                $http_response_header = $data;
            else
                $http_response_header =  ['value' => 'No Product Found', 'id' => '', 'thc' => 0, 'cbd' => 0];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }


    /**
     * getAddProductOfferHTML 
     * @param : product stock Id
     * @return : application/html
     */

    public function getAddProductOfferHTML(Request $request)
    {

        try {

            $id = $request->get('id', '');

            $productStock = StoreProductStockUnit::where('stock_id', $id)->get();
            if (empty($productStock)) {

                throw new Exception(trans('Store::home.no_product_available_for_add'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $html = view('Store::offers.offer-price-edit', compact('productStock'))->render();
            $http_response_header = ['code' => Response::HTTP_OK, 'html' => $html];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }


    /**
     * getAddMoreOffersHtml
     * @param : request
     * @return : application/html
     */

    public function getAddMoreOffersHtml(Request $request)
    {

        try {

            $id = $request->get('product_id', '');


            $products = CategoryProduct::where('id', $id)->first();


            if (empty($products)) {

                throw new Exception(trans('Store::home.no_product_available_for_add'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data = json_decode($products->quantity_json);

            $html = view('Store::offers.add-more-offer', compact('data'))->render();

            $http_response_header = ['code' => Response::HTTP_OK, 'html' => $html];
        } catch (QueryException $e) {

            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        } catch (Exception $e) {

            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }



    /**
     * updateProductStatus 
     * @param : Request 
     * @return : application/json
     */

    public function updateOfferPrice(Request $request)
    {
        $rules = [
            'id' => 'required',
            'data' => 'required'
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

            $price = $request->get('data');

            $stockID = $request->get('id');



            $priceSort   = $price['actual_price'];
            $offeredSort = $price['offered_price'];
            $stockUnitId = $price['stock_unit_id'];
            for ($i = 0; $i < count($priceSort); $i++) {
                if ($priceSort[$i] < $offeredSort[$i]) {
                    return response()->json(
                        [
                            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                            'message' => trans('Store::home.offer_price_greater')
                        ]
                    );
                }
            }

            for ($i = 0; $i < count($stockUnitId); $i++) {

                $data = [
                    'is_timely_offered' => false,
                    'timely_offered_price' => NULL
                ];
                if ($offeredSort[$i] != NULL) {
                    $data = [
                        'is_timely_offered' => true,
                        'timely_offered_price' => $offeredSort[$i]
                    ];
                }
                StoreProductStockUnit::where(['id' => $stockUnitId[$i]])->update($data);
            }
            // loop through the price and offered price to get the final selling price of the product //
            sort($priceSort);
            sort($offeredSort);


            $is_single_product = sizeof($priceSort);

            $priceRange  = ($is_single_product == 1) ? '$' . number_format($priceSort[sizeof($priceSort) - 1],2)  : '$' . number_format($priceSort[0],2) . ' - ' . '$' . number_format($priceSort[sizeof($priceSort) - 1],2);


            // offered price range setup here  //


            $is_single_product = sizeof($offeredSort);

            $offerRange  = ($is_single_product == 1) ? '$' . number_format($offeredSort[sizeof($offeredSort) - 1],2)  : '$' . number_format($offeredSort[0],2) . ' - ' . '$' . number_format($offeredSort[sizeof($offeredSort) - 1],2);

            $storeProData = [
                'price_range' => $priceRange,

                'offer_range' => $offerRange,
            ];

            /*
            |
            | update product information with the lastes info.
            |
            */
            StoreProductStock::where('id', $stockID)->update($storeProData);
            $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.product_edited')];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }


    /**
     * updateOfferDates
     * @param : offer start 
     * @param : offer end 
     * @param : stockId
     * @return : application/json
     */


    public function updateOfferDates(Request $request)
    {
        try {

            $data = $request->get('data', '');
            $id = $request->get('id', '');

            if (empty($data) || empty($id)) {
                throw new Exception(trans('Store::home.data_is_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $startOffer  = empty($data['start']) ? null : date("Y-m-d", strtotime($data['start']));

            $endOffer  = empty($data['end']) ? null : date("Y-m-d", strtotime($data['end']));


            $stockData = StoreProductStock::find($id);
            $stockData->offer_start = $startOffer;
            $stockData->offer_end = $endOffer;
            $stockData->save();

            if (Carbon::parse($startOffer)->format('y-m-d') <= Carbon::today()->format('y-m-d') || 
                    Carbon::parse($endOffer)->format('y-m-d') == Carbon::today()->format('y-m-d')) {
                $data = [
                    'offered_price'             =>  DB::raw('timely_offered_price'),
                    'price'                     =>  DB::raw('timely_offered_price'),
                    'is_timely_offered'         =>  true,
                ];

                StoreProductStockUnit::where('stock_id', $id)->update($data);
            }

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('Store::home.offer_date_updated')
            ];
        } catch (Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }


    /**
     * cancelOfferStatus
     * @param : stock product ID
     * @return : application/json
     */

    public function cancelOfferStatus(Request $request)
    {
        $id = $request->get('id');

        try {
            if (empty($id)) {
                throw new Exception(trans('Store::home.id_field_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $stockID = decrypt($id);
            $stockData = StoreProductStock::find($stockID);
            $stockData->offer_start = null;
            $stockData->offer_end = null;
            $stockData->save();
            $data = [
                'offered_price'             =>  null,
                'is_timely_offered'         =>  false,
                'timely_offered_price'      =>  null,
                'price'                     =>  DB::raw('actual_price')
            ];
            StoreProductStockUnit::where('stock_id', $stockID)->update($data);

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('Store::home.offer_remove_successfully')
            ];
        } catch (Exception $e) {

            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }


        return response()->json($response);
    }


    /**
     * showEditOffer 
     * @param : encrypted ID
     * @return : application/json
     */

    public function showEditOffer(Request $request)
    {
        $id = $request->get('id');
        try {

            $stockID = decrypt($id);
            $storeProData = StoreProductStock::with('product')->find($stockID);
            // dd($storeProData);
            if (is_null($storeProData)) {

                throw new Exception(trans('Store::home.no_store_product_found'), Response::HTTP_NOT_FOUND);
            }

            $category = Category::where('status', 'active')->get();
            return view('Store::offers.edit-offer', compact('storeProData', 'category', 'stockID'));
        } catch (Exception $e) {

            return abort(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * getEditProductOfferHTML
     * @param : stock ID
     * @return : application/json --> html
     */


    public function getEditProductOfferHTML(Request $request)
    {

        try {

            $id = $request->get('id', '');

            $productStock = StoreProductStockUnit::where('stock_id', $id)->get();

            if (empty($productStock)) {

                throw new Exception(trans('Store::home.no_product_available_for_add'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $html = view('Store::offers.offer-price-update', compact('productStock'))->render();

            $http_response_header = ['code' => Response::HTTP_OK, 'html' => $html];
        } catch (QueryException $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        } catch (Exception $e) {
            $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
        }

        return response()->json($http_response_header);
    }


    /**
     * searchOfferByName
     * @param : search Term
     * @return : application/json
     */

    public function searchOfferByName(Request $request)
    {

        $searchTerm = $request->get('q', '');

        $condition = [];

        $condition['search'] = $searchTerm;

        $condition['start'] = $request->has('start') ? date('Y-m-d', strtotime($request->get('start'))) : date('Y-m-d', strtotime('today - 30 days'));

        $condition['end'] = $request->has('end') ? date('Y-m-d', strtotime($request->get('end'))) : date('Y-m-d');

        $condition['status'] = empty($request->get('status')) ? "" :  $request->get('status');

        $condition['store_id'] = Auth::guard('store')->user()->id;


        $result = StoreProductStock::getOfferNameByProduct($condition);


        $data = [];

        if ($result->count()) {

            foreach ($result as $key => $row) {

                $data[$key]['title'] = $row->product->product_name;
            }
        }

        return response()->json(['items' => $data]);
    }
}
