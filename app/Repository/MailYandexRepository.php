<?php

namespace app\Repository;

use app\core\FS;

class MailYandexRepository
{
    public function __construct()
    {

    }


    public static function forgotPassword(array $props): array
    {
        return [
            1 => $props[0]->email,
            2 => 'VITEX|новый пароль',
            3 => 'Ваш новый пароль - ' . $props[1],
        ];

    }

    public static function registration(array $props): array
    {
        return [
            1 => $props[0]->email,
            2 => "VITEX|регистрация",
            3 => "Для завершения регистрации пройдите по ссылке <a href = {$props[0]->hash}>Подтвердить</a>",
        ];

    }

    protected function setHeaders(string $type): void
    {
        $additionalHeaders = '';
        if ($type = 'html') {
            $additionalHeaders = [
                'MIME-Version' => '1.0',
                'Content-type' => ' text/html; charset=UTF-8',
            ];
            $this->headers     = array_merge($this->headers, $additionalHeaders);
        }
    }

}