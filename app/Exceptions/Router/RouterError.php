<?php


namespace app\Exceptions\Router;


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

    public static function getErrorHtml(): string
    {
        if (!count(self::$errors)) return '';

        $html = '';
        foreach (self::$errors as $error) {
            $html .= "<div class='message error'>{$error}</div>";
        }
        return "<div class='errors'>{$html}</div>";

    }


}