<?php

namespace App\Http\Requests;

class VerifyUserRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'code' => 'required|numeric',
        ];
    }
}
