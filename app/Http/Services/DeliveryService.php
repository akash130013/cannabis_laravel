<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Order;
use App\Modules\User\Models\UserDeliveryLocation;

class DeliveryService
{
    /**
     * @param array $param
     * @return mixed
     */
    public function getUserDeliverAddress(array $param)
    {
        return UserDeliveryLocation::where($param)->latest()->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function saveAddress(array $data)
    {
        return UserDeliveryLocation::Create($data);
    }

    /**
     * @param array $selector
     * @param array $data
     * @return mixed
     */
    public function updateAddress(array $selector, array $data)
    {
        return UserDeliveryLocation::where($selector)->update($data);
    }

    /**
     * delete user delivery location
     * @param array $param
     * @return mixed
     */
    public function deleteAddress(array $param)
    {
        return UserDeliveryLocation::where($param)->delete();
    }


    public function fetchOrders($param = [])
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $orders = Order::select($selectColumn)->with(['user', 'stores'])
            ->when(isset($param['user_id']), function ($q) use ($param) {
                return $q->where('user_id', $param['user_id']);
            })->when(isset($param['order_status']), function ($q) use ($param) {
                if (is_array($param['order_status']))
                    return $q->whereIn('order_status', $param['order_status']);
                else
                    return $q->where('order_status', $param['order_status']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $orders = CommonHelper::restPagination($orders->paginate($param['pagesize']));
            } else {
                $orders = $orders->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $orders = $orders->get();
        }

        return $orders;

    }
}
