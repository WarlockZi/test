<?php

namespace app\core;

class App {


  public static $app;

  public function __construct() {

    self::$app = Registry::instance();

  }

}
