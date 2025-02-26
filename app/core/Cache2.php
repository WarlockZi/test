<?

namespace app\core;

class Cache2
{
    public static function get(string $key, string|array|callable $data, $path = '')
    {
        $file = ROOT . '/tmp/cache/' . $path . $key . '.txt';
//        $m = new \Memcached();
        if (is_readable($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            } else {
                self::set($key, $data, $path);
            }
        } else {
            self::set($key, $data, $path);
        }
        return $content;
    }

    private static function mkdir_r($dirName, $rights = 0755): string
    {
        str_contains('/', $dirName) ?
            $dirs = explode('/', $dirName) :
            $dirs = explode('\\', $dirName);
        $slash = DIRECTORY_SEPARATOR;
        $dir   = ROOT;
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

    public static function set(string $key, $data, string $path = '', int $seconds = 6): void
    {
        if (is_callable($data)) {
            $content['data'] = $data();
        }
        $content['end_time'] = time() + $seconds;
        $dir                 = FS::platformSlashes(self::mkdir_r("tmp/cache/$path"));
        $file                = $dir . DIRECTORY_SEPARATOR . $key . '.txt';

//        if (is_array($data)||is_object($data)) {
//            $content['data'] = serialize($data);
//            file_put_contents($file, $content);
//        }else{
//        $content['data'] = $data;
        file_put_contents($file, serialize($content));
//        }
    }


    public static function delete($key)
    {
        $file = ROOT . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }

}
