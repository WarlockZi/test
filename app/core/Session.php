<?php


namespace app\core;


use app\model\User;

class Session
{

	private static $user;
	private static $id;

  public static function getUser()
  {
		$id = self::getId();
		if ($id) {
			return User::find($id)->toArray();
		}
  }

  public static function setUser(array  $user): void
  {
  	$id = self::getId();
    if ($id) {
      self::$user = User::find($id);
    }

  }
  public static function setId(int $id){
		$_SESSION['id'] = $id;
	}
	public static function getId(){
		if (isset($_SESSION['id'])&&$_SESSION['id']) {
			return $_SESSION['id'];
		}
	}

}