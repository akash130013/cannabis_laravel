<?php


namespace App\Modules\Admin\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Admin\Models\CategoryProductImages;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Http\Response;

class ProductController extends Controller
{


    /**
     * index
     * @param : null
     * @return : application/json
     */
    public function index(Request $request)
    {
        $storeId    = $request->query('store_id') ?? '';
        $category   = Category::where('status', 'active')->get();
        return view('Admin::product.index', compact('category', 'storeId'));
    }


    /**
     * storeProducts
     * @param : post params 
     * @return : redirect back with error or success
     */

    public function storeProducts(Request $request)
    {
        $rules = [
            'product_name' => ['required', 'max:150'],
            'category' => ['required'],
            'qty' => ['required', 'array'],
            'thc_per' => ['required', 'between:0,99.99'],
            'cbd_per' => ['required', 'between:0,99.99'],
            'product_images' => ['required', 'array'],
            // 'is_trending' =>['required']
        ];
        $is_trending = false;

        if (!empty($request->get('is_trending')) && $request->get('is_trending') == true) {
            $is_trending = true;
        }
        $qty = request()->get('qty');
       

        [$flag, $duplcateMessage] = $this->checkDuplicateValidation($qty);

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails() || $flag == false) {
            if ($flag == false) {
                $validation->errors()->add('qty_error', $duplcateMessage);
            }

            return Redirect::back()->with('errors', $validation->errors())->withInput();
        }

