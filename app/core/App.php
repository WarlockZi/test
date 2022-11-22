<?php

namespace app\core;

class App {


  public static $app;
  public static $DI;

  public function __construct($di) {

  	self::$DI = $di;

//    self::$app = Registry::instance();

  }

}
