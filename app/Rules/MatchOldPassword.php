<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MatchOldPassword implements Rule
{

    protected $guard = null;

     /**
     * Create a new rule instance.
     * @param $orderUid
     * @return void
     */
    public function __construct($guard)
    {
        $this->guard  = $guard;
       
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
        return Hash::check($value, auth()->guard($this->guard)->user()->password);
    }
   
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not match with your old password.';
    }
}