        try {

            $products = new CategoryProduct();
            $products->category_id = $request->get('category');
            $products->product_name = $request->get('product_name');

            $qty = $request->get('qty');

            $qtyJson  = [];

            foreach ($qty['unit'] as $key => $val) {
                $qtyJson[] = ['unit' => $val, 'quant_units' => $qty['quant_units'][$key]];
            }

            $products->quantity_json    = json_encode($qtyJson);
            $products->product_desc     = empty($request->get('product_desc')) ? "" : $request->get('product_desc');
            $products->thc_per          = $request->get('thc_per');
            $products->cbd_per          = $request->get('cbd_per');
            $products->status           = $request->get('status');
            $products->is_trending      = $is_trending;

            $products->save();

            /*
            |
            | save product images if provided by admin.
            |
            */

            if (!empty($request->get('product_images'))) {

                $images = $request->get('product_images');
                foreach ($images as $key => $val) {

                    $storeProductImages = new CategoryProductImages();
                    $storeProductImages->product_id = $products->id;
                    $storeProductImages->file_url = $val;
                    $storeProductImages->save();
                }
            }
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with('error', trans('Admin::messages.error'));
        }
        return redirect()->route('admin.product.listing')->with(['message' => trans('Admin::messages.product_created_success'), 'type' => 'success']);
    }


    /**
     * @desc check if duplicate
     */
    public static function checkDuplicateValidation($qty)
    {
        $qtyJsonArr = [];
        $message    = 'You can not add same quantity and size';
        foreach ($qty['unit'] as $key => $val) {
            if ($qty['quant_units'][$key] <= 0) {
                $message = 'Please enter a valid size';
                return [false, $message];
            }
            $qtyJsonArr[$val][] = $qty['quant_units'][$key];
        }
        $flag1 = false;
        $flag2 = false;
        if (isset($qtyJsonArr['grams']) && !empty($qtyJsonArr['grams'])) {
            $flag1 = CommonHelper::checkDuplicate($qtyJsonArr['grams']);
            if ($flag1 == true) {
                return [false, $message];
            }
        }
        if (isset($qtyJsonArr['grams']) && !empty($qtyJsonArr['milligrams'])) {
            $flag2 = CommonHelper::checkDuplicate($qtyJsonArr['milligrams']);
            if ($flag2 == true) {
                return [false, $message];
            }
        }

        return [true, 'success'];
    }

    /**
     * showAddProduct
     * 
     */
    function showAddProduct()
    {
        try {
            $category = Category::where('status', 'active')->get();

            return view('Admin::product.add', ['category' => $category]);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with('errorLog', trans('Admin::messages.error'));
        }
    }


    /**
     * detail Page
     * @desc used for the showing detail of the product
     */
    function show(Request $request)
    {
        try {
            $product_id = decrypt($request->id);
            $data = CategoryProduct::where('id', $product_id)->first();
            $data->load(['getCategory', 'getImage', 'getAvgRating']);
            $data->encrypt_id = encrypt($data->id);
            $count = StoreProductStock::getPackingStoreCount($product_id);
            // if($data->status == config('constants.STATUS.BLOCKED'))
            // {
            //     return Redirect::back();
            // }
            return view('Admin::product.product-details', compact('data', 'count'));
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            // return Redirect::back()->with('error', trans('Admin::messages.error'));
        }
    }


    /**
     * edit Page
     * @desc used for the showing detail of the product
     */
    function edit(Request $request)
    {
        try {

            $product_id = decrypt($request->id);
            $data = CategoryProduct::with(['getCategory', 'getImage'])->where('id', $product_id)->first();
            $category = Category::where('status', 'active')->get();

            return view('Admin::product.edit', compact('data', 'category'));
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }
    }

    /**
     * update Page
     * @desc used for the showing detail of the product
     * @date 10-07-19
     */
    function update(Request $request)
    {

        $rules = [
            'product_name' => 'required|max:150',
            'qty' => 'required|array',
            'category' => 'required',
            'thc_per' => 'required|between:0,99.99',
            'cbd_per' => 'required|between:0,99.99',
            'product_images' => 'required|array',
            'status' => 'required',
        ];

        $qty = request()->get('qty');
        
        if (is_null($qty)) {
            return redirect()->back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }


        [$flag, $duplcateMessage] = $this->checkDuplicateValidation($qty);
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails() || $flag == false) {
            if ($flag == false) {
                $validation->errors()->add('qty_error', $duplcateMessage);
            }

            return Redirect::back()->with('errors', $validation->errors())->withInput();
        }
        $is_trending = false;
        if (!empty($request->get('is_trending')) && $request->get('is_trending') == true) {
            $is_trending = true;
        }
        try {


            DB::beginTransaction();
            $product_id = decrypt($request->id);
            $products = CategoryProduct::findOrFail($product_id);
            $products->category_id = $request->get('category');
            $products->product_name = $request->get('product_name');

            if ($request->has('deleted_size') && $request->has('deleted_unit')) {
                $this->deleteSizeAndUnit($request->deleted_size, $request->deleted_unit, $product_id); //deleted in store panel
                $this->deletefromUserCart($request->deleted_size, $request->deleted_unit, $product_id); //deleted in user panel
            }

            $qty = $request->get('qty');

            $qtyJson  = [];

            foreach ($qty['unit'] as $key => $val) {

                $qtyJson[] = ['unit' => $val, 'quant_units' => $qty['quant_units'][$key]];
            }

            $products->quantity_json        = json_encode($qtyJson);
            $products->product_desc         = empty($request->get('product_desc')) ? "" : $request->get('product_desc');
            $products->thc_per              = $request->get('thc_per');
            $products->cbd_per              = $request->get('cbd_per');
            $products->status               = $request->get('status');
            $products->is_trending          = $is_trending;

            $products->save();



            /*
            |
            | save product images if provided by admin.
            |
            */

            if (!empty($request->get('product_images'))) {
                CategoryProductImages::where('product_id', $product_id)->delete(); //deleting images 
                $images = $request->get('product_images');
                foreach ($images as $key => $val) {
                    $storeProductImages = new CategoryProductImages();
                    $storeProductImages->product_id = $products->id;
                    $storeProductImages->file_url = $val;
                    $storeProductImages->save();
                }
            }
        } catch (QueryException $e) {
            DB::rollBack();

            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            dd($response);
            return Redirect::back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }
        DB::commit();
        return redirect()->route('admin.product.listing')->with(['message' => trans('Admin::messages.product_updated_success'), 'type' => 'success']);
        return view('Admin::product.edit', compact('data', 'category'));
    }


    /***
     * @desc this will be delted all the available qunaity and size 
     */
    private function deleteSizeAndUnit($size, $unit, $product_id)
    {

        $stock = StoreProductStock::select(['id'])->where('product_id', $product_id)->get()->toArray();
        $ids = array_column($stock, 'id');
        $sizeArr = explode(',', $size);
        $unitArr = explode(',', $unit);

        // foreach ($ids as $index => $id) {
        foreach ($sizeArr as $key => $value) {
            $temp = [
                'unit' => $unitArr[$key],
                'quant_unit' => $value,
            ];
            StoreProductStockUnit::whereIn('stock_id', $ids)->where($temp)->delete();
        }
        // }
        return true;
    }


    /***
     * @desc this will be delted all the available qunaity and size 
     */
    private function deletefromUserCart($size, $unit, $product_id)
    {
        $sizeArr = explode(',', $size);  //grams and mg
        $unitArr = explode(',', $unit);  //in digits

        $findProduct = Cart::where('product_id', $product_id)->whereIn('size', $sizeArr)->whereIn('size_unit', $unitArr)->get();

        if (count($findProduct) > 0) {
            Cart::where('product_id', $product_id)->whereIn('size', $sizeArr)->whereIn('size_unit', $unitArr)->delete();
            return true;
        }
        return true;
    }

    /***
     * To show product related review and rating
     * @request :encrypted product id
     * @return application/html
     */
    public function showProductRatings($encryptProductId = null)
    {
        try {
            if ($encryptProductId) {
                $data  = CategoryProduct::select('product_name')->find(decrypt($encryptProductId));
                return view('Admin::product.rating-index', compact('encryptProductId', 'data'));
            }
            return abort(Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
