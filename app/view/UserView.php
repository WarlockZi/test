<?php

namespace app\view;

use app\controller\Controller;
use app\core\Route;

class UserView extends View
{
    protected string $layout = "/layouts/vitex";
    protected static string $noViewError = ROOT . '/app/view/404/index.php';

    public function __construct(Route $route)
    {
        parent::__construct($route);
    }

    public function setContent(Controller $controller): void
    {
        $this->content = $this->fs->getContent(
            $controller->getRoute()->getControllerFullName() . '/' . $this->view,
            $controller->vars);
    }

}