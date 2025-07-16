<?php


namespace app\view\components\Footer;


use app\service\Fs\FS;


class Footer
{
    private static string $yaMetrica;
    private static string $VK;

    protected $footer;


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

    public static function getUserCookie()
    {
        return self::$userCookie;
    }

    public function footer(): string
    {
        return $this->footer;
    }

}