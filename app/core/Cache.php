<?

namespace app\core;

class Cache
{

	public function getFromCache($file_name)
	{
		$file = ROOT . '/tmp/cache/test_results/' . $file_name . '.txt';
		if (file_exists($file)) {
			return require $file;
		}
	}

	public function get($key, $path = '')
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

	private function mkdir_r($dirName, $rights = 0755)
	{
		str_contains('/', $dirName) ?
			$dirs = explode('/', $dirName) :
			$dirs = explode('\\', $dirName);
		$slash = DIRECTORY_SEPARATOR;
<<<<<<< HEAD
		$dir = ROOT . $slash;
		chmod(ROOT, 0777);
		foreach ($dirs as $part) {
			if ($part) {
				$dir .= $part . $slash;
				if (!is_dir($dir))
					mkdir($dir, $rights);
				echo is_dir($dir);
=======
		$dir = ROOT;
		foreach ($dirs as $part) {
			if ($part) {
			    $dir .=  $slash . $part;
				if (!is_dir($dir)){
				mkdir($dir, $rights, true);
				}
>>>>>>> fc96fd667c1e3f9986ce4ef6e32fe89826d258fb
			}
		}
		chmod(ROOT, 0755);
		return $dir;
	}

	public function set($key, $data, $seconds = 3600)
	{
		$content['data'] = $data;
		$content['end_time'] = time() + $seconds;
		$dir = $this->mkdir_r('\tmp\cache');
		$file = $dir .DIRECTORY_SEPARATOR. md5($key) . '.txt';

		if (file_put_contents($file, serialize($content))) {
			return true;
		}
		return false; //lUPKLGANZK
	}


	public function delete($key)
	{
		$file = ROOT . '/' . md5($key) . '.txt';
		if (file_exists($file)) {
			unlink($file);
		}
	}

}
