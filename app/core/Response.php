<?php

namespace app\core;

class Response
{
    public function __construct(
        private int $status = 200,
        private string $view = 'index',
        $fs  = new FS(ROOT.'/app/view')
    )
    {
    }
//

    public static function json(array $arr = []): void
    {
        if ($arr) {
            header('Content-Type: application/json');
            exit(json_encode(['arr' => $arr]));
        }
    }

    public static function exitWithPopup(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['arr' => ['popup' => $msg]]));
        }
        exit();
    }
//    public function response(string|array $response, $status = 200)
//    {
//        http_response_code($status);
//        if (is_array($response)) {
//            self::json($response);
//        }
//        exit($response);
//    }
//
//    public function view(string $file, array $data = [], int $status=200): string
//    {
//        $layout = Auth::userIsAdmin() ? $this->layout : 'app\view\layouts\UserLayout';
//        $layout = new $layout($this->route, $this);
//        $layout->render();
//        exit();
//    }

}