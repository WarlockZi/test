<?php


namespace app\controller;


class FS
{

	public static function delFilesFromPath(string $path, string $ext=''):array
	{
		$ext = $ext??'*';
		$files = glob(ROOT .$path. "*.$ext");
		$deleted = array();
		foreach ($files as $file) {
				array_push($deleted, $file);
				unlink($file);
		}
		return $deleted;
	}

	function platformSlashes($path) {
		$str  = str_replace('\\',DIRECTORY_SEPARATOR, $path);
		return str_replace('/', DIRECTORY_SEPARATOR, $str);
	}


}