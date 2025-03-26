<?php

namespace app\view;

use app\controller\Controller;
use app\model\User;
use app\Services\AssetsService\Assets;
use app\Services\AuthService\Auth;
use app\Services\FS;
use app\Services\Router\Route;

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
        $this->fs   = new FS(__DIR__ . '/');
        $this->user = Auth::getUser();
        $this->view = $route->getView() ?? 'index';
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function render(): void
    {
        $this->setContent($this->controller);
        echo $this->fs->getContent($this->layout, ['view' => $this]);
    }
    public function noPermition(): string
    {
        $data = $this->controller->vars;
        return $this->show(view:'notFound',  data:$data);
    }

    private static function show(string $layout = 'vitex', string $view='index', array $data=[])
    {
        $fs = new FS(__DIR__ . '/');
        echo $fs->getContent($layout, $data);
    }
}
