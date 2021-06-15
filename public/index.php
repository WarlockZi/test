<?

use app\core\Router;
use app\core\App;

session_start();

	error_reporting(1);
if ($_SERVER['HTTP_HOST'] == 'vitexopt.ru') {
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	define('DEBU', '0'); //0-не выводить ошибки
 } else {
	define('ROOT', dirname(__DIR__));
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	define('DEBU', '0'); //0-не выводить ошибки
}

function vitexAutoload($class)
{
	$file = ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	if (is_readable($file)) {
		require_once $file;
	}
}
function composerAutoload($class)
{
	require (ROOT.'/vendor/autoload.php');
	$file = ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	if (is_readable($file)) {
		require_once $file;
	}
}

spl_autoload_register('composerAutoload');
spl_autoload_register('vitexAutoload');

new App;

$url = $_SERVER['QUERY_STRING'];

Router::dispatch($url);
