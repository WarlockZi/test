<?php

$s = DIRECTORY_SEPARATOR;
//файл процесса
$GLOBALS['ws']['pidfile']=ABSPATH."pid{$s}pid_file.pid";
$GLOBALS['ws']['offfile']=ABSPATH."pid{$s}off_file.pid";

//использование SSL PHP
$GLOBALS['ws']['sslphp']=false;

//Файлы сертификата
$GLOBALS['ws']['pemcrtfile']="certificate.crt";
$GLOBALS['ws']['pemkeyfile']="certificate.key";

$GLOBALS['ws']['pemfile']=ABSPATH."pem{$s}pemfile.pem";

//логфайлы
$GLOBALS['ws']['logfile'] = ABSPATH."log{$s}wslog.html";

$GLOBALS['ws']['wserrorslogfile'] = ABSPATH."log{$s}wserrors.txt";
$GLOBALS['ws']['wsconsolelogfile'] = ABSPATH."log{$s}wsconsolelog.txt";
$GLOBALS['ws']['wsconsoleerrfile'] = ABSPATH."log{$s}wsconsoleerr.txt";

$GLOBALS['ws']['commandtostart'] = "php -q ".ABSPATH."init.php &";
$path = "C:\\Users\\vvoro\\Desktop\\8.3\\php.exe";
$GLOBALS['ws']['wincommandtostart'] = "start /b $path -q ".ABSPATH."init.php";

$GLOBALS['ws']['addr'] = '0.0.0.0'; // адресс широковещательной раздачи.
$GLOBALS['ws']['port'] = 8889; // порт с которым будет установленно соединение.
$GLOBALS['ws']['maxconnectsfromip'] = 7;


define( 'TIME_BETWEEN_REQUESTS', 0.2); //Перенести на уровень транспорта, т.е. в web socket

?>