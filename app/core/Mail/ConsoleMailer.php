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

    protected function forgotPassEmail(array|string $to)
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
        $to   = is_string($to) ? $to : implode(',', $to);

        return [
            $path, $to ,'test','body text and other',
        ];
    }

    public function send(array $to, string $subject, string $body, string $type = 'text'): bool
    {
        list($path, $to, $subj, $body) = $this->forgotPassEmail($to);

        if ($_ENV['DEV']) {
            mail($to, $subj, $body);
        } else {
            try {
                if (exec("php -f $path $to $subj \"$body\"", $output)) {
                    return true;
                }
            } catch (Throwable $exception) {
                $exc = $exception;
            }
        }
        return false;
    }

}