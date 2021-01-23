<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Services\BookmarkService;
use App\Transformers\BookmarkTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    /**
     * @var BookmarkService
     */
    protected $bookmarkService;

    /**
     * BookmarkController constructor.
     * @param BookmarkService $bookmarkService
     */
    public function __construct(BookmarkService $bookmarkService)
    {
        $this->bookmarkService = $bookmarkService;
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

            $bookmarks = $this->bookmarkService->fetchMyBookMarks($param);
            $bookmarks['data'] = BookmarkTransformer::TransformCollection($bookmarks);

            return response()->jsend($data = $bookmarks, $presenter = null, $status = "bookmark added", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * @param Request $request
     * @param $storeId
     * @return mixed
     */
    public function store(Request $request, int $storeId)
    {
        try {
            $param = [
                'user_id'  => $request->user()->id,
                'store_id' => $storeId,
            ];

            $validator = Validator::make($param, [
                'store_id' => ['required', 'exists:store,id'],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $bookMarkStatus = $this->bookmarkService->createBookMark($param);
            if ($bookMarkStatus) {
                return response()->jsend($data = $bookMarkStatus, $presenter = null, $status = "success", $message = "bookmark added", $code = config('constants.SuccessCode'));
            }
            return response()->jsend_error(new \Exception('some error occurred'), $message = null, $code = $error['statusCode'] ?? 200);
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * @param $storeId
     * @return mixed
     */
    public function destroy($storeId)
    {
        try {
            $param = [
                'user_id'  => request()->user()->id,
                'store_id' => $storeId,
            ];

            $validator = Validator::make($param, [
                'store_id' => ['required', 'exists:store,id'],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $bookMarkStatus = $this->bookmarkService->removeBookMark($param);
//            if ($bookMarkStatus) {
                return response()->jsend($data = $storeId, $presenter = null, $status = "bookmark removed", $message = null, $code = config('constants.SuccessCode'));
//            }
//            return response()->jsend_error(new \Exception('some error occurred'), $message = null, $code = $error['statusCode'] ?? 200);
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }
}
