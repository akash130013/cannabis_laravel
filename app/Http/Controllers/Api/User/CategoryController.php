<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Services\CategoryService;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $pageSize =  $request->pagesize ?? config('constants.PAGINATE');
            $param = [
                'pagesize'  => $pageSize,
                'status'    => 'active',
                'api'       => true,
            ];

            
            $categories = $this->categoryService->getCategories($param);
            $categories['data'] = CategoryTransformer::TransformCollection($categories);
            return response()->jsend($data = $categories, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage(). ' on file '.$exception->getFile().' at line '.$exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }


    /**
     * Display  all categories
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function allCategory(Request $request)
    {
        try {
           $param = [
               'status' => 'active'
           ];

            $categories = $this->categoryService->getCategories($param);
            // $categories['data'] = CategoryTransformer::TransformCollection($categories);
            return response()->jsend($data = $categories, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage(). ' on file '.$exception->getFile().' at line '.$exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

}
