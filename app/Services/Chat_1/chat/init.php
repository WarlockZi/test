<?php
/*
* Chat ws-file
* WebSocket daemon itself
* 23.11.2014 Petukhovsky
*
* chat include
* 
* config
* 
* classes 
* 
* init()
*
*/

define( 'ABSPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR );


require_once(ABSPATH."class/ws.php");
require_once(ABSPATH."class/chat.php");

require(ABSPATH."cfg/ws.cfg.php");
require(ABSPATH."cfg/chat.cfg.php");

//pid-file
//Если в PID файле хранится PID процесса и он активен, то не запускаем копию
if (ws::getstatusfwithconsole($GLOBALS['ws']['pidfile'])) {
	ws::consolemsg("init.php can't run another websocketserver, because already running...");
	ws::consoleend();
	exit;//1 уже запущен
}

require_once(ABSPATH."class/chat_class.php");
require_once(ABSPATH."class/websocketserver_class.php");


//system config
error_reporting(E_ALL); //Выводим все ошибки и предупреждения
set_time_limit(0);		//Время выполнения скрипта безгранично
ob_implicit_flush();	//Включаем вывод без буферизации
ignore_user_abort(true);//Выключаем зависимость от пользователя
//system config

//srdin/stdout
ini_set('error_log', $GLOBALS['ws']['wserrorslogfile']);
if(defined('STDIN'))  fclose(STDIN);
if(defined('STDOUT')) fclose(STDOUT);
if(defined('STDERR')) fclose(STDERR);

$STDIN = fopen('/dev/null', 'r');
$STDOUT = fopen($GLOBALS['ws']['wsconsolelogfile'], 'ab');
$STDERR = fopen($GLOBALS['ws']['wsconsoleerrfile'], 'ab');
//srdin/stdout

$config = array(
	'pidfile' => $GLOBALS['ws']['pidfile'],
	'offfile' => $GLOBALS['ws']['offfile'],
	'sslphp' => $GLOBALS['ws']['sslphp'],
	'pemcrtfile' => $GLOBALS['ws']['pemcrtfile'],
	'pemkeyfile' => $GLOBALS['ws']['pemkeyfile'],
    'pemfile' => $GLOBALS['ws']['pemfile'],
	'max_connects_from_ip' => $GLOBALS['ws']['maxconnectsfromip'],
	'log' => true,
	'host' => $GLOBALS['ws']['addr'],
    'port' => $GLOBALS['ws']['port']
);

$websocketserver = new websocketserver_class($config);
$websocketserver->start();


?>