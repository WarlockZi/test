<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest4;

class CartRequest extends FormRequest4
{
    public function __construct(
        protected array $allowedFields = [
            'count',
            'order_product_id',
            'product_unit_id',
            'loc_storage_cart_id',
        ]
    )
    {
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'count' => 'required|integer',
            'order_product_id' => 'required|string',
            'product_unit_id' => 'required|string',
//            'unit_id'=>'required|int',
            'loc_storage_cart_id'=>'string',
        ];
    }

    public function messages(): array
    {
        return [
            'count.required' => 'count is to be string',
            'count.string' => 'count is to be string',
            'order_product_id.required' => 'product_1s_id is required',
            'order_product_id.string' => 'product_1s_id is to be string',
            'product_unit_id.required' => 'unit_id is required',
            'product_unit_id.string' => 'unit_id is to be string',
        ];
    }

    public function all($keys=null): array
    {
        return parent::all();
    }
}