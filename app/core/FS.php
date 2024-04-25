<?php

namespace app\core;
class FS
{
    protected $absPath;

    public function __construct(string $absPath = ROOT)
    {
        $this->absPath = $absPath;
    }

    public function getContent(string $file, $data)
    {
        $file = FS::platformSlashes($this->absPath . $file . '.php');
        if (!is_readable($file)) throw new \Exception('File not exist');

        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }

    public static function resolve(...$paths)
    {
        $path = '';
        foreach ($paths as $str) {
            $path .= $str.DIRECTORY_SEPARATOR;
        }
        return $path;
    }

    public static function getFileContent(string $file, array $vars = [])
    {
        extract($vars);
        ob_start();
        require FS::platformSlashes($file);
        return ob_get_clean();
    }

    public static function delFilesFromPath(string $path, string $ext = ''): array
    {
        $ext     = $ext ?? '*';
        $files   = glob(ROOT . $path . "*.$ext");
        $deleted = array();
        foreach ($files as $file) {
            array_push($deleted, $file);
            unlink($file);
        }
        return $deleted;
    }

    public static function getPath(...$args)
    {
        $s   = DIRECTORY_SEPARATOR;
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

    public static function getOrCreateAbsolutePath(...$args)
    {
        $s   = DIRECTORY_SEPARATOR;
        $dir = ROOT;
        foreach ($args as $arg) {
            $dir .= $s . $arg;
            if (!is_dir($dir)) {
                $res = mkdir($dir, 0777);
            }
        }
        return $dir;
    }

}