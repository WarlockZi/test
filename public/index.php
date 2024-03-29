<?php

use app\core\Auth;
use app\core\FS;
use app\core\Router;

session_start();
ini_set("short_open_tag", 1);
define('ROOT', dirname(__DIR__));

require_once ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
(Dotenv\Dotenv::createImmutable(ROOT))->load();

if ($_ENV['DEV']) {
	ini_set('display_errors', (int)$_ENV['DEV']);
	error_reporting(E_ALL);
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");

try {

	$user = Auth::getAuth();

//	$mockUser = \app\model\User::query()->find(160);
//	Auth::setUser($mockUser);

	$route = new Router($_SERVER['REQUEST_URI'] ?? '');
	$route->dispatch();

exit();
} catch (Exception $e) {
	exit($e);
}


