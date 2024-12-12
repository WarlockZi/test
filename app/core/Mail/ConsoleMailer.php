<?php

namespace app\core\Mail;

use app\core\FS;
use Throwable;

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

    protected function forgotPassword(array|string $to, string $type = 'text'): array
    {
        $path    = ROOT . FS::platformSlashes("/app/core/Mail/consoleMail.php");
        $to      = is_string($to) ? $to : implode(',', $to);
        $subject = 'test';
        $body    = 'body text and other';
        $this->setHeaders($type);
        return [
            $path, $to, $subject, $body, $this->headers
        ];
    }

    public function send(array|string $to, string $subject, string $body, string $type = 'text'): bool
    {
        list($path, $to, $subj, $body, $headers) = $this->forgotPassword($to);

        try {
            $_ENV['DEV'] ? mail($to, $subj, $body) : exec("php -f $path $to $subj \"$body\" $headers", $output);
            return true;
        } catch (Throwable $exception) {
            $exc = $exception;
        }
        return false;
    }

}