<?php

namespace app\controller;


use app\service\AssetsService\Assets;
use app\service\AuthService\Auth;
use app\service\Response;
use app\service\Router\Request;
use app\view\blade\IView;
use JetBrains\PhpStorm\NoReturn;

class Controller
{
    public array $vars = [];
    public string $view = 'index';
    protected Request $route;
    protected array $ajax = [];
    public Assets $assets;
    public IView $viewService;

    function __construct()
    {
        $this->viewService = APP->get('bladeView');
        $this->setAjaxRequest();
        if (!$this->isAjax()) {
            $this->assets = new Assets();
        }
    }
    #[NoReturn] protected function render(string $view, array $params = []):void
    {
        exit($this->viewService->render($view, $params));
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
