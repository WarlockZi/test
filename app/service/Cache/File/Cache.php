<?php

namespace app\service\Cache\File;


use app\service\Cache\BaseCache;
use app\service\Cache\ICache;
use app\service\FS;
use Illuminate\Database\Eloquent\Collection;

class Cache extends BaseCache implements ICache
{
    private static string $path = ROOT . '/storage/framework/caches/';

    private function __construct()
    {
        parent::__construct();
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
        $dir  = FS::platformSlashes(self::mkdir_r("storage/framework/caches/$path"));
        $file = $dir . $key . '.txt';

        if (is_callable($data)) {
            $unserialized    = $data();
            $content['data'] = $unserialized;
        }
        $content['end_time'] = time() + $seconds;

        $content = serialize($content);
        file_put_contents($file, $content);
        if (is_string($unserialized)) {
            return new Collection(json_decode($unserialized));
        }
        return $unserialized;
    }

    private static function mkdir_r(string $dirName, int $rights = 0755): string
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

    public static function forget($key): void
    {
        $file = FS::platformSlashes(self::$path . "$key.txt");
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public static function getInstance(): ?BaseCache
    {
        if (!self::$instance) {
            self::$instance = new self;
            return self::$instance;
        }
        return self::$instance;
    }
    private function __clone() {}

}
