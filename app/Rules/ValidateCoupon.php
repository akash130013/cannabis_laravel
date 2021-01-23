<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCoupon implements Rule
{
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
        return request()->total_coupon >= request()->used_coupon;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Total coupon can not less than Used coupon Or Invalid total coupon.';
    }
}
