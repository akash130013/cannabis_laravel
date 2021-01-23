<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\DeviceToken;
use App\Models\UserNotification;
use App\User;

/**
 * Class NotificationService
 * @package App\Http\Services
 * @author Sumit Sharma
 */
class NotificationService
{
    /**
     * @var UserNotification
     */
    protected $userNotification;

    /**
     * NotificationService constructor.
     */
    public function __construct()
    {
        $this->userNotification = new UserNotification;
    }

    /**
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    public function getUserNotification($param = [])
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $ratings = $this->userNotification->select($selectColumn)
            ->when(isset($param['user_id']), function ($q) use ($param) {
                return $q->where('user_id', $param['user_id']);
            })
            ->when(isset($param['user_type']), function ($q) use ($param) {
                return $q->where('user_type', $param['user_type']);
            });
        if (isset($param['sortBy']) && isset($param['sortOrder'])) {
            $ratings = $ratings->orderBy($param['sortBy'], $param['sortOrder']);
        } else {
            $ratings = $ratings->latest();
        }
        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $ratings = CommonHelper::restPagination($ratings->paginate($param['pagesize']));
            } else {
                $ratings = $ratings->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $ratings = $ratings->get();
        }
        return $ratings;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function readUserNotification($id)
    {
        $userNotification = $this->userNotification->find($id);
        $userNotification->is_read = 1;
        return $userNotification->save();
    }

    public function changeUserPushStatus($userId, $pStatus)
    {
        $user = User::find($userId);
        $user->push_status = $pStatus;
        if ($pStatus == config('constants.STATUS.BLOCKED')){
            $deviceTokens = DeviceToken::where(['user_type'=> config('constants.userType.user'), 'user_id' => $userId])->get();
            foreach ($deviceTokens as $deviceToken) {
                CommonHelper::subscribeUnsubscribeTopic($deviceToken->device_type, $deviceToken->device_token, config('constants.SUBSCRIPTION_OPTION.INACTIVE'));
            }
        }elseif ($pStatus == config('constants.STATUS.ACTIVE')){
            $deviceTokens = DeviceToken::where(['user_type'=> config('constants.userType.user'), 'user_id' => $userId])->get();
            foreach ($deviceTokens as $deviceToken) {
                CommonHelper::subscribeUnsubscribeTopic($deviceToken->device_type, $deviceToken->device_token, config('constants.SUBSCRIPTION_OPTION.ACTIVE'));
            }

        }

        if ($user->save()) return true;
        return false;
    }

}
