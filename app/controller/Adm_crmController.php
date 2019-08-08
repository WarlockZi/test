<?php

namespace app\controller;

use app\controller\AdminscController;
use app\core\App;

class Adm_crmController extends AdminscController{

   public function __construct($route) {
      parent::__construct($route);
   }

   public function actionIndex() {

      $this->vars['js'] = $this->getJSCSS('.js');
//      $this->vars['css'] = $this->getJSCSS('.css');
   }

      public function actionUsers() {


      $users = App::$app->user->findAll('users');

      foreach ($users as $key => $value) {
         $userId = $value['id'];
         $user_rights_set = App::$app->user->getUserRightsSet($userId);
         foreach ($user_rights_set as $k) {

            $users[$key]['rights_set'][$k['id']] = $k['name'];
         }
      }

      $rights = App::$app->user->findAll('user_rights');

      $this->set(compact('users', 'rights'));
   }

      public function actionUser() {


      $users = App::$app->user->findAll('users');

      foreach ($users as $key => $value) {
         $userId = $value['id'];
         $user_rights_set = App::$app->user->getUserRightsSet($userId);
         foreach ($user_rights_set as $k) {

            $users[$key]['rights_set'][] = $k['name'];
         }
      }

      $rights = App::$app->user->findAll('user_rights');

      $this->set(compact('users', 'rights'));
   }


}

