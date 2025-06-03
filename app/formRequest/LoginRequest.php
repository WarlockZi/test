<?php

namespace app\formRequest;

use app\service\Router\IRequest;

class LoginRequest extends Req
{
    public function __construct(IRequest $request)
    {
        parent::__construct($request);
        $this->validationData();
    }
    public function validationData(): array
    {
        $request = parent::validationData();

        $data['email'] = $request['body']['email'];
        $data['password'] = $request['body']['password'];

        return $data;
    }
    public function checkLoginCredentials(array $ajax): array
    {
        $errors = [];
        if (!isset($ajax['email']))
            $errors[] = 'Заполните почту';
        if (!isset($ajax['password']))
            $errors[] = 'Заполните пароль';
        if (!$this->checkEmail($ajax['email']))
            $errors[] = 'Неверный формат email';
        if (!$this->checkPassword($ajax['password']))
            $errors[] = "Пароль не должен быть короче 6-ти символов";
        return $errors;
    }

    private function checkEmail(string $email): bool
    {
        $email = $this->cleanRequest($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    private function cleanRequest($textrequest): string
    {
        $textrequest = trim($textrequest);
        // Фиксируем атаки
        if (preg_match("/script|http|<|>|<|>|SELECT|UNION|UPDATE|INSERT|exe|exec|tmp/i", $textrequest)) {
//         writelog('hack', date("y.m.d H:m:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$textrequest);
            $textrequest = '';
        }
        // Очищаем опасные запросы
        if (preg_match("/[=,:;\s]/", $textrequest)) {
            $textrequest = '';
        }
        return $textrequest;
    }

    private function checkPassword(string $password): bool
    {
        $password = $this->cleanRequest($password);
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }


    public function rules(): array
    {
        return [
            'post.email' => 'required',
//            'post.email' => 'required|email',
//            'post.password' => 'required|string|min:6',
        ];
    }
}