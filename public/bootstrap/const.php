<?php
use \app\service\FS;
define("ROOT", dirname(__DIR__, 2));
define('DEV', env("VITE_DEV"));

define('PIC_SERVICE', env("PIC_SERVICE"));
define('PIC_PRODUCT', env("PIC_PRODUCT"));
define('PIC_SVG', env("PIC_SVG"));

define('FRAMEWORK_CACHE', env("FRAMEWORK_CACHE"));
define('APP_CACHE', env("APP_CACHE"));

define("APP_STORAGE", FS::platformSlashes(ROOT . '/storage/app/'));
define("FRAMEWORK_STORAGE", FS::platformSlashes(ROOT . '/storage/framework/'));
define("LOG_STORAGE", FS::platformSlashes(ROOT . '/storage/log/'));
