<?php

//use app\core\App;
//use \Engine\DI\DI;
use app\core\Auth;
use app\core\Router;

session_start();

error_reporting(E_ALL);

define('ROOT', dirname(__DIR__));

require_once "../vendor/autoload.php";

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();


require_once './Eloquent.php';

ini_set('display_errors', (int)$_ENV['DEV']);

//new App();
//DI::test();

try {
	Auth::getAuth();
//	new App(new DI);

	$router = new Router($_SERVER['REQUEST_URI']);
	$router->dispatch();

} catch (Exception $e) {
	exit($e);
};

exit();
