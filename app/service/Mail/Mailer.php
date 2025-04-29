<?php

namespace app\service\Mail;

interface Mailer
{
    public function send(string $function, array $props = []): bool;

}