<?

namespace app\core;

class Cache
{
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
