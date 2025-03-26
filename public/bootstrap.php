<?php

use app\core\FS;
use \app\core\Cache;
use \app\Services\DotEnv;

ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
define('ROOT', dirname(__DIR__));

function env($key)
{
    return $_ENV[$key];
}

$path = ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
require_once $path;

DotEnv::load(ROOT . DIRECTORY_SEPARATOR . ".env");


//require_once './blade/blade.php';

define('DEV', env("VITE_DEV"));
define('PIC_SERVICE', env("PIC_SERVICE"));
define('PIC_PRODUCT', env("PIC_PRODUCT"));
define('PIC_SVG', env("PIC_SVG"));

Cache::$enabled = env('CACHE');


if (DEV) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");

header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');