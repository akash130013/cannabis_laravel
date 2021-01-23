<?php

namespace App\Rules;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class CancelOrderRule implements Rule
{
    /**
     * @var $orderUid
     * @var $userId
     */
    protected $orderUid, $userId;
    private $message;
    /**
     * Create a new rule instance.
     * @param $orderUid
     * @param $userId
     * @return void
     */
    public function __construct($orderUid, $userId)
    {
        $this->orderUid = $orderUid;
        $this->userId   = $userId;
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
        $order = Order::where(['order_uid' => $this->orderUid, 'user_id' => $this->userId])->first();
        if (!$order) {
            $this->message = "User is not assigned to this order";
            return false;
        }
        if (!in_array($order->order_status, ['order_placed', 'order_confirmed', 'order_verified', 'driver_assigned'])) {
            $this->message = "order can not be cancelled at this stage";
            return false;
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
