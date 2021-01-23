<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Helpers\CommonHelper;
use App\Http\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

/**
 * Class NotificationController
 * @package App\Http\Controllers\Api\User
 * @author Sumit Sharma
 */
class NotificationController extends Controller
{
    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * NotificationController constructor.
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function myNotifications(Request $request)
    {
        try {
            $param = [
                'pagesize'  => $request->pagesize ?? config('constants.PAGINATE'),
                'status'    => 'active',
                'api'       => true,
                'user_id'   => $request->user()->id,
                'user_type' => config('constants.userType.driver'),
            ];

            $notifications = $this->notificationService->getUserNotification($param);
            return response()->jsend($data = $notifications, $presenter = null, $status = "success", $message = 'Notification List', $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    public function readNotification($id)
    {
        try {
            $validator = \Validator::make(['id' => $id], [
                'id' => [
                    'required',
                    Rule::exists('user_notifications')->where(function ($query) use ($id){
                        $query->where(['user_id' => \request()->user()->id, 'user_type' => config('constants.userType.driver'), 'id' => $id]);
                    })
                ],
            ],[
                'id.exists' => 'Id is not associated with current user',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $status = $this->notificationService->readUserNotification($id);
            if ($status){
                return response()->jsend($data = null, $presenter = null, $status = "success", $message = 'Notification', $code = config('constants.SuccessCode'));
            }
            return response()->jsend_error(new \Exception("some error in reading notification"), $message = null);
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }
}
