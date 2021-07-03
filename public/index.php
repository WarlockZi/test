<?

use app\core\Router;
use app\core\App;

session_start();

require_once "../vendor/autoload.php";

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

error_reporting(E_ALL);
define('DEV', $_ENV['MODE'] === 'dev'); //0-не выводить ошибки
define('ROOT', dirname(__DIR__));
if (DEV) {
	ini_set('display_errors', 1);
}

new App;

Router::dispatch($_SERVER['QUERY_STRING']);


//function vitexAutoload($class)
//{
//	$file = ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
//	if (is_readable($file)) {
//		require_once $file;
//	}
//}
//function composerAutoload($class)
//{
//	require (ROOT.'/vendor/autoload.php');
//	$file = ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
//	if (is_file($file)) {
//		require_once $file;
//	}
//}
//spl_autoload_register('composerAutoload');
//spl_autoload_register('vitexAutoload');