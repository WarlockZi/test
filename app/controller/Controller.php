<?php

namespace app\controller;


use app\service\AuthService\Auth;
use app\service\Router\Request;

class Controller
{
    protected array $ajax = [];

    function __construct()
    {
    }
    public function __destruct()
    {
    }

    public function getRoute(): Request
    {
        return $this->route;
    }

    public function setVars($vars): void
    {
        $this->vars = array_merge($this->vars, $vars);
    }
}
