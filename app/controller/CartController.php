<?php

namespace app\controller;

use \app\view\View;

class CartController extends Controller{

   public function __construct($route) {
      parent::__construct($route);
   }

   public function actionIndex() {


       $this->layout = 'vitex';
       View::setCss('main.css');
       View::setJs('main.js');

//      $this->autorize();

   }

}

