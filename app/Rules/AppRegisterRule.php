<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class AppRegisterRule implements Rule
{
    /**
     * @var $countryCode
     * @var $message
     */
    private $countryCode, $message;
    /**
     * Create a new rule instance.
     * @param $countryCode
     * @return void
     */
    public function __construct($countryCode)
    {
        $this->countryCode = $countryCode;
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
        $user = User::where(['country_code' => $this->countryCode, 'phone_number' => $value])->first();
        if (!$user) return true;

        if ($user->phone_number_verified_at){
            $this->message = "Phone number already registered";
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
