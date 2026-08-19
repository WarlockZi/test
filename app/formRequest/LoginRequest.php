<?php

namespace app\formRequest;



use app\formRequest\baseFormRequests\FormRequest2;


class LoginRequest extends FormRequest2
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Не заполнен email',
            'email.email' => 'email заполнен не правильно',

            'password.required' => 'Не заполнен пароль',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль содержал мало символов',
        ];
    }
    public function authorize(): bool
    {
        $sess = $this->all()['phpSession'];
        return $sess
            && $sess === session_id();
    }

}