<?php

namespace app\Services\Mail;

interface Mailer
{
    public function send(string $function, array $props = []): bool;

}