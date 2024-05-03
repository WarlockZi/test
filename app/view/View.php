<?php

namespace app\view;

use app\controller\Controller;
use app\core\Auth;
use app\core\FS;
use app\core\Route;
use app\view\Assets\Assets;

abstract class View
{
    protected $controller;
    protected $fs;
    public $errors;
    public $user;
    public $header;
    public $content;
    public $footer;
    protected $view;
    public Assets $assets;

    function __construct(Route $route)
    {
        $this->fs         = new FS(__DIR__ . '/');
        $this->user       = Auth::getUser();
        $this->view       = ($route->getView() ?? 'index');
    }

    public function getContent()
    {
        return $this->content;
    }

    public function render()
    {
        $this->setContent($this->controller);
        echo $this->fs->getContent($this->layout, ['view' => $this]);
    }
}
