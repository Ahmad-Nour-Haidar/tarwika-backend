<?php

namespace App\Http\Requests;

class UpdateUserRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|unique:users',
            'phone' => 'string|unique:users',
            'image' => 'file',
        ];
    }
}
