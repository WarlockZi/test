<?php


namespace app\view\Footer;


use app\view\Interfaces\IFooterable;

abstract class AbstractFooter implements IFooterable
{
	private static $cookie;
	private static $yaMetrica;
	private static $VK;

	protected $footer;


	public static function setVK(): void
	{
		ob_start();
		include ROOT . '/app/view/components/footer/vk.php';
		self::$VK = ob_get_clean();
	}

	public static function getVK():string
	{
		return self::$VK;
	}

	public static function setYaMetrica(): void
	{
		ob_start();
		include ROOT . '/app/view/components/footer/ya_metrica.php';
		self::$yaMetrica = ob_get_clean();
	}

	public static function getYaMetrica()
	{
		return self::$yaMetrica;
	}

	public static function setUserCookie(): void
	{
		ob_start();
		include ROOT . '/app/view/components/footer/ya_metrica.php';
		self::$userCookie = ob_get_clean();
	}

	public static function getUserCookie()
	{
		return self::$userCookie;
	}

}