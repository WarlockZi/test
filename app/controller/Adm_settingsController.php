<?php

namespace app\controller;

use app\core\App;
use app\core\Base\View;
use app\controller\AdminscController;

class Adm_settingsController extends AdminscController {

   public function __construct($route) {
      parent::__construct($route);

      $routeView = ['js' => $this->route, 'view' => $this->view];
      View::setJsCss($routeView);
      $routeView = ['css' => $this->route, 'view' => $this->view];
      View::setJsCss($routeView);
   }

   public function actionIndex() {

   }

   public function actionDumpSQL() {

   }

   public function actionPics() {

      $pics = App::$app->adminsc->findAll('pic');

      $this->set(compact('pics'));
   }

   public function actionDump() {

   }

   public function actionDumpWWW() {

      if ($this->isAjax()) {

         $a = 3;
      }
   }

   public function actionModule() {

      $id = $this->route['id'];
      $module = App::$app->instructions->findOne($id);
      $this->vars['module'] = $module;
   }

   public function actionInstructions() {

      $query = '';
      $parts = parse_url($_SERVER['REQUEST_URI']);
      if (isset($parts['query'])) {
         parse_str($parts['query'], $query);
      }

      if (!$query) {
         $roles = [
             'МОП' => '/adminsc/settings/instructions?mop',
             'СКЛ' => '/adminsc/settings/instructions?skl',
             'Вод' => '/adminsc/settings/instructions?vod',
             'БУХ' => '/adminsc/settings/instructions?buh'];
         $this->vars['roles'] = $roles;

         $modules = App::$app->instructions->getAllModuls();
         $this->vars['modules'] = $modules;
      } else {
         reset($query);
         $role = key($query);

         $doc = App::$app->instructions->getDoc($role)[0];
         $this->vars['doc'] = $doc;
      }
   }

   public function actionProps() {


      $catProps = App::$app->product->findAll('props');
      foreach ($catProps as $k => $v) {
         $catProps[$k]['val'] = explode(',', $catProps[$k]['val']);
      };

      $this->vars['catProps'] = $catProps;
   }

}
