<?

namespace app\core;

use Illuminate\Database\Eloquent\Collection;

class Cache
{
    public static bool $enabled = true;
    public static int $timeLife1 = 1;
    public static int $timeLife10 = 10;
    public static int $timeLife100 = 100;
    public static int $timeLife1_000 = 1_000;
    public static int $timeLife10_000 = 10_000;
    private static $instance = null;
    private static string $path = ROOT . '/tmp/cache/';

    private function __construct()
    {
    }

    public static function get(string $key, string|array|callable $data, int $seconds = 10, $path = '')
    {
        $file = FS::platformSlashes(self::$path . $path . $key . '.txt');
        if (is_readable($file) && self::$enabled) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time'] && self::$enabled) {
                return $content['data'];
            } else {
                return self::set($key, $data, $seconds, $path);
            }
        } else {
            return self::set($key, $data, $seconds, $path);
        }
    }

    public static function set(string $key, callable $data, int $seconds = 6, string $path = ''): string|array|object|null
    {
        if (is_callable($data)) {
            $unserialized    = $data();
            $content['data'] = $unserialized;
        }
        $content['end_time'] = time() + $seconds;
        $dir                 = FS::platformSlashes(self::mkdir_r("tmp/cache/$path"));
        $file                = $dir . $key . '.txt';

        $content = serialize($content);
        file_put_contents($file, $content);
        if (is_string($unserialized)) {
            return new Collection(json_decode($unserialized));
        }
        return $unserialized;
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

    public static function off(): void
    {
        self::$enabled        = false;
        self::$timeLife100    = 1;
        self::$timeLife1_000  = 1;
        self::$timeLife10_000 = 1;
    }

    public static function delete($key): void
    {
        $file = FS::platformSlashes(self::$path . "$key.txt");
        if (file_exists($file)) {
            unlink($file);
        }
    }

    // Защита от клонирования

    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
            return self::$instance;
        }
        return self::$instance;
    }

    private function __clone()
    {
    }
}
