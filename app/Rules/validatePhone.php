<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;


class validatePhone implements Rule
{
    private $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
       
        $phoneNumber=request()->full_phone;
        $country_code=request()->phone_code;
        $phoneNumber  = preg_replace("/^\+?{$country_code}/", '',$phoneNumber);   //to remove country code and 0 from input
        return  !User::where(['phone_number'=> $phoneNumber,'deleted_at' => null])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('User::home.existing_number');
    }
}
