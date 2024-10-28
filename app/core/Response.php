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

    public function view(string $file, array $data = [], int $status=200): string
    {
        $layout = Auth::userIsAdmin() ? $this->layout : 'app\view\layouts\UserLayout';
        $layout = new $layout($this->route, $this);
        $layout->render();
        exit();
    }

    public static function exitJson(array $arr = []): void
    {
        if ($arr) {
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

    public static function exitWithMsg(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['msg' => $msg]));
        }
        exit();
    }

    public static function exitWithSuccess(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['success' => $msg]));
        }
        exit();
    }

    public static function exitWithError(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['error' => $msg]));
        }
        exit();
    }
    //    public static function notFound(string $file = '', array $data = [], int $status=200): string
//    {
////        $this->assets->setMeta('Страница не найдена');
////            http_response_code(404);
////        $layout = Auth::userIsAdmin() ? $this->layout : 'app\view\layouts\UserLayout';
//        $layout = new $layout($this->route, $this);
//        $layout->render();
//        exit();
//    }

}