<?php

namespace app\controller;

use app\controller\AdminscController;
use app\core\App;

class Adm_settingsController extends AdminscController {

   public function __construct($route) {
      parent::__construct($route);
   }

   public function actionIndex() {

      $this->auth();

      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }
   public function actionDumpSQL() {

      $this->auth();

      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }
   public function actionDump() {

      $this->auth();

      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }
   public function actionDumpWWW() {

      if($this->isAjax()){
         
      $a = 3;   
      }
      
      $this->auth();

      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }

   public function actionModule() {

      $this->auth();

      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
      $id = $this->route['id'];
      $module = App::$app->instructions->findOne($id)[0];
      $this->vars['module'] = $module;
   }

   public function actionInstructions() {

      $this->auth();
      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');

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


//      $this->vars['css'] = $this->getJSCSS('.css');
   }


   public function actionProps() {

      $this->auth();

      $this->layout = 'crm';
      $this->vars['js'] = $this->getJSCSS('.js');
      $this->vars['css'] = $this->getJSCSS('.css');

      $catProps = App::$app->catalog->findAll('props');
      foreach ($catProps as $k => $v) {
         $catProps[$k]['val'] = App::$app->catalog->findWhere($v['id'], 'parent', 'vals');
      };

      $this->vars['catProps'] = $catProps;
   }

}
