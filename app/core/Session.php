<?php


namespace app\core;


use app\model\User;

class Session
{

	private static $user;

  public static function getUser()
  {
    return self::$user;
  }

  public static function setUser(): void
  {
    if (isset($_SESSION['id'])) {
      self::$user = User::find($_SESSION['id'])->toArray();
    }
  }

}