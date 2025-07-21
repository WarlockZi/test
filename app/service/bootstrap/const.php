<?php

use app\service\Fs\FS;

$root = $_SERVER['SESSIONNAME'] === 'Console'
    ? dirname(getcwd(), 3)
    : dirname(__DIR__, 3);

define("ROOT",$root);
define('DEV', env("VITE_DEV"));

define('PIC_SERVICE', env("PIC_SERVICE"));
define('PIC_PRODUCT', env("PIC_PRODUCT"));
define('PIC_SVG', env("PIC_SVG"));

define('CACHE_FRAMEWORK', env("CACHE_FRAMEWORK"));
define('CACHE_APP', env("CACHE_APP"));

define("APP_STORAGE", FS::platformSlashes(ROOT . '/storage/app/'));
define("FRAMEWORK_STORAGE", FS::platformSlashes(ROOT . '/storage/framework/'));
define("LOG_STORAGE", FS::platformSlashes(ROOT . '/storage/logs/'));
