<?php
/*
* ws-file starter. 
* Этот файл запускается по AJAX запросу из скрипта, этот файл отвечает соответствно {run:1} - уже запущен, {run:2} - сейчас будет запущен
*
*/

define( 'ABSPATH', dirname(__FILE__) . '/../' );

require_once(ABSPATH."class/ws.php");

require(ABSPATH."cfg/ws.cfg.php");

if( file_exists($GLOBALS['ws']['pidfile']) ) {	//Не будем делать сложные проверки на устойчивость и долбать сервер, pid-файл есть, значит всё работает. 

	$pid = ws::getstatusf($GLOBALS['ws']['pidfile']);

	if($pid>=0){
		echo "{run:1}"; //1 уже запущен
		exit;
	} elseif($pid==-2){	//Файл есть а процесса нет
		unlink($GLOBALS['ws']['pidfile']);
		ws::consolemsg("wsstart.php - previously abnormal process termination");
		ws::consolemsg("wsstart.php - pidfile ".$pidfile." ulinked");
		ws::consolemsg("wsstart.php - try to run again");
	} elseif($pid==-1){ //Ничего нет ни файла ни процесса
		//Это ситуация обрабатывается в самом начале проверкой наличия файла
	}
} 


//Если не был запущен - запускаем
if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {  //Действия под виндой
	pclose(popen($GLOBALS['ws']['wincommandtostart'], "r"));
} else	exec($GLOBALS['ws']['commandtostart']);
echo "{run:2}"; //2 сейчас будет запущен

?>