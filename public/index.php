<?
use app\core\Auth;
use app\core\Router;

require_once "../vendor/autoload.php";
(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

error_reporting(E_ALL);
ini_set('display_errors', (int)$_ENV['DEV']);
define('ROOT', dirname(__DIR__));

session_start();

require_once './Eloquent.php';

try {
	Auth::getAuth();
	$router = new Router($_SERVER['REQUEST_URI']);
	$router->dispatch();
} catch (Exception $e) {
	exit($e);
};

exit();
