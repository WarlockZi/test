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
//	\app\Services\FrontendServerService::serve();
}

require_once FS::platformSlashes(ROOT . "/app/Services/Eloquent.php");

try {
	Auth::getAuth();
	$router = new Router($_SERVER['REQUEST_URI'] ?? '');
	$router->dispatch();
} catch (Exception $e) {
	exit($e);
};

exit();
