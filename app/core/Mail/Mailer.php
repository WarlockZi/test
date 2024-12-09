<?php

namespace app\core\Mail;

interface Mailer
{
    public function mail(array $to, string $subject, string $body, array $headers):bool;

}