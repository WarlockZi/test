<?php

namespace app\core;

use app\core\Registry;
use app\model\User;

class App {


  public static $app;

  public function __construct() {

    self::$app = Registry::instance();

  }

}
