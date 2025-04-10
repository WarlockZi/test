<?php
declare(strict_types=1);

namespace app\Services;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    public function __construct(
//        private int    $status = 200,
//        private string $view = 'index',
//        private FS     $fs = new FS(ROOT . '/app/view')
    )
    {
    }

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
        try {
            $blade = APP->get('Blade');
            exit($blade->run($file, $data));
        } catch (\Throwable $exception) {
            $exception = $exception->getMessage();
        }
        return '';
//        $layout = Auth::userIsAdmin() ? $this->layout : 'app\view\layouts\UserLayout';
//        $layout = new $layout($this->route, $this);
//        $layout->render();
//        exit();
    }
}