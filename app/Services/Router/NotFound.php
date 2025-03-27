<?php


namespace app\Services\Router;

use app\controller\Controller;
use app\Exceptions\Router\RouterError;
use app\Services\AssetsService\UserAssets;
use app\Services\FS;
use app\view\AdminView;
use app\view\UserView;
use JetBrains\PhpStorm\NoReturn;

class NotFound extends Controller
{
    protected string $file404;

    public function __construct()
    {
        parent::__construct();
        $this->assets = new UserAssets();
        $this->assets->setMeta('Страница не найдена', 'Страница не найдена');
        $this->file404 = ROOT . '/app/view/404/404.php';
    }

    #[NoReturn] public static function url(string $url): void
    {
        $error = "Плохой запрос url - {$url}";
        RouterError::setError($error);

        $view        = self::setView();
        $view->route = ['controller' => 'AppController', 'action' => 'index'];
        $view->render();
        exit();
    }

    protected static function setView(Route $route): UserView|AdminView
    {
        if ($user->can(['role_employee']) && $route->isAdmin) {
            return new AdminView(new self);
        } else {
            return new UserView(new self);
        }
    }

    #[NoReturn] public static function action(Route $route): void
    {
        $error = "Плохой action - {$route->action} у контроллера - {$route->controller::shortClassName($route->controller)}";
        http_response_code(404);
        RouterError::setError($error);
        $view = self::setView($route);
        $view->render();
        exit();
    }

    public static function NotFound(string $slug): string
    {
        http_response_code(404);
        $path = ROOT . '/app/view/404';
        $fs   = (new FS($path));
        return $fs->getContent('index');
    }

}