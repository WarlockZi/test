<?php

namespace app\core;

class Icon
{

    public static function __callStatic($name, $arguments): string
    {
        $svgPath = 'storage/app/svg';

        $arg = count($arguments)
            ? $arguments[0] . DIRECTORY_SEPARATOR
            : '';

        $path = ROOT . "/{$svgPath}/$arg$name.svg";
        $file = FS::platformSlashes($path);
        if (!is_readable($file)) return $file;

        return FS::getFileContent($file);
    }

}