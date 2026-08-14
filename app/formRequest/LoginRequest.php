<?php

namespace app\formRequest;


use app\formRequest\baseFormRequests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\NoReturn;


class LoginRequest extends FormRequest
{
    public function __construct(
        protected $allowedFields = ['email', 'password', 'phpSession']
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

    public function all($keys = null): array
    {
        return [
            'email' => $this->json('email'),
            'password' => $this->json('password'),
            'phpSession'=>$this->json('phpSession'),
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
        return isset($this->phpSession)
            && $this->phpSession === session_id();
    }

    #[NoReturn] protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }

}