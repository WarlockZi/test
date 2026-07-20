<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;

class CartDeleteRowRequest extends FormRequest1
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|string',
            'product_1s_id' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'Требуется поле order_id',
            'order_id.string' => 'order_id должно быть строкой',
            'product_1s_id.required' => 'Требуется поле product_1s_id',
            'product_1s_id.string' => 'product_1s_id должно быть строкой',
        ];
    }
    public function authorize(): bool
    {
        return !empty($this->json('phpSession'));
    }
}