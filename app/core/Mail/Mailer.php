<?php

namespace app\core\Mail;

interface Mailer
{
    public function send(array $to, string $subject, string $body, string $type='text'):bool;

}