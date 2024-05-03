<?php

use app\core\Auth;
use app\core\FS;
use app\core\Router;

session_start();
ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
define('ROOT', dirname(__DIR__));

require_once ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
(Dotenv\Dotenv::createImmutable(ROOT))->load();

if ($_ENV['DEV']) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL| E_STRICT);
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");

try {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: X-Requested-With');
    $user = Auth::getAuth();


//	$mockUser = \app\model\User::query()->find(160);
//	Auth::setUser($mockUser);

    $router = new Router($_SERVER['REQUEST_URI'] ?? '');
    $router->dispatch();

    exit();
} catch (Exception $e) {
    exit($e);
}


