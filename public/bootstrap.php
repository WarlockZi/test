<?php

use app\core\FS;
use \app\core\Cache;

ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
define('ROOT', dirname(__DIR__));

function env($key)
{
    return $_ENV[$key];
}
require_once ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
\app\Services\DotEnv::load(ROOT . DIRECTORY_SEPARATOR . ".env");

define('DEV', env("VITE_DEV"));

Cache::$enabled = env('CACHE');


if (DEV) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");

header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');