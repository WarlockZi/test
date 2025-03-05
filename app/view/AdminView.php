<?php


namespace app\view;


use app\controller\Controller;
use app\core\FS;


class AdminView extends View
{
    protected string $noViewError;
    protected string $defaultView;

    public function __construct(Controller $controller)
    {
        parent::__construct($controller);
//		new \app\view\Vite('main.js');

        $this->defaultView = "/default";
        $this->noViewError = "Файл вида не найден";
//        $this->setHeader($this->user);
//        $this->setFooter();
//        if ($this->controller->getRoute()->action === 'test') {
//            $this->setTestAssets();
//        } else {
//            $this->setAssets();
//        }
    }

    public function setContent(Controller $controller): void
    {
        $path          = __DIR__ . "/{$controller->getRoute()->controllerName}/Admin/";
        $fs            = new FS($path);
        $this->content = $fs->getContent($this->view, $controller->vars);
    }


}