<?php

namespace app\controller;


use app\core\Auth;
use app\core\Response;
use app\core\Route;
use app\view\Assets\Assets;

class Controller
{
    public array $vars = [];
    public string $view='index';
    protected Route $route;
    protected array $ajax = [];
    public Assets $assets;

    function __construct()
    {
        $this->setAjaxRequest();
        if (!$this->isAjax()) {
            $this->assets = new Assets();
        }
    }

    public function setRoute(Route $route): void
    {
        $this->route = $route;
        $this->view = $route->getView();
    }

    public function actionIndex():void
    {
        $this->view  = '404';
        $this->route->setError('Путь не найден');
        $errors = $this->route->getErrors();
        $this->setVars(compact('errors'));
    }
    public function actionNotFound():void
    {
        $this->view  = '404';
        $this->route->setError('Путь не найден');
        $errors = $this->route->getErrors();
        $this->setVars(compact('errors'));
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function setVars($vars): void
    {
        $this->vars = array_merge($this->vars, $vars);
    }

    public function setAjaxRequest(): void
    {
        if (!empty($_POST['params'])) {
            $req = json_decode($_POST['params'], true);
            if (!Auth::hasPphSession($req)) Response::exitWithError('плохой ключ сессии');
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                unset($req['phpSession']);
                $this->ajax = $req;
            }
        }
    }

    public function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

}
