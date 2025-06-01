<?php

namespace app\service;

use app\service\Logger\ILogger;

class FS
{
    public function __construct(
        protected string  $absPath,
        protected ILogger $errorLogger,
    )
    {
    }

    public static function resolve(...$paths): string
    {
        $path = '';
        foreach ($paths as $str) {
            if ($str) $path .= $str . DIRECTORY_SEPARATOR;
        }
        return $path;
    }

    public static function getFileContent(string $file, array $vars = []): string
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

    public static function getPath(...$args): string
    {
        $s   = DIRECTORY_SEPARATOR;
        $str = ROOT . $s;
        foreach ($args as $arg) {
            $str .= $arg . $s;
        }
        return self::platformSlashes($str);
    }

    public static function getOrCreateAbsolutePath(...$args): string
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

    public function getAbsPath(): string
    {
        return $this->absPath;
    }

    public function getContent(string $file, array $data = []): string
    {
        try {
            $file = FS::platformSlashes($this->absPath . $file . '.php');
            if (!is_readable($file)) $this->errorLogger->write('not exist - ' . $file);

            extract($data);
            unset($data);
            unset($fs);
            ob_start();

            require $file;

            $content = ob_get_clean();
            return $content;
        } catch (\Throwable $exception) {
            $content = ob_get_clean();
            if (DEV) {

                return date('y-m-d, h:m:s') . PHP_EOL . '<br><br>' .
                    $exception;
            }
            $this->errorLogger->write($exception);
            return 'ошибка в файле';
        }
    }

    public static function platformSlashes($path): string
    {
        return str_replace(['/', '//', '\\', '\\\\'], DIRECTORY_SEPARATOR, $path);
    }

}