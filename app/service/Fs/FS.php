<?php

namespace app\service\Fs;

use app\service\Logger\ILogger;
use FilesystemIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Throwable;

class FS
{
    public function __construct(
        protected string  $absPath,
        protected ILogger $errorLogger,
    )
    {
    }

    /**
     * @throws FSException
     */
    public static function files(string $dir, string $ext = ''): false|array
    {
        if (!is_dir($dir)) {
            throw new FSException($dir . 'is not a directory');
        }
        if ($ext) {
            return glob($dir . '*.' . $ext);
        }
        return glob($dir);
    }
    public static function filesByExt(string $dir, string $ext): array
    {
        $xmlFiles = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'xml') {
                $xmlFiles[] = $file->getPathname();
            }
        }

        return $xmlFiles;
    }

    public static function resolve(...$paths): string
    {
        $path = '';
        foreach ($paths as $str) {
            if ($str) {
                $path .= $str . DIRECTORY_SEPARATOR;
            }
        }
        return str_replace(['\\/', '/\\', '\\', '\\\\', '/', '//',], DIRECTORY_SEPARATOR, $path);
    }

    public static function getFileContent(string $file, array $vars = []): string
    {
        extract($vars);
        ob_start();
        require FS::platformSlashes($file);
        return ob_get_clean();
    }

    public static function invertSlashes(string $path): string
    {
        return strtr($path, ['\\' => '/', '/' => '\\']);
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

    public static function createIfNotExist(...$args): string
    {
        if (!empty($args) && is_array(end($args))) {
            $options = array_pop($args) ?? [];
        }

        $permissions = $options['permissions'] ?? 0755;
        $recursive   = $options['recursive'] ?? true;

        $s   = DIRECTORY_SEPARATOR;
        $dir = ROOT;

        foreach ($args as $arg) {
            $dir .= $s . $arg;
            if (!is_dir($dir)) {
                try {
                    mkdir($dir, $permissions, $recursive);
                } catch (Throwable $exception) {
                    response()->popup("Ошибка создания директории $dir ".$exception->getMessage());
                }
            }
        }
        return self::platformSlashes($dir);
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

            return ob_get_clean();
        } catch (\Throwable $exception) {
            ob_get_clean();
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