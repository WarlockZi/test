<?php

use app\core\FS;

ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
define('ROOT', dirname(__DIR__));

require_once ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
\app\Services\DotEnv::load(ROOT . DIRECTORY_SEPARATOR . ".env");
//(Dotenv\Dotenv::createImmutable(ROOT, '.env'))->load();
define('DEV', getenv("VITE_DEV"));

\app\core\Cache::$enabled = getenv('CACHE');

if (DEV) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");
header('Access-Control-Allow-Origin: http://127.0.0.1:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');