<?php

use app\core\Auth;
use app\core\FS;
use app\core\Router;

session_start();
ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
define('ROOT', dirname(__DIR__));

$s = DIRECTORY_SEPARATOR;
require_once ROOT . $s . "vendor" . $s . "autoload.php";
(Dotenv\Dotenv::createImmutable(ROOT, '.env'))->load();

if ($_ENV['DEV']) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");

//require_once dirname(__DIR__) . '/app/view/helpers.php';
//vite('main.js') ;

try {
    header('Access-Control-Allow-Origin: http://127.0.0.1:5173');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: X-Requested-With');
    header('Access-Control-Allow-Headers: Content-Type');

//    header('Content-Type: application/json');
    $user = Auth::getAuth();


//	$mockUser = \app\model\User::query()->find(160);
//	$Olya = \app\model\User::query()
//        ->where('email', 'vitex018@yandex.ru')
//        ->first();
//	Auth::setUser($Olya);

    $router = new Router($_SERVER['REQUEST_URI'] ?? '');
    $router->dispatch();

    exit();
} catch (Throwable $e) {
    if ($_ENV['DEV'] <> '1') {
        $logger = new \app\Services\Logger\ErrorLogger();
        $logger->write($e);
    }
    exit($e);
}


