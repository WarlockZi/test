<?php

namespace app\core\Mail;

use app\core\FS;
use app\Repository\MailConsoleRepository;
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

    public function send(string $function='', array $props=[]): bool
    {
        list($path, $to, $subj, $body, $headers) = MailConsoleRepository::$function($props);

        try {
            !DEV ? mail($to, $subj, $body) : exec("php -f $path $to $subj \"$body\" $headers", $output);
            return true;
        } catch (Throwable $exception) {
            $exc = $exception;
        }
        return false;
    }

}