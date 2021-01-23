<?php


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\StoreProductRequest;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Admin\Models\CategoryProductImages;
use App\Modules\Store\Models\StoreProductStockUnit;
use App\Modules\Store\Models\StoreProductStock;
use App\Notifications\ProductApprovedNotification;
use App\Store;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB;

class ProductRequestController extends Controller
{


    /**
     * index
     * @param : null
     * @return : application/json
     */

    public function index()
    {

        return view('Admin::product.productRequest.index');
    }

    /**
     * edit Page
     * @desc used for the showing detail of the product
     */
    function edit(Request $request)
    {
        try {

            $product_id = decrypt($request->id);
            $data = StoreProductRequest::with('category')->where('id', $product_id)->first();

            $category = Category::where('status', 'active')->get();
            return view('Admin::product.productRequest.edit', compact('data', 'category'));
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
    function update(Request $request, $id)
    {
        $rules = [
            'product_name' => 'required|max:150',
            'qty' => 'required|array',
            'thc_per' => 'required|between:0,99.99',
            'cbd_per' => 'required|between:0,99.99',
            'product_images' => 'required|array',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->with('errors', $validation->errors())->withInput();
        }

        try {

            $id = decrypt($id);
            $store_id = $request->store_id;
            $storeData = Store::findOrFail($store_id); //getiing the store detail for sending mail
            $category = Category::findOrFail($request->get('category')); //geting category name
            $products = new CategoryProduct();
            $products->category_id = $request->get('category');
            $products->product_name = $request->get('product_name');

            $qty = $request->get('qty');

            $qtyJson  = [];

            foreach ($qty['unit'] as $key => $val) {
                $qtyJson[] = ['unit' => $val, 'quant_units' => $qty['quant_units'][$key]];
            }

            $products->quantity_json = json_encode($qtyJson);
            $products->product_desc = empty($request->get('product_desc')) ? "" : $request->get('product_desc');
            $products->thc_per  = $request->get('thc_per');
            $products->cbd_per  = $request->get('cbd_per');

            $status = $products->save();

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


            if ($status) {
                StoreProductRequest::find($id)->update(['status' => 'approved']);
                $user = new User();
                $user->email = $storeData->email;
                $sendData = [
                    'user_name' => $storeData->name . ' ' . $storeData->last_name,
                    'product_name' => $request->get('product_name'),
                    'category_name' => $category->category_name,
                    'thc_per' => $request->get('thc_per'),
                    'cbd_per' => $request->get('cbd_per'),
                ];

                $user->notify(new ProductApprovedNotification($sendData));
            } else {
                return redirect()->route('admin.product.listing')->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
            }
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with('error', trans('Admin::messages.error'));
        }
        return redirect()->route('admin.product.listing')->with(['message' => trans('Admin::messages.product_approved_success'), 'type' => 'success']);
    }
}
