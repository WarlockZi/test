<?php

namespace app\controller;


use app\core\Auth;
use app\core\Response;
use app\core\Route;
use app\core\Router;
use app\view\AdminView;
use app\view\Assets\Assets;
use app\view\UserView;
use app\view\View;

class Controller
{
    public $vars = [];
    public $view;

    protected $token;
    protected Route $route;
    protected $ajax;
    protected $auth;
    protected $assets;

    function __construct()
    {
        $this->getAjaxRequest();
        if (!$this->ajax) {
            $this->assets = new Assets();
            $this->token  = Auth::setToken();
        }
    }

//    public function getView()
//    {
//        if ($this->route->isAdmin()) {
//            return new AdminView($this);
//        } else {
//            return new UserView($this);
//        }
//    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    public function actionIndex()
    {
        $this->route->setView('default');
        $this->route->setNotFound();
        $this->route->setError('Путь не найден');
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function set($vars)
    {
        $this->vars = array_merge($this->vars, $vars);
    }

    public function getAssets(): Assets
    {
        return $this->assets;
    }

    public function getAjaxRequest(): void
    {
        if (isset($_POST['param'])) {

            $req = json_decode($_POST['param'], true);

            if (Auth::validateToken($req)) Response::exitWithError('плохой tocken');

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                unset($req['token']);
                $this->ajax = $req;
            }
        }
    }

}
