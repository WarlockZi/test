<?php
declare(strict_types=1);

namespace app\service;

class Session
{
    public function nullify(string $key): void
    {
        $_SESSION[$key] = null;
    }
    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }
    public function get(string $key, $defaultValue)
    {
        return $_SESSION[$key] ?? $defaultValue;
    }

    public function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    public function clear(): void
    {
        $_SESSION = [];
    }


}

