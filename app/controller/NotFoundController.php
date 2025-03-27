<?php


namespace app\controller;

use app\Exceptions\Router\RouterError;
use app\model\User;
use app\Services\Router\Route;
use app\view\AdminView;
use app\view\Assets\UserAssets;
use app\view\UserView;
use JetBrains\PhpStorm\NoReturn;

class NotFoundController extends Controller
{
    protected string $file404;
    public string $view;

    public function __construct()
    {
        parent::__construct();
        $this->assets = new UserAssets();
        $this->assets->setMeta('Страница не найдена', 'Страница не найдена');
        $this->file404 = ROOT . '/app/view/404/404.php';
    }

    #[NoReturn] public function controller(Route $route): void
    {
        $error = "Не найден controller - {$route->getController()}";
        http_response_code(404);
        RouterError::setError($error);
        $view = $this->setView();
        $view->render();
        exit();
    }

    #[NoReturn] public function action(Route $route): void
    {
        $error = "Плохой action - {$route->getAction()} у контроллера - {$route->getController()}";
        http_response_code(404);
        Error::setError($error);
        $view = $this->setView();
        $view->render();
        exit();
    }

    public function setView(): UserView|AdminView
    {
        if (User::can(Auth::getUser(), ['role_employee'])) {
            return new AdminView(new self);
        } else {
            return new UserView(new self);
        }
    }

}