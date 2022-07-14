<?

use app\core\App;
use app\core\Router;
use \Engine\DI\DI;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

session_start();

require_once "../vendor/autoload.php";

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

require_once "../engine/bootstrap.php"; // container

error_reporting(E_ALL);
define('DEV', $_ENV['MODE'] === 'development'); //0-не выводить ошибки
define('ROOT', dirname(__DIR__));
define('ICONS', ROOT.'/app/view/components/icons');
define('TRASH', ICONS.'/trashIcon.svg');
define('SAVE', ICONS.'/save.svg');
define('EDIT', ICONS.'/edit.svg');
define('COMPONENTS', ROOT.'/app/view/components');


$capsule = new Capsule;
$capsule->addConnection([
	'driver'    => 'mysql',
	'host'      => 'localhost',
	'database'  => $_ENV['DB_DB'],
	'username'  => $_ENV['DB_USER'],
	'password'  => $_ENV['DB_PASSWORD'],
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();


if (DEV) {
	ini_set('display_errors', 1);
}
new App(new DI);
//new App();
//DI::test();
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