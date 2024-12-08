<?php

namespace app\core\Mail;

use app\core\FS;

class ConsoleMailer implements Mailer
{
    protected string $to;
    protected array $headers = [
        'From' => 'vitexopt@vitexopt.ru',
        'Reply-To' => 'vitexopt@vitexopt.ru',
    ];

    public function __construct()
    {

    }

    public function send(array $to, string $subject, string $body, string $type = 'text'): bool
    {
        if ($type = 'html') {
            $additionalHeaders = [
                'MIME-Version' => '1.0',
                'Content-type' => 'text/html; charset=UTF-8',
            ];
            $this->headers     = array_merge($this->headers, $additionalHeaders);
        }
        $path = ROOT . FS::platformSlashes("/app/core/Mail/consoleMail.php");
        $d    = $this->headers;
        exec("php $path",$output);
//        $res = mail('vvoronik@yandex.ru', 'subj', 'mess');
    }
}