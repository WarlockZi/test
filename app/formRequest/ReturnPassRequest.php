<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest2;


class ReturnPassRequest extends FormRequest2
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Заполните email.',
            'email.email' => 'email должен быть адресом электронной почты.',
        ];
    }

}