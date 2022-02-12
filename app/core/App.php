<?php

namespace app\core;

use app\core\Registry;
use app\model\User;

class App {

  public $ap;
  public static $app;

  public function __construct() {
	//exit(__FILE__);
//	  self::$app->bind();

	  $this->ap->bind('User', function (){
	  	return new User();
	  });

    self::$app = Registry::instance();

  }

}
