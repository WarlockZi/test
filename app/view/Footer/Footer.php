<?php


namespace app\view\Footer;


class Footer
{

	private static $adminFooter;
	private static $userFooter;
	private static $userCookie;
	private static $yaMetrica;
	private static $VK;

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

	public static function setUserFooter(): void
	{
		ob_start();
		include ROOT . '/app/view/components/footer/footer.php';
		self::$userFooter = ob_get_clean();
	}

	public static function getUserFooter()
	{
		return self::$userFooter;
	}


	public static function setAdminFooter()
	{
		ob_start();
		include ROOT . '/app/view/components/footer/footer.php';
		self::$adminFooter = ob_get_clean();
	}

	public static function getAdminFooter()
	{
		return self::$adminFooter;
	}

}