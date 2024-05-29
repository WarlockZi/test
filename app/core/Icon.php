<?php

namespace app\core;

class Icon
{
   public static $commonPicPath = 'pic';
   public static $commonIconPath = 'icons';

   public static function __callStatic($name, $arguments): string
   {
      $arg = count($arguments) ?
         $arguments[0] . DIRECTORY_SEPARATOR :
         '';

      $ext = '.svg';
      $path = ROOT . "/" . self::$commonPicPath . "/" . self::$commonIconPath . "/" . $arg . $name . $ext;
      $file = FS::platformSlashes($path);
      if (!is_readable($file)) return $file;

      return FS::getFileContent($file);
   }

}