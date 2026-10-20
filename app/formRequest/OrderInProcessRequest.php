<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest1;

class OrderInProcessRequest extends FormRequest1
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|string',
            'in_process' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'order_id is required',
            'order_id.string' => 'order_id is to be string',

            'in_process.required' => 'in_process is required',
            'in_process.string' => 'in_process is to be boolean',
        ];
    }

}