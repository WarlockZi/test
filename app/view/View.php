<?php

namespace app\view;

use app\controller\Controller;
use app\core\Auth;
use app\core\FS;
use app\core\Route;
use app\model\User;
use app\view\Assets\Assets;

abstract class View
{
    protected Controller $controller;
    protected FS $fs;
    public User|null $user;
    public string $header;
    public string $content;
    public string $footer;
    protected string $view;
    public Assets $assets;

    function __construct(Route $route)
    {
        $this->fs         = new FS(__DIR__ . '/');
        $this->user       = Auth::getUser();
        $this->view       = ($route->getView() ?? 'index');
    }

    public function getContent():string
    {
        return $this->content;
    }

    public function render():void
    {
        $this->setContent($this->controller);
        echo $this->fs->getContent($this->layout, ['view' => $this]);
    }
}
