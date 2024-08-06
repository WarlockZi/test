<?php

namespace app\controller;


use app\core\Auth;
use app\core\Response;
use app\core\Route;
use app\view\Assets\Assets;

class Controller
{
   public array $vars = [];
   public string $view;

   protected string $token;
   protected Route $route;
   protected array $ajax = [];
   protected Assets $assets;

   function __construct()
   {
      $this->setAjaxRequest();
      if (!$this->ajax) {
         $this->assets = new Assets();
         $this->token = Auth::setToken();
      }
   }

   public function setRoute(Route $route): void
   {
      $this->route = $route;
   }

   public function actionIndex():void
   {
      $this->route->setView('default');
      $this->route->setNotFound();
      $this->route->setError('Путь не найден');
   }

   public function getRoute(): Route
   {
      return $this->route;
   }

   public function set($vars): void
   {
      $this->vars = array_merge($this->vars, $vars);
   }

   public function getAssets(): Assets
   {
      return $this->assets;
   }

   public function setAjaxRequest(): void
   {
      if (isset($_POST['param'])) {
         $req = json_decode($_POST['param'], true);
         if (Auth::validateToken($req)) Response::exitWithError('плохой tocken');
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            unset($req['token']);
            $this->ajax = $req;
         }
      } else {
         $this->ajax = [];
      }
   }
   public function isAjax():bool
   {
      return !!$this->ajax;

   }

}
