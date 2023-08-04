<?php


namespace app\view\Mail;


use app\core\FS;

class MailView
{
	public static function registration($user)
	{
		$hash = $user['hash'];
		$server = $_SERVER['HTTP_ORIGIN'];

		$confirmHref = "{$server}/auth/confirm/{$hash}";
		$unsubscribeHref = "{$server}/auth/unsubscribe?email={$hash}";
		return FS::getFileContent(__DIR__ . '/registration.php', compact('confirmHref', 'unsubscribeHref'));
	}

	public static function registrationAlt($user)
	{
		return "Подтверждение почты: <a href = '{$user['hash']}'>нажать сюда</a>";
	}

	public static function returnPass($user)
	{
		$pass = $user['hash'];

		return FS::getFileContent(__DIR__ . '/registration.php', compact('confirmHref', 'unsubscribeHref'));
	}

	public static function returnPassAlt($user)
	{
		return "Подтверждение почты: <a href = '{$user['hash']}'>нажать сюда</a>";
	}

}