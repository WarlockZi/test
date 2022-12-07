<?php


namespace app\controller;


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

	public static function getPath(...$args)
	{
		$s = DIRECTORY_SEPARATOR;
		$str = ROOT . $s;
		foreach ($args as $arg) {
			$str .= $arg . $s;
		}
		return $str;
	}
	public static function getAbsolutePath(...$args)
	{
		$s = DIRECTORY_SEPARATOR;
		$dir = ROOT ;
		foreach ($args as $arg) {
			$dir .= $s.$arg ;
		}
		return $dir;
	}
	public static function getAbsoluteFilePath($path, $image)
	{
		$s = DIRECTORY_SEPARATOR;
		return $path.$s.$image->hash.'.'.$image->type;
	}
	public static function getOrCreateAbsolutePath(...$args)
	{
		$s = DIRECTORY_SEPARATOR;
		$dir = ROOT ;
		foreach ($args as $arg) {
			$dir .= $s.$arg ;
			if (!is_dir($dir)){
				$res = mkdir($dir,0777);
			}
		}
		return $dir;
	}



	function platformSlashes($path)
	{
		$str = str_replace('\\', DIRECTORY_SEPARATOR, $path);
		return str_replace('/', DIRECTORY_SEPARATOR, $str);
	}


}