<?php


namespace app\view\Footer;


use app\core\FS;
use app\view\Interfaces\IFooterable;

abstract class AbstractFooter implements IFooterable
{
	private static $cookie;
	private static $yaMetrica;
	private static $VK;

	protected $footer;


	public static function setVK(): void
	{
		self::$VK = FS::getFileContent(ROOT . '/app/view/components/footer/vk.php');
	}

	public static function getVK():string
	{
		return self::$VK;
	}

	public static function setYaMetrica(): void
	{
		self::$yaMetrica = FS::getFileContent(ROOT . '/app/view/components/footer/ya_metrica.php');
	}

	public static function getYaMetrica()
	{
		return self::$yaMetrica;
	}

	public static function setUserCookie(): void
	{
		self::$userCookie = FS::getFileContent(ROOT . '/app/view/components/footer/ya_metrica.php');
	}

	public static function getUserCookie()
	{
		return self::$userCookie;
	}

}