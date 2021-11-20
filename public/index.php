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