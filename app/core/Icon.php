<?php


namespace app\core;


use app\core\FS;

class Icon
{

	public static $commonPicPath = 'pic';
	public static $commonIconPath = 'icons';

	public static function __callStatic($name, $arguments):string
	{
		$arg = count($arguments)?
			$arguments[0].DIRECTORY_SEPARATOR:
			'';
		$ext = '.svg';
		$path = FS::getAbsolutePath(
			self::$commonPicPath,
			self::$commonIconPath,
			$arg
			);
		$file = FS::getAbsoluteFilePath($path,$name.$ext);
		if (!is_readable($file)) return '';

		ob_start();
		include $file;
		return ob_get_clean();
	}

}