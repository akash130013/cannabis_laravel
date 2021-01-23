<?php

namespace App\Rules;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class TrackOrdeRule implements Rule
{
    private $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $order = Order::where(['order_uid' => $value, 'user_id' => request()->user()->id])->first();
        if (!$order) {
            $this->message = "User is not assigned to this order";
            return false;
        }

        $driver = $order->distributors->first();
        if (!$driver){
            $this->message = "Driver is not assigned";
            return false;
        }
        if ($order->order_status !== trans('order.order_status_enum.on_delivery')){
            $this->message = "Driver has not marked for delivery yet";
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
