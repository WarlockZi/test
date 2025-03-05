<?php

namespace app\Services;

class DotEnv
{
    public static function load(string $path): void
    {
        $lines = file($path);
        foreach ($lines as $line) {
            if (empty(trim($line))) continue;
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }

}