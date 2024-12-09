<?php

$mailer = new ServerMailer();
$mailer->mail(['vvoronik@yandex.ru'], 'ddd','text');


class ServerMailer
{
    public function __construct()
    {

    }

    public function mail(array $to, string $subject, string $body, array $headers=[]): bool
    {
        $to = implode(',', $to);
        $headers = array(
            'From' => 'vitexopt@vitexopt.ru',
            'Reply-To' => 'vitexopt@vitexopt.ru',
            'X-Mailer' => 'PHP/' . phpversion()
        );
        $toSU = "vvoronik@yandex.ru";
        if (mail($to, "заголовок", "текст", $headers)) {
            return true;
        }
        return false;
    }
}

