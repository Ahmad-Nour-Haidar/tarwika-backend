<?php

namespace App\Http\Requests;

class LoginUserRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
}
