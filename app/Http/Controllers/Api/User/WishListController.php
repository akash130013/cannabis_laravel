<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Services\WishListService;
use App\Transformers\WishListTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WishListController extends Controller
{
    /**
     * @var wishListService
     */
    protected $wishListService;

    /**
     * WishListController constructor.
     * @param WishListService $wishListService
     */
    public function __construct(WishListService $wishListService)
    {
        $this->wishListService = $wishListService;
    }

    public function index(Request $request)
    {
        try {
            $param = [
                'user_id'  => $request->user()->id,
                'pagesize' => $request->pagesize ?? config('constants.PAGINATE'),
                'status'   => 'active',
                'api'      => true,
            ];

            $wishLists = $this->wishListService->fetchMyWishLists($param);

            $wishLists['data'] = WishListTransformer::TransformCollection($wishLists);

            return response()->jsend($data = $wishLists, $presenter = null, $status = "WishList", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * @param Request $request
     * @param $productId
     * @return mixed
     */
    public function store(Request $request, $productId)
    {
        try {
            $param = [
                'user_id'  => $request->user()->id,
                'product_id' => $productId,
            ];

            $validator = Validator::make($param, [
                'product_id' => ['required', 'exists:category_products,id'],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $wishListStatus = $this->wishListService->createWishList($param);
            if ($wishListStatus) {
                return response()->jsend($data = $wishListStatus, $presenter = null, $status = "success", $message = "Product added to WishList Successfully", $code = config('constants.SuccessCode'));
            }

            return response()->jsend_error(new \Exception('some error occurred'), $message = null);
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * @param $productId
     * @return mixed
     */
    public function destroy($productId)
    {
        try {
            $param = [
                'user_id'  => request()->user()->id,
                'product_id' => $productId,
            ];

            $validator = Validator::make($param, [
                'product_id' => ['required', 'exists:category_products,id'],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $wishListStatus = $this->wishListService->removeWishList($param);
//            if ($wishListStatus) {
                return response()->jsend($data = $productId, $presenter = null, $status = "success", $message = "Product removed from WishList Successfully", $code = config('constants.SuccessCode'));
//            }
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }
}
