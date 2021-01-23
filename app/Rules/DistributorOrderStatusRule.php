<?php

namespace App\Rules;

use App\Http\Services\OrderService;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Contracts\Validation\Rule;

class DistributorOrderStatusRule implements Rule
{
    /**
     * @var $orderUid
     * @var $distributorId
     */
    protected $orderUid, $distributorId, $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($orderUid, $distributorId)
    {
        $this->orderUid      = $orderUid;
        $this->distributorId = $distributorId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!in_array($value, ['on_delivery', 'delivered', 'amount_received'])) {
            $this->message = "Order status can be on_delivery, delivered or amount received";
            return false;
        }

        $order = Order::where('order_uid', $this->orderUid)->first();
        if (!$order) {
            $this->message = "Invalid order_uid";
            return false;

        } else if ($order->order_status == $value) {
            $this->message = "This order has already has " . trans('order.'.$value) . " status";
            return false;
        }

        if ($order->distributors->first()->id !== $this->distributorId) {
            $this->message = "Order is not assigned to you";
            return false;

        }

        $orderService = new OrderService(new Order, new Rating);

        switch ($value) {
            case "on_delivery":
                // find all orders
                $param      = [
                    'distributor_id' => $this->distributorId,
                    'order_status'   => 'on_delivery'
                ];
                $orderCount = $orderService->getOrders($param)->count();
                if ($orderCount > 0) {
                    $this->message = "You are already on delivery of another order";
                    return false;
                }
                break;
            case "delivered":
                if ($order->order_status !== "on_delivery") {
                    $this->message = "On_delivery status should preceded by on_delivery status";
                    return false;
                }
                break;
            case "amount_received":
                if ($order->order_status !== "delivered") {
                    $this->message = "amount_received status should preceded by delivered status";
                    return false;
                }
                break;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
