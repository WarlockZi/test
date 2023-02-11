<?php


namespace app\controller;


use app\model\Image;

class FS
{

	public static function delFilesFromPath(string $path, string $ext = ''): array
	{
		$ext = $ext ?? '*';
		$files = glob(ROOT . $path . "*.$ext");
		$deleted = array();
		foreach ($files as $file) {
			array_push($deleted, $file);
			unlink($file);
		}
		return $deleted;
	}

//	protected function getPaths($absolutePath)
//	{
//		$paths = [];
//		foreach (scandir("{$absolutePath}/") as $path) {
//			if ($path !== '.' && $path !== '..') {
//				$paths[$path]['basename'] = $path;
//				$paths[$path]['fullpath'] = "{$absolutePath}/{$path}";
//			}
//		}
//		return $paths;
//	}
	public static function getPath(...$args)
	{
		$s = DIRECTORY_SEPARATOR;
		$str = ROOT . $s;
		foreach ($args as $arg) {
			$str .= $arg . $s;
		}
		return self::platformSlashes($str);
	}

	public static function platformSlashes($path)
	{
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}

	public static function getAbsoluteImagePath($path, Image $image)
	{
		$s = DIRECTORY_SEPARATOR;
		return $path . $image->hash . '.' . $image->type;
	}

	public static function getAbsoluteFilePath($path, string $file)
	{
		$s = DIRECTORY_SEPARATOR;
		$path = FS::platformSlashes($path);
		return $path  . $file;
	}

	public static function getOrCreateAbsolutePath(...$args)
	{
		$s = DIRECTORY_SEPARATOR;
		$dir = ROOT;
		foreach ($args as $arg) {
			$dir .= $s . $arg;
			if (!is_dir($dir)) {
				$res = mkdir($dir, 0777);
			}
		}
		return $dir;
	}

	public static function parsePathToString(string $fullPath)
	{
		$s = DIRECTORY_SEPARATOR;
		$str = '';
		$arr = explode('/', $fullPath);
		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i]) {
				if ($arr[$i + 1]) {
					$str .= $arr[$i] . $s;
				} else {
					$str .= $arr[$i];
				}
			}
		}
		return $str;
	}

	public static function getAbsolutePath(...$args)
	{
		$s = DIRECTORY_SEPARATOR;
		$dir = ROOT;
		foreach ($args as $arg) {
			if (str_contains($arg, '/')) {
				$arg = self::parsePathToString($arg);
			}
			$dir .= $s . $arg;
			if (!is_dir($dir)) {
				$res = mkdir($dir, 0777);
			}
		}
		return $dir;
	}



//	function platformSlashes($path)
//	{
//		$str = str_replace('\\', DIRECTORY_SEPARATOR, $path);
//		return str_replace('/', DIRECTORY_SEPARATOR, $str);
//	}


}