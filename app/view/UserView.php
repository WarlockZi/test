<?php

namespace app\view;

use app\controller\Controller;
use app\Services\FS;
use app\Services\Logger\ErrorLogger;
use app\Services\Router\Route;

class UserView extends View
{
    protected string $layout = "/layouts/vitex";
    protected static string $noViewError = ROOT . '/app/view/404/del_index.php';

    public function __construct(Route $route)
    {
        parent::__construct($route,new FS(__DIR__ . '/', new ErrorLogger('error.txt')));
    }

    public function setContent(Controller $controller): void
    {
        $this->content = $this->fs->getContent(
            $controller->getRoute()->getControllerFullName() . '/' . $this->view,
            $controller->vars);
    }

}