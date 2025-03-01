<?php


namespace app\view\Mail;


use app\core\FS;
use app\model\User;

class MailView
{
	public static function registration($user): string
    {
		$server = $_SERVER['HTTP_ORIGIN'];
		$confirmHref = "{$server}/auth/confirm/{$user['hash']}";
		$unsubscribeHref = "{$server}/auth/unsubscribe?email={$user['hash']}";
		return FS::getFileContent(__DIR__ . '/registration.php', compact('confirmHref', 'unsubscribeHref'));
	}

	public static function registrationAlt($user)
	{
		return "Подтверждение почты: <a href = '{$user['hash']}'>нажать сюда</a>";
	}

	public static function returnPass(User $user): string
	{
        $server = $_SERVER['HTTP_ORIGIN'];
        $confirmHref = "{$server}/auth/confirm/{$user['hash']}";
        $unsubscribeHref = "{$server}/auth/unsubscribe?email={$user['hash']}";
		return FS::getFileContent(__DIR__ . '/returnPass.php', compact('confirmHref', 'unsubscribeHref'));
	}

	public static function returnPassAlt($user)
	{
		return "Подтверждение почты: <a href = '{$user['hash']}'>нажать сюда</a>";
	}

}