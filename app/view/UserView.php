<?php

namespace app\view;

use app\controller\Controller;
use app\service\FS;
use app\service\Logger\ErrorLogger;
use app\service\Router\Request;

class UserView extends View
{
    protected string $layout = "/layouts/vitex";
    protected static string $noViewError = ROOT . '/app/view/404/del_index.php';

    public function __construct(Request $route)
    {
        parent::__construct($route,new FS(new ErrorLogger('error.txt'), new ErrorLogger('error.txt')));
    }

    public function setContent(Controller $controller): void
    {
        $this->content = $this->fs->getContent(
            $controller->getRoute()->getControllerFullName() . '/' . $this->view,
            $controller->vars);
    }

}