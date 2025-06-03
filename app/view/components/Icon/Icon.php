<?php

namespace app\view\components\Icon;

use app\service\FS;

class Icon
{
    public static function __callStatic($name, $arguments): string
    {

        $arg = count($arguments)
            ? $arguments[0] . DIRECTORY_SEPARATOR
            : '';

        $svgPath = env('PIC_SVG');
        $path = ROOT . "{$svgPath}$arg$name.svg";
        $file = FS::platformSlashes($path);
        if (!is_readable($file)) return $file;

        return FS::getFileContent($file);
    }
}