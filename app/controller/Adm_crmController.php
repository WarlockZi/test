<?php

namespace app\controller;

use app\core\App;
use app\view\View;
use app\controller\AdminscController;

class Adm_crmController extends AdminscController {

   public function __construct($route) {
      parent::__construct($route);

   }

   public function actionIndex() {

   }

   public function actionUsers() {

      $users = App::$app->user->findAll('users');
      $rights = App::$app->user->findAll('user_rights');
      $this->set(compact('users', 'rights'));
   }

   public function actionUser() {

      if (!isset($_GET['id']) || !$id = $_GET['id']) {
         header('Location: /adminsc/crm/users');
      };

      $user = App::$app->user->getUser($id);
      $rights = App::$app->user->getRights();

      $this->set(compact('user','rights'));
   }

}
