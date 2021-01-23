<?php


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Admin\Models\CategoryProductImages;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;
class ProductCategoryController extends Controller
{

  
    /**
     * index
     * @param : null
     * @return : application/json
     */

     public function index()
     {
         
         return view('Admin::category.index');

     }


    /**
     * @desc create category
     * @date 10/09/19
     *      * 
     */
    public function create()
    {
    
        return view('Admin::category.create');
    }

    /**
     * storeProducts
     * @param : post params 
     * @return : redirect back with error or success
     */

    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required|max:150',
            'product_images'=>'required',
            'status'=>'required',
        ];
    
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()) {
            return Redirect::back()->with('errors',$validation->errors())->withInput();
        }
        try 
        {
            DB::beginTransaction();
            $category = new Category();
            $category->category_name = $request->get('category_name');
            $category->status = $request->get('status');
            $category->image_url=$request->get('product_images')[0];
            $category->category_desc=$request->product_desc ?? null;
            $category->thumb_url=$request->thumbUrl ?? null;
            $category->save();
            DB::commit();
            return redirect()->route('admin.category.index')->with(['message'=>trans('Admin::messages.category_create_success'),'type'=>'success']);
        } catch (QueryException $e) {
            
            DB::rollBack();
            $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message'=>trans('Admin::messages.error'),'type'=>'error']);
        }
       

    }

  


     /**
     * detail Page
     * @desc used for the showing detail of the product
     */
    function show(Request $request)
    {
        try{
         
        $cat_id=decrypt($request->id);
        $data= Category::where('id',$cat_id)->first();
        $data->encrypt_id = encrypt($data->id);
      return view('Admin::category.show',compact('data'));
    } catch (QueryException $e) {
        $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
        CannabisLog::create($response);  //inserting logs in the table
        return Redirect::back()->with(['message'=>trans('Admin::messages.error'),'type'=>'error']);
    }
    }


    /**
     * edit Page
     * @desc used for the showing detail of the product
     */
    function edit(Request $request)
    {
        try {
           
            $cat_id=decrypt($request->id);
            $data= Category::where('id', $cat_id)->first();
            return view('Admin::category.edit', compact('data'));
        }   catch (QueryException $e) {
            $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message'=>trans('Admin::messages.error'),'type'=>'error']);
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
            'category_name' => 'required|max:150',
            'product_images'=>'required',
            'status'=>'required',
        ];
         
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()) {
            return Redirect::back()->with('errors',$validation->errors())->withInput();
        }
        try 
        {
            DB::beginTransaction();
            $cat_id=decrypt($request->id);
            $category=Category::find($cat_id);
            $category->category_name = $request->get('category_name');
            $category->status = $request->get('status');
            $category->image_url=$request->get('product_images')[0];
            $category->category_desc=$request->product_desc ?? null;
            $category->thumb_url=$request->thumbUrl ?? null;
            $category->save();
          
            DB::commit();
            return redirect()->route('admin.category.index')->with(['message'=> trans('Admin::messages.category_update_success'),'type'=>'success']);
        } catch (QueryException $e) {
            DB::rollBack();
            $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with(['message'=> trans('Admin::messages.error'),'type'=>'error']);
        }
       
    }

}
