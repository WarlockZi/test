<?php
declare(strict_types=1);

namespace app\Services;

use app\view\blade\View;
use JetBrains\PhpStorm\NoReturn;

class Response
{
    public function __construct(){}

    #[NoReturn] public static function json(array $arr = []): void
    {
        if ($arr) {
            header('Content-Type: application/json');
            exit(json_encode(['arr' => $arr]));
        }
        exit();
    }

    #[NoReturn] public static function exitWithPopup(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['arr' => ['popup' => $msg]]));
        }
        exit();
    }

    #[NoReturn] public static function view(string $file, array $data = [], int $status = 200): string
    {
        $view = APP->get(View::class);
        http_response_code($status);
        exit($view->render($file, $data));
    }
}