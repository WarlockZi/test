<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest;
use app\formRequest\baseFormRequests\FormRequest2;

class CartRequest extends FormRequest2
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'count' => 'required|string',
            'unit_id' => 'required|string',
            'product_1s_id' => 'required|string',
            'loc_storage_cart_id' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'count.required' => 'count is required',
            'count.string' => 'count is to be string',
            'unit_id.required' => 'unit_id is required',
            'unit_id.string' => 'unit_id is to be string',
            'product_1s_id.required' => 'product_1s_id is required',
            'product_1s_id.string' => 'product_1s_id is to be string',
        ];
    }

}