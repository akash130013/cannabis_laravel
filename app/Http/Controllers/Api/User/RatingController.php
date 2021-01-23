<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\CommonHelper;
use App\Http\Services\OrderService;
use App\Transformers\RatingTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class RatingController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * RatingController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $param     = [
                'type'     => \request()->type,
                'rated_id' => \request()->rated_id,
                'pagesize' => request()->pagesize ?? config('constants.PAGINATE'),
                'api'      => true,
                'review_only' =>true,

            ];
            $validator = \Validator::make($param, [
                'type'     => ['required', Rule::in(['driver', 'store', 'product'])],
                'rated_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $ratings                = $this->orderService->getRating($param);
            $ratings['ratingCount'] = CommonHelper::ratingReviewCount($param['rated_id'], $param['type']);
            $ratings['reviewCount'] = CommonHelper::ratingReviewCount($param['rated_id'], $param['type'], 'review');
            $ratings['data']        = RatingTransformer::TransformReviewCollection($ratings);
            return response()->jsend($data = $ratings, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));


        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->request->add(['created_by' => $request->user()->id]);
            $validator = \Validator::make($request->all(), [
                'type'       => ['required', Rule::in(['driver', 'store', 'product'])],
                'rated_id'   => 'required',
                'rate'       => ['required', 'numeric', 'min:1', 'max:5'],
                'review'     => 'sometimes',
                'images'     => 'sometimes',
                'order_uid'  => ['required', 'exists:orders'],
                'created_by' => [Rule::unique('ratings')
                    ->where(function ($query) {
                        return $query->where([
                                'type'      => \request()->type,
                                'rated_id'  => \request()->rated_id,
                                'order_uid' => \request()->order_uid,
                            ]
                        );
                    })]
            ], [
                'type.in'           => 'type can be driver or store or product only',
                'order_uid.exists'  => 'order_uid is invalid',
                'created_by.unique' => $request->type . ' rating for this order has already submitted',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $order = $this->orderService->getOrders(['order_uid' => $request->order_uid])->first();
            $request->request->add(['order_id' => $order->id]);
            $request->request->add(['store_id' => $order->store_id]);
            $rating = $this->orderService->saveRatingData($request->all(['type', 'rated_id', 'rate', 'review', 'images', 'order_id', 'order_uid', 'store_id', 'created_by']));
            return response()->jsend($data = $rating, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @desc rate the product
     */
    public function saveBulkRating(Request $request)
    {
        try {
            $userId      = $request->user()->id;
            $requestData = collect($request->all())->map(function ($rating) use ($userId) {
                $rating['created_by'] = $userId;
                $rating['created_at'] = date('Y-m-d H:i:s');
                $rating['updated_at'] = date('Y-m-d H:i:s');
                return $rating;
            });
            $validator   = \Validator::make($requestData->toArray(), [
                '*.type'       => ['required', Rule::in(['driver', 'store', 'product'])],
                '*.rated_id'   => 'required',
                '*.rate'       => ['required', 'numeric', 'min:1', 'max:5'],
                '*.review'     => 'sometimes',
                '*.images'     => 'sometimes',
                '*.order_uid'  => ['required', 'exists:orders', function ($attribute, $value, $fail) use ($requestData) {
                    if ($value !== $requestData->first()['order_uid']) {
                        $fail('please check ' . $value);
                    }
                }],
                '*.created_by' => ['required', Rule::unique('ratings')
                    ->where(function ($query) use ($requestData) {
                        return $query->where([
                                'order_uid' => $requestData->first()['order_uid'],
                            ]
                        );
                    })],
            ], [
                '*.type.in'           => 'type can be driver or store or product only',
                '*.order_uid.exists'  => 'please check order_uid',
                '*.created_by.unique' => 'rating for this order has already submitted',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $order    = $this->orderService->getOrders(['order_uid' => $requestData->first()['order_uid']])->first();

            $requestData = $requestData->map(function ($rating) use ($order) {
                $rating['order_id'] = $order->id;
                $rating['store_id'] = $order->store_id;
                return $rating;
            });
            $this->orderService->saveRatingData($requestData->toArray(), true);
            $avgOrderRating = round(CommonHelper::fetchRatingData(['order_uid' => $requestData->first()['order_uid']])->avg('rate'), 1);
            return response()->jsend($data = $avgOrderRating, $presenter = null, $status = "success", $message = "data has been saved", $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

}
