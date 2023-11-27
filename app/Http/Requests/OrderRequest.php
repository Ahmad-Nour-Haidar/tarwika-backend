<?php

namespace App\Http\Requests;

class OrderRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'total_price' => 'required',
            'total_count' => 'required|numeric',
            'reservation_date_time' => 'required|string',
            'persons' => 'required|numeric',
//            'time' => 'required|string',
        ];
    }
}
