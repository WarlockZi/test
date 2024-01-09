<?

use app\core\Auth;
use app\core\Router;

session_start();
error_reporting(E_ALL);

define('ROOT', dirname(__DIR__));
$slash = DIRECTORY_SEPARATOR;
require_once ROOT . $slash . "vendor" . $slash . "autoload.php";
(Dotenv\Dotenv::createImmutable(ROOT))->load();

if ($_ENV['DEV']) {
	ini_set('display_errors', (int)$_ENV['DEV']);
	\app\Services\FrontendServerService::serve();
}

require_once ROOT . $slash . "public" . $slash . "Eloquent.php";

try {
	// shell_exec('npm --version 2>&1');
	Auth::getAuth();
	$router = new Router($_SERVER['REQUEST_URI'] ?? '');
	$router->dispatch();
} catch (Exception $e) {
	exit($e);
};

exit();
