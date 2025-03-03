<?php


namespace app\core;

use app\controller\Controller;
use app\Services\AssetsService\UserAssets;
use app\view\AdminView;
use app\view\UserView;

class NotFound extends Controller
{
    protected $file404;

    public function __construct()
    {
        parent::__construct();
        $this->assets = new UserAssets();
        $this->assets->setMeta('Страница не найдена', 'Страница не найдена');
        $this->file404 = ROOT . '/app/view/404/del_index.php';
    }

    public static function url(string $url)
    {
        $error = "Плохой запрос url - {$url}";
        Error::setError($error);

        $view        = self::setView();
        $view->route = ['controller' => 'AppController', 'action' => 'index'];
        $view->render();
        exit();
    }

//    public static function controller(Route $route)
//    {
//        $error = "Не найден controller - {$route->controller}";
//        Error::setError($error);
//
//        http_response_code(404);
//        $view = self::setView($route);
//
//        $content = $view->get404();
//        $view->setContent($view->controller);
//        $view->render();
//        exit();
//    }

    public static function action(Route $route)
    {
        $error = "Плохой action - {$route->action} у контроллера - {$route->controller::shortClassName($route->controller)}";
        http_response_code(404);
        Error::setError($error);
        $view = self::setView($route);
        $view->render();
        exit();
    }

    protected static function setView(Route $route)
    {
        if ($user->can(['role_employee']) && $route->admin) {
            return new AdminView(new self);
        } else {
            return new UserView(new self);
        }
    }

    public static function NotFound(string $slug)
    {
        http_response_code(404);
        $file = 'del_index.php';
        $path = ROOT . '/app/view/404';
        $fs = (new FS($path));
        $view = $fs->getContent('index');
        return $view;
//        Error::setError('Страница не найдена');
//        $this->view = '404';
        $product = null;

    }

}