<?php

namespace app\controller;


use app\service\AuthService\Auth;
use app\service\Response;
use app\service\Router\Request;

class Controller
{
    protected array $ajax = [];

    function __construct()
    {
        $this->setAjaxRequest();
//        if (!$this->isAjax()) {
//            $this->assets = new Assets();
//        }
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

    public function setAjaxRequest(): void
    {
        if (empty($_POST['params'])) return;
        $req = json_decode($_POST['params'], true) ?? [];
        if (!Auth::validatePphSession($req)) Response::json(['error' => 'плохой ключ сессии']);
        if ($this->isAjax()) {
            unset($req['phpSession']);
            $this->ajax = $req;
        }
    }

    public function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

}
