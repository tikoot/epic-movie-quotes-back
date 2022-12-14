<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username'              => 'required|regex:/^[a-z0-9]+$/u|min:3|max:15|unique:users',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:8|max:15',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
