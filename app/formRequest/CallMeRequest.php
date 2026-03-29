<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest2;

class CallMeRequest extends FormRequest2
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'phone' => 'string',
            'php_session' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.string' => 'phone is to be string',
            'php_session.string' => 'php_session is to be string',
        ];
    }

}