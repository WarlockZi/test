<?php

class chat{

//-----------------------------------------------------------------------------------
/**
* Логирование сообщений чата
*/
public static function logmsg($msg="", $uid=-1){
	$file = null;
	if(!file_exists($GLOBALS['chat']['logfile'])) {
	    $file = fopen($GLOBALS['chat']['logfile'],"w");
		fputs($file, "<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<title>chat log</title>\r\n\r\n<meta charset=\"UTF-8\" />\r\n</head>\r\n<body>\r\n"); //Сохраняем значение счётчика
	}else
	    $file = fopen($GLOBALS['chat']['logfile'],"a");
	
	$mem ="";
	if( function_exists('memory_get_usage') ) $mem = "Mem: ".memory_get_usage()." bytes ";

	fputs ($file, "[<b>".date("Y.m.d-H:i:s")."</b>]"."[".$uid."]"."[".$mem."]". $msg ."<br />\r\n"); 
	fclose($file); 
}


















}

?>