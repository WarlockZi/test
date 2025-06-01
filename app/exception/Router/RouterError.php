<?php


namespace app\exception\Router;


class RouterError
{
    protected static $errors = [];

    public static function setError($error): void
    {
        self::$errors[] = $error;
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }



}