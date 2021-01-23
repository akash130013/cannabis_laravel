<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class referalValidate implements Rule
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
        
        if(isset(request()->referal_code)){
            return USER::where('user_referral_code', request()->referal_code)->exists();
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Referal code is not valid.';
    }
}
