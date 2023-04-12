<?

use app\core\App;
use app\core\Auth;
use app\core\Router;
use \Engine\DI\DI;

session_start();

require_once "../vendor/autoload.php";

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

//require_once "../engine/bootstrap.php"; // container

error_reporting(E_ALL);
define('DEV', $_ENV['MODE'] === 'development'); //0-не выводить ошибки
define('ROOT', dirname(__DIR__));


require_once './Eloquent.php';

ini_set('display_errors', $_ENV['MODE']==='development');

//new App();
//DI::test();

try {
	Auth::getAuth();

	new App(new DI);

	$router = new Router($_SERVER['REQUEST_URI']);
	$router->dispatch();

} catch (Exception $e) {
	exit($e);
};

exit();

// определение мобильного устройства
//function check_mobile_device() {
//	$mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
//	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
//	// var_dump($agent);exit;
//	foreach ($mobile_agent_array as $value) {
//		if (strpos($agent, $value) !== false) return true;
//	}
//	return false;
//}