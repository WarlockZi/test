<?php

namespace app\controller;

use app\controller\AppController;

class CrmController extends AdminscController{

   public function __construct($route) {
      parent::__construct($route);
   }

   public function actionIndex() {

      $this->auth();

      $this->vars['js'] = $this->getJSCSS('.js');
      $this->vars['css'] = $this->getJSCSS('.css');

   }

}

