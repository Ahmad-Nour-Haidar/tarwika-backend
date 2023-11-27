<?php


namespace App\Http\Requests;

class StoreCartRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'item_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'size' => 'required|string',
            'count' => 'required|numeric',
        ];
    }
}
