<?php

namespace app\view;

use app\controller\Controller;
use app\model\User;
use app\Services\AssetsService\Assets;
use app\Services\AuthService\Auth;
use app\Services\FS;
use app\Services\Router\Route;
use app\view\blade\IView;

abstract class View implements IView
{
    protected Controller $controller;
    protected FS $fs;
    public User|null $user;
    public string $header;
    public string $content;
    public string $footer;
    protected string $view;
    public Assets $assets;

    function __construct(Route $route, FS $fs)
    {
        $this->fs   = $fs;
        $this->user = Auth::getUser();
        $this->view = $route->getView() ?? 'index';
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function render(string $template, array $data = []):void
    {
        $this->setContent($this->controller);
        echo $this->fs->getContent($this->layout, ['view' => $this]);
    }

}
