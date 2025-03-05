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
            $value = self::convert($value);

            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }

    private static function convert(string $string):mixed
    {
        if (strtolower($string) === 'false'){
            return false;
        }elseif (strtolower($string) === 'true'){
            return true;
        }elseif (is_numeric($string)){
            return (int)$string;
        }
        return trim($string, '"\'');
    }

}