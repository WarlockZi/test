<?php
declare(strict_types=1);

namespace app\service;

class Session
{
    public function forget(string $key): void
    {
        $_SESSION[$key] = '';
    }


}

