<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest;

class CartRequest extends FormRequest
{
    protected array $allowedFields = [
        'count',
        'unit_id',
        'product_1s_id',
        'loc_storage_cart_id',
    ];

    public function rules(): array
    {
        return [
            'count' => 'required|integer',
            'unit_id' => 'required|string',
            'product_1s_id' => 'required|string',
            'loc_storage_cart_id' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'count.required' => 'count is to be string',
            'count.string' => 'count is to be string',
            'unit_id.required' => 'unit_id is required',
            'unit_id.string' => 'unit_id is to be string',
            'product_1s_id.required' => 'product_1s_id is required',
            'product_1s_id.string' => 'product_1s_id is to be string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function all($keys = null): array
    {
        return parent::all();
    }
}