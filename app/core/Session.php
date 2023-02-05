<?php


namespace app\core;


class Session
{
	private static $userId;

	public static function getUserId()
	{
		return self::$userId;
	}

	public static function setUserId()
	{
		if (isset($_SESSION['id'])) {
			self::$userId = $_SESSION['id'];
		}
	}

}