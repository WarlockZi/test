<?php

namespace app\core\Mail;

interface Mailer
{
    public function send(string $function, array $props=[]):bool;

}