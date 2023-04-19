<?php

namespace app\controller;

use app\Repository\OrderRepository;
use \app\view\View;

class CartController extends AppController {

   public function __construct() {
      parent::__construct();
   }

   public function actionIndex() {

		 $oItems = OrderRepository::main();
		 $this->set(compact('oItems'));


   }

}

