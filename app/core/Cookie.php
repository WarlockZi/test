<?php


namespace app\core;


class Cookie
{
	private $cookie;

	public function __construct()
	{
	}

	public static function getTime($timeDigit, $timeUnit)
	{
		$expire = -1;
		if ($timeUnit === 's') {
			$expire = $timeDigit;
		} elseif ($timeUnit === 'm') {
			$expire = $timeDigit * 60;
		} elseif ($timeUnit === 'h') {
			$expire = $timeDigit * 60 * 60;
		} elseif ($timeUnit === 'd') {
			$expire = $timeDigit * 60 * 60 * 24;
		}
		return $expire;
	}

	public static function set($key, $value, $timeDigit, $timeUnit)
	{
		$expire = time()+self::getTime($timeDigit, $timeUnit);
		setcookie($key, (string)$value, $expire, '/');
	}

	public static function get($key)
	{
		if (isset($_COOKIE[$key])) {
			return $_COOKIE[$key];
		}
	}

	public static function remove($key)
	{
		if (isset($_COOKIE[$key])) {
			unset($_COOKIE[$key]);
		}
	}
}