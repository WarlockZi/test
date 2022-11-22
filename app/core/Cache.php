<?

namespace app\core;

class Cache
{
//
//	public function getFromCache($folderName, $file_name)
//	{
//		$fileName = "{$file_name}";
//		// открываем текущую папку
//		$dir = opendir($folderName);
//		// перебираем папку
//		while (($file = readdir($dir)) !== false){ // перебираем пока есть файлы
//			if($file != "." && $file != ".."){ // если это не папка
//				if(is_file($folderName."/".$file)){ // если файл проверяем имя
//					// если имя файла нужное, то вернем путь до него
//					if($file == $fileName) return $folderName."/".$file ;
//				}
//				// если папка, то рекурсивно вызываем search_file
//				if(is_dir($folderName."/".$file)) return $this->getFromCache($folderName."/".$file, $fileName);
//			}
//		}
//		// закрываем папку
//		$res = "{$folderName}\\{$fileName}.txt" ;
//		closedir($dir);
//		return $res;
//
//	}


	public static function get($key, $path = '')
	{
		$file = ROOT . '/tmp/cache/' . $path . md5($key) . '.txt';
		if (is_readable($file)) {
			$content = unserialize(file_get_contents($file));
			if (time() <= $content['end_time']) {
				return $content['data'];
			}
		}
		return false;
	}

	private static function mkdir_r($dirName, $rights = 0755)
	{
		str_contains('/', $dirName) ?
			$dirs = explode('/', $dirName) :
			$dirs = explode('\\', $dirName);
		$slash = DIRECTORY_SEPARATOR;
		$dir = ROOT;
		foreach ($dirs as $part) {
			if ($part) {
				$dir .= $slash . $part;
				if (!is_dir($dir)) {
					mkdir($dir, $rights);
				}
			}
		}
		return $dir;
	}

	public static function set(string $key, $data, int $seconds = 3600)
	{
		$content['data'] = $data;
		$content['end_time'] = time() + $seconds;
		$dir = self::mkdir_r('\tmp\cache');
		$file = $dir . DIRECTORY_SEPARATOR . md5($key) . '.txt';

		if (file_put_contents($file, serialize($content))) {
			return true;
		}
		return false;
	}


	public static function delete($key)
	{
		$file = ROOT . '/' . md5($key) . '.txt';
		if (file_exists($file)) {
			unlink($file);
		}
	}

}
