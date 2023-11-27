<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'code' => 'required|numeric',
        ];
    }
}
