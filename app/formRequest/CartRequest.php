<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest4;

class CartRequest extends FormRequest4
{
    public function __construct(
        protected array $allowedFields = [
            'product_1s_id',
            'count',
            'unit_id',
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
            'product_1s_id' => 'required|string',
            'unit_id'=>'required|int',
            'loc_storage_cart_id'=>'string',
        ];
    }

    public function messages(): array
    {
        return [
            'count.required' => 'count is to be string',
            'count.string' => 'count is to be string',
            'product_1s_id.required' => 'product_1s_id is required',
            'product_1s_id.string' => 'product_1s_id is to be string',
            'unit_id.required' => 'unit_id is required',
            'unit_id.string' => 'unit_id is to be string',
        ];
    }

    public function all($keys=null): array
    {
        return parent::all();
    }
}