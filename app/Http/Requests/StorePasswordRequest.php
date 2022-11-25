<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password'                => 'required|regex:/^[a-z0-9]+$/u|min:3|max:15',
            'password_confirmation'   => 'required|same:password',
            'token'                   => 'required',
            'email'                   => 'required|email',
        ];
    }
}
