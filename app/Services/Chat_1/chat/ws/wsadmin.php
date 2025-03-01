<?php
//TODO добавить возможность запуска скрипта init через iframe в панели администратора, чтобы понимать почему не компилится!!!!!!!

define( 'ABSPATH', dirname(__FILE__) . '/../' );

require_once(ABSPATH."class/ws.php");

require(ABSPATH."cfg/ws.cfg.php");

$login = 'admin';
$pass  = '1234';


ini_set('display_errors', 1);
error_reporting(E_ALL); //Выводим все ошибки и предупреждения

session_start();

//-Блок авторизации
if(isset($_POST['login']) && isset($_POST['pass'])){
	if($_POST['login']==$login && $_POST['pass']==$pass){
		$_SESSION['wsadmin']['login'] = $login;
		echo "{msg:1}";
		exit();
	}
}
//-Блок авторизации

if(isset($_GET['act']) && isset($_SESSION['wsadmin']['login'])) $act = $_GET['act']; //Проверяем наличие команды и заодно авторизацию
else {
	echo "{msg:-1}";
	exit();
}

if($act=='start') { //Если происходит действите старт, инициализируем игру

	if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {  //Действия под виндой
		pclose(popen($GLOBALS['ws']['wincommandtostart'], "r"));
	} else	exec($GLOBALS['ws']['commandtostart']);

	//воткнуть паузу 0,5 для того, чтобы ws сервак мог нормально стартануть
	usleep(300000);
	ws::json_statusf($GLOBALS['ws']['pidfile']);
	exit();

} elseif($act=='stop'){ //Если действите старт не произошло и игра не инициализирована, то выходим
	
	$pid = ws::getstatusf($GLOBALS['ws']['pidfile']);
	if($pid<0){ //Процесс не работает и пришел код ошибки, который всегда меньше 0
		//echo "{color:\"grey\",msg:\"[<b>".date("Y.m.d-H:i:s")."</b>] ws echo server already stopped\"}";//Не работает передача - это JSON 
		ws::json_statusf($GLOBALS['ws']['pidfile']);
		exit();
	} 
	//создаём offfile только зная что процесс запущен, чтобы избежать глюков при следующем запуске процесса
	file_put_contents($GLOBALS['ws']['offfile'], $pid);//СОХРАНЯЕМ PID в OFF файле

	if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {  //Действия под виндой
		usleep(300000);
	} 
	usleep(300000);

	//Для того, чтобы полностью отключить сервер, нужно отправить ему сообщение, чтобы у него сработал read
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket < 0){/* Ошибка */ }
	$connect = socket_connect($socket, $GLOBALS['ws']['addr'], $GLOBALS['ws']['port']);
	if($connect === false) { /* echo "Ошибка : ".socket_strerror(socket_last_error())."<br />"; */ } 
	else { //Общение
		//echo 'Сервер сказал: '; $awr = socket_read($socket, 1024); echo $awr."<br />";
		//$msg = "Hello Сервер!"; echo "Говорим серверу \"".$msg."\"..."; socket_write($socket, $msg, strlen($msg));
	}

	if(isset($socket))	socket_close($socket);

	//воткнуть паузу для того, чтобы сервак мог нормально завершить работу
	usleep(500000);
	if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {  //Действия под виндой
		usleep(2000000);
	}

	ws::json_statusf($GLOBALS['ws']['pidfile']);
	exit();

} elseif($act=='status'){ //Если действите старт не произошло и игра не инициализирована, то выходим
	
	ws::json_statusf($GLOBALS['ws']['pidfile']);
	exit();

} elseif($act=='clearlog'){ //Чистим лог и возвращаем статус процесса
	unlink($GLOBALS['ws']['logfile']);
	ws::consolemsg("logfile - cleared by admin");
	ws::json_statusf($GLOBALS['ws']['pidfile']);

	exit();

} elseif($act=='clearwserrorslogfile'){ //Чистим файл ошибок и возвращаем 

    $file = fopen($GLOBALS['ws']['wserrorslogfile'],"w");
	fputs ($file, "[<b>".date("Y.m.d-H:i:s")."</b>] File just was cleared by admin<br />\r\n"); 
	fclose($file); 

	ws::consolemsg("ws server errorfile - cleared by admin");
	ws::json_statusf($GLOBALS['ws']['pidfile']);

	exit();

} elseif($act=='exit'){ //Выход из панели управления

	unset($_SESSION['wsadmin']['login']);
	echo "{msg:-1}";
	exit();
}
?>