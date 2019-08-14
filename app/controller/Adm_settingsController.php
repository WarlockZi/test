<?php

namespace app\controller;

use app\controller\AdminscController;
use app\core\App;

class Adm_settingsController extends AdminscController {

   public function __construct($route) {
      parent::__construct($route);
   }

   public function actionIndex() {

      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }
   public function actionDumpSQL() {

      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }
//   public function actionGame() {
//   }

   public function actionPics() {

      $this->vars['js'] = $this->getJSCSS('.js');

      $pics = App::$app->adminsc->findAll('pic');

      $this->set(compact('pics', 'js'));

   }
   public function actionDump() {

      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }
   public function actionDumpWWW() {

      if($this->isAjax()){

      $a = 3;
      }

      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }

   public function actionModule() {

      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
      $id = $this->route['id'];
      $module = App::$app->instructions->findOne($id)[0];
      $this->vars['module'] = $module;
   }

   public function actionInstructions() {

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
//      $this->layout = 'admin.php';

      $this->vars['js'] = $this->getJSCSS('.js');
      $this->vars['css'] = $this->getJSCSS('.css');

      $catProps = App::$app->catalog->findAll('props');
      foreach ($catProps as $k => $v) {
//         $catProps[$k]['val'] = App::$app->catalog->findWhere($v['id'], 'parent', 'props');
         $catProps[$k]['val'] = explode(',', $catProps[$k]['val']);
      };

      $this->vars['catProps'] = $catProps;
   }

}
