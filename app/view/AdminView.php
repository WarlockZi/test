<?php


namespace app\view;


use app\controller\Controller;
use app\core\Auth;
use app\core\FS;
use app\model\User;
use app\view\Assets\AdminAssets;
use app\view\Assets\TestAssets;
use app\view\Header\Admin\AdminHeader;
use function app\view\helpers\vite;


class AdminView extends View
{
    protected $noViewError;
    protected $defaultView;

    public function __construct(Controller $controller)
    {
        parent::__construct($controller);
//		new \app\view\Vite('main.js');

        $this->defaultView = "/default";
        $this->noViewError = "Файл вида не найден";
        $this->setHeader($this->user);
        $this->setFooter();
        if ($this->controller->getRoute()->action === 'test') {
            $this->setTestAssets();
        } else {
            $this->setAssets();
        }
    }

    public function setContent(Controller $controller): void
    {
        $path          = __DIR__ . "/{$controller->getRoute()->controllerName}/Admin/";
        $fs            = new FS($path);
        $this->content = $fs->getContent($this->view, $controller->vars);
    }


}