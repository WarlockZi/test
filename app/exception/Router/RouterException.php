<?php


namespace app\exception\Router;


use app\blade\View;

class RouterException
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

    public static function badController(string $controller): void
    {
        if (!headers_sent()) {
            $blade = APP->get(View::class)->render('exceptions.router.pageNotFound',
                ['userMessage'=>'Страница не найдена',
                    'source'=>'контроллер: '.$controller]);
            response($blade, 404)->send();
        }
    }

    public static function badAction(string $action)
    {
        if (!headers_sent()) {
            $blade = APP->get(View::class)->render('exceptions.router.pageNotFound',
                ['userMessage'=>'Страница не найдена',
                    'source'=>'актион: '.$action]);
            response($blade, 404)->send();
        }
    }

}