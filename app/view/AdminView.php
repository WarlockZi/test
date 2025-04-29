<?php


namespace app\view;


use app\controller\Controller;
use app\service\FS;


class AdminView extends View
{
    protected string $noViewError;
    protected string $defaultView;

    public function __construct(Controller $controller)
    {
        parent::__construct($controller);
        $this->defaultView = "/default";
        $this->noViewError = "Файл вида не найден";

    }

    public function setContent(Controller $controller): void
    {
        $path          = __DIR__ . "/{$controller->getRoute()->controllerName}/Admin/";
        $fs            = new FS();
        $this->content = $fs->getContent($this->view, $controller->vars);
    }


}