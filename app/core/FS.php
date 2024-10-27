<?php

namespace app\core;
use app\Services\Logger\ErrorLogger;

class FS
{
    protected string $absPath;
    protected ErrorLogger $errorLogger;

    public function __construct(string $absPath = ROOT)
    {
        $this->absPath = $absPath . DIRECTORY_SEPARATOR;
        $this->errorLogger = new ErrorLogger();
    }

    public function getAbsPath(): string
    {
        return $this->absPath;
    }

    public function getContent(string $file, array $data = []):string
    {
        try {
            $file = FS::platformSlashes($this->absPath . $file . '.php');
            if (!is_readable($file)) $this->errorLogger->write('not exist - '.$file);

            extract($data);
            unset($data);
            unset($fs);
            ob_start();

            require $file;

            $content = ob_get_clean();
            return $content;
        } catch (\Throwable $exception){
            $content = ob_get_clean();
            if ($_ENV['DEV']==='1'){
           $callerClass = debug_backtrace()[2]['file']." (line ".debug_backtrace()[2]['line'].")";
           $callerClass1 = debug_backtrace()[3]['file']." (line ".debug_backtrace()[3]['line'].")";
           $callerClass2 = debug_backtrace()[4]['file']." (line ".debug_backtrace()[4]['line'].")";
           $callerMethod = debug_backtrace()[2]['function'];
           $callerMethod1 = debug_backtrace()[3]['function'];
           $callerMethod2 = debug_backtrace()[4]['function'];
                return date('y-m-d, h:m:s').PHP_EOL.'<br><br>' .
                    "class {$callerClass}" . PHP_EOL . '<br><br>' .
                    "class {$callerClass1}" . PHP_EOL . '<br><br>' .
                    "class {$callerClass2}" . PHP_EOL . '<br><br>' .
                    "method {$callerMethod}" . PHP_EOL . '<br><br>' .
                    "method {$callerMethod1}" . PHP_EOL . '<br><br>'.
                    "method {$callerMethod2}" . PHP_EOL . '<br><br>'.
                   $exception;
            }
            $this->errorLogger->write($exception);
            return 'ошибка в файле';
        }

    }

    public static function resolve(...$paths):string
    {
        $path = '';
        foreach ($paths as $str) {
            if ($str) $path .= $str . DIRECTORY_SEPARATOR;
        }
        return $path;
    }

    public static function getFileContent(string $file, array $vars = []):string
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

    public static function getPath(...$args):string
    {
        $s   = DIRECTORY_SEPARATOR;
        $str = ROOT . $s;
        foreach ($args as $arg) {
            $str .= $arg . $s;
        }
        return self::platformSlashes($str);
    }

    public static function platformSlashes($path):string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    public static function getOrCreateAbsolutePath(...$args):string
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