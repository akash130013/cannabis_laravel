<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MatchOldPassword;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       
        /*
        |
        | define validation rules
        |
        */


         return [
            'current_password' => ['required', new MatchOldPassword('store')],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ];
    }
}
