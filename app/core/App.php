<?php

namespace app\core;

use app\core\Registry;

class App {

  public static $app;

  public function __construct() {
	//exit(__FILE__);
    self::$app = Registry::instance();

  }

}
