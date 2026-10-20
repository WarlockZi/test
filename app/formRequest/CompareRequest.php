<?php

namespace app\formRequest;

use app\formRequest\baseFormRequests\FormRequest1;

class CompareRequest extends FormRequest1
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'product_1s_id' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'product_1s_id.required' => 'Отсутствует product 1s id',
            'product_1s_id.string' => 'product 1s id должен быть строкой',
        ];
    }
}