<?php


namespace app\view\Footer;


use app\core\FS;


class Footer
{
    private static $cookie;
    private static $yaMetrica;
    private static $VK;

    protected string $footer;


    public static function setVK(): void
    {
        self::$VK = FS::getFileContent(ROOT . '/app/view/components/footer/vk.php');
    }

    public static function getVK(): string
    {
        return self::$VK;
    }

    public static function setYaMetrica(): void
    {
        if (DEV) {
            self::$yaMetrica = FS::getFileContent(ROOT . '/app/view/components/footer/ya_metrica.php');
        }
    }

    public static function getYaMetrica(): string
    {
        if (DEV) {
            return self::$yaMetrica;
        }
        return '';
    }

//	public static function setUserCookie(): void
//	{
//		self::$userCookie = FS::getFileContent(ROOT . '/app/view/components/footer/ya_metrica.php');
//	}

    public static function getUserCookie()
    {
        return self::$userCookie;
    }

    public function getFooter(): string
    {
        return $this->footer;
    }

}