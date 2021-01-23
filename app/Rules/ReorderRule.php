<?php

namespace App\Rules;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class ReorderRule implements Rule
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

        if ($order->stores->status !== config('constants.STATUS.ACTIVE')) {
            $this->message = "Store is currently unavailable ";
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
