<?php

namespace app\formRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\NoReturn;


class LoginRequest extends FormRequest
{
    public function __construct(
        protected $allowedFields = ['email', 'password']
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
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
        ];
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
//    public function checkLoginCredentials(array $ajax): array
//    {
//        $errors = [];
//        if (!isset($ajax['email']))
//            $errors[] = 'Заполните почту';
//        if (!isset($ajax['password']))
//            $errors[] = 'Заполните пароль';
//        if (!$this->checkEmail($ajax['email']))
//            $errors[] = 'Неверный формат email';
//        if (!$this->checkPassword($ajax['password']))
//            $errors[] = "Пароль не должен быть короче 6-ти символов";
//        return $errors;
//    }

//    private function checkEmail(string $email): bool
//    {
//        $email = $this->cleanRequest($email);
//        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            return true;
//        }
//        return false;
//    }

//    private function cleanRequest($textrequest): string
//    {
//        $textrequest = trim($textrequest);
//        // Фиксируем атаки
//        if (preg_match("/script|http|<|>|<|>|SELECT|UNION|UPDATE|INSERT|exe|exec|tmp/i", $textrequest)) {
////         writelog('hack', date("y.m.d H:m:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$textrequest);
//            $textrequest = '';
//        }
//        // Очищаем опасные запросы
//        if (preg_match("/[=,:;\s]/", $textrequest)) {
//            $textrequest = '';
//        }
//        return $textrequest;
//    }

//    private function checkPassword(string $password): bool
//    {
//        $password = $this->cleanRequest($password);
//        if (strlen($password) >= 6) {
//            return true;
//        }
//        return false;
//    }


}