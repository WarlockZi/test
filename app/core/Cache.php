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

	public function get($key, $path='')
	{
		$file = ROOT . '/tmp/cache/' .$path. md5($key) . '.txt';
		if (is_readable($file)) {
			$content = unserialize(file_get_contents($file));
			if (time() <= $content['end_time']) {
				return $content['data'];
			}
		}
		return false;
	}

	private function createFileInDir($filename, $dir)
	{
		if(!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		if (!file_exists($filename)) fopen($filename, 'x');
	}

	public function set($key, $data, $seconds = 3600)
	{
		$content['data'] = $data;
		$content['end_time'] = time() + $seconds;
		$file = ROOT . '/tmp/cache/'. md5($key) . '.txt';

		$this->createFileInDir($file, ROOT.'\tmp\cache');

		if (file_put_contents($file, serialize($content))) {
			return true;
		}
		return false;
	}



	public function delete($key)
	{
		$file = CACHE . '/' . md5($key) . '.txt';
		if (file_exists($file)) {
			unlink($file);
		}
	}

}
