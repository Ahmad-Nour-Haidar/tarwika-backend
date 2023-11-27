<?php

namespace App\Http\Requests;

class RegisterUserRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|string|unique:users|email',
            'name' => 'required|string|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string',
            'image' => 'file',
        ];
    }
}
