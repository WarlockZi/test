<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest;


class ReturnPassRequest extends FormRequest
{
    public function __construct(
        protected $allowedFields = ['email']
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function all($keys = null): array
    {
        return $this->input;
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Заполните email.',
            'email.email' => 'email должен быть адресом электронной почты.',
        ];
    }
//    public function authorize(): bool
//    {
//        return isset($this->phpSession)
//            && $this->phpSession === session_id();
//    }

}