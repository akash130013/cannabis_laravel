<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateStoreTiming implements Rule
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
        $workingHours = json_decode(request()->get('workinghours'), true);
       
        $flag=true;

      foreach ($workingHours as $key => $val) {
        if ($val['isActive']) {
           
            if($val['timeFrom']>$val['timeTill']){
                $flag=false;
                break;
            }
        } 
    }
       
       
       return $flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('Store::home.store_timing_validation');
    }
}
