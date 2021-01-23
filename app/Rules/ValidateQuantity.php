<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateQuantity implements Rule
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
        dd("");
        $qty = request()->get('qty');
       
        $flag=true;
        $qtyJson=[];
        foreach ($qty['unit'] as $key => $val) {
            $qtyJson[$val] = $qty['quant_units'][$key];
        }
       dd($qtyJson);
       
       return $flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
