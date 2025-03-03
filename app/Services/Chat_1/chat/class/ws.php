<?php
class ws{
//-----------------------------------------------------------------------------------
/**
* сообщение ws и системы
*/
//сообщение о запуске консоли
public static function consolestart(){
	self::consolemsg("console - start");
}

//сообщение
public static function consolemsg($msg, $ignoredirectoutput = false){
	$file = null;
	if(!file_exists($GLOBALS['ws']['logfile'])) {
	    $file = fopen($GLOBALS['ws']['logfile'],"w");
//		fputs($file, "<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<title>GC - console log</title>\r\n\r\n<meta charset=\"UTF-8\" />\r\n</head>\r\n<body>\r\n"); //Шапку не ставим т.к. эта часть всё равно отображается в div
	}else
	    $file = fopen($GLOBALS['ws']['logfile'],"a");
	
	
	if( function_exists('memory_get_usage') ) $msg = "Mem: ".memory_get_usage()." bytes ".$msg;

	if(!$ignoredirectoutput) { echo $msg."\r\n"; }

	fputs ($file, "[<b>".date("Y.m.d-H:i:s")."</b>]". $msg ."<br />\r\n"); 
	fclose($file); 
}

//закрытие консоли
public static function consoleend(){
	self::consolemsg("console - end");
}

//-----------------------------------------------------------------------------------
/**
* Получение данных о процессе
*/
public static function getstatusfwithconsole($pidfile) {
  if( file_exists($pidfile) ) {
    $pid = file_get_contents($pidfile);
    //получаем статус процесса
	$status = self::getstatusp($pid);
    if($status['run']) { 
	  //демон уже запущен
	  self::consolemsg("daemon already running info=".$status['info']);
      return true;
    } else {
      //pid-файл есть, но процесса нет
      self::consolemsg("there is no process with PID = ".$pid.", last termination was abnormal...");
      self::consolemsg("try to unlink PID file...");
      if(!unlink($pidfile)) {
	    self::consolemsg("ERROR");
        //не могу уничтожить pid-файл. ошибка
        exit(-1);
      }
      self::consolemsg("OK");
    }
  }
  return false;
}

//-----------------------------------------------------------------------------------
/**
* Проверяем наличие процесса, возвращаем либо pid, либо -1 если процесса и файла нет, -2 если файл есть а процесса нет
*/
public static function getstatusf($pidfile) {

  if( file_exists($pidfile) ) {

	$pid = file_get_contents($pidfile);
	$output = null;

	if (strtoupper(substr(PHP_OS,0,3)) === 'WIN'){ 
		exec("tasklist /fi \"pid eq ".$pid."\"", $output);

		if(count($output)>3){//Если в результате выполнения больше одной строки то процесс есть! т.к. первая строка это заголовок, а третья уже процесс
			if(self::issocketlive()) {	//Если сокет живой
				return $pid; 
			} else { //Иначе сокет недоступен
				return -2;
			}
		} else {
		  //pid-файл есть, но процесса нет
		   return -2;
		}
	} else {//Если *nix
		exec("ps -o user,pid,pcpu,pmem,vsz,rssize,tname,stat,stime,command -p ".$pid, $output);
		
		if(count($output)>1){//Если в результате выполнения больше одной строки то процесс есть! т.к. первая строка это заголовок, а вторая уже процесс
			if(self::issocketlive()) {	//Если сокет живой
				return $pid; 
			} else { //Иначе сокет недоступен
				return -2;
			}
		} else {
		  //pid-файл есть, но процесса нет
		   return -2;
		}
	}
  }
  return -1;//файла и процесса нет

}

//-----------------------------------------------------------------------------------
/**
* Проверка состояния процесса под *nix
*/
public static function getstatusp($pid) {
	$result = array ('run'=>false);
	$output = null;

	if (strtoupper(substr(PHP_OS,0,3)) === 'WIN'){ 
		exec("tasklist /fi \"pid eq ".$pid."\"", $output);

		if(count($output)>3){//Если в результате выполнения больше одной строки то процесс есть! т.к. первая строка это заголовок, а третья уже процесс
			if(self::issocketlive()) {	//Если сокет живой
				$result['run'] = true;
				$result['info'] = $output[3];//строка с информацией о процессе
			} else { //Иначе сокет недоступен
				$result['run'] = false;
			}
		} 
	} else {//Если *nix
		exec("ps -o user,pid,pcpu,pmem,vsz,rssize,tname,stat,stime,command -p ".$pid, $output);

		if(count($output)>1){//Если в результате выполнения больше одной строки то процесс есть! т.к. первая строка это заголовок, а вторая уже процесс
			if(self::issocketlive()) {	//Если сокет живой
				$result['run'] = true;
				$result['info'] = $output[1];//строка с информацией о процессе
			} else { //Иначе сокет недоступен
				$result['run'] = false;
			}
		}
	}

	return $result;
}

//-----------------------------------------------------------------------------------
/**
* Передаём в виде JSON все данные о том, что происходит с процессом ws
*/
public static function json_statusf($pidfile) {

  if( file_exists($pidfile)  ) {
    $pid = file_get_contents($pidfile);
	$output = null;
	$wsprotocol = ($GLOBALS['ws']['sslphp']) ? 'ssl' : 'tcp'; 

	if (strtoupper(substr(PHP_OS,0,3)) === 'WIN'){ //Для Windows всё просто, не смотрим PID и не заморачиваемся с процессами, т.к. это наша отладочная лошадка
		exec("tasklist /fi \"pid eq ".$pid."\"", $output);



		if(count($output)>3){//Если в результате выполнения больше одной строки то процесс есть! т.к. первая строка это заголовок, а вторая уже процесс
			if(self::issocketlive()) {	//Если сокет живой
				echo "{color:\"green\",msg:\"WINDOWS:[<b>".date("Y.m.d-H:i:s")."</b>] wss server is running with PID =".$pid." ".$wsprotocol."://".$GLOBALS['ws']['addr'].":".$GLOBALS['ws']['port']."<br />";
			} else { //Иначе сокет недоступен
				echo "{color:\"red\",msg:\"WINDOWS:[<b>".date("Y.m.d-H:i:s")."</b>] wss server is running with PID =".$pid." ".$wsprotocol."://".$GLOBALS['ws']['addr'].":".$GLOBALS['ws']['port']." (unrechable)<br />";
			}
			
			echo mb_convert_encoding($output[1], "utf-8", "cp866")."<br />";//строка с информацией о процессе
			echo mb_convert_encoding($output[3], "utf-8", "cp866")."\"}";//строка с информацией о процессе
			
			//consolemsg("MSG FROM WIN ".$output[1].$output[2], true);
			return;
		} else {
		  //pid-файл есть, но процесса нет
		  echo  "{color:\"red\",msg:\"WINDOWS:[<b>".date("Y.m.d-H:i:s")."</b>] ws server is down cause abnormal reason with PID =".$pid."<br />\"}";
		  return;
		}
	}

	//получаем статус процесса
	exec("ps -o user,pid,pcpu,pmem,vsz,rssize,tname,stat,stime,command -p ".$pid, $output);
    
	if(count($output)>1){//Если в результате выполнения больше одной строки то процесс есть! т.к. первая строка это заголовок, а вторая уже процесс
		if(self::issocketlive()) {	//Если сокет живой
			echo "{color:\"green\",msg:\"*NIX:[<b>".date("Y.m.d-H:i:s")."</b>] wss server is running with PID =".$pid." ".$wsprotocol."://".$GLOBALS['ws']['addr'].":".$GLOBALS['ws']['port']."<br />";
		} else { //Иначе сокет недоступен
			echo "{color:\"red\",msg:\"*NIX:[<b>".date("Y.m.d-H:i:s")."</b>] wss server is running with PID =".$pid." ".$wsprotocol."://".$GLOBALS['ws']['addr'].":".$GLOBALS['ws']['port']." (unrechable)<br />";
		}
		echo $output[0]."<br />";//строка с информацией о процессе
		echo $output[1]."\"}";//строка с информацией о процессе
		return;
	} else {
      //pid-файл есть, но процесса нет
	  echo  "{color:\"red\",msg:\"*NIX:[<b>".date("Y.m.d-H:i:s")."</b>] ws server is down cause abnormal reason with PID =".$pid."<br />\"}";
	  return;
    }
  }

  if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') //Для Windows всё просто, не смотрим PID и не заморачиваемся с процессами, т.к. это наша отладочная лошадка
		echo "{color:\"grey\",msg:\"WINDOWS:[<b>".date("Y.m.d-H:i:s")."</b>] wss server is off, press start<br />wss://".$GLOBALS['ws']['addr'].":".$GLOBALS['ws']['port']."\"}";
  else 	 
		echo "{color:\"grey\",msg:\"*NIX:[<b>".date("Y.m.d-H:i:s")."</b>] wss server is off, press start<br />wss://".$GLOBALS['ws']['addr'].":".$GLOBALS['ws']['port']."\"}";

}
//-----------------------------------------------------------------------------------
/**
* Проверка подключения к сокету
* Чтобы исключить случаи когда процесс есть, но сокет не работает  (Это значит либо процесс не тот, либо сокет умер)
*
*
* Можно проверить другим способом, например, глядя на процесс по PID. 
*/
public static function issocketlive() {
	
	//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  if ($socket < 0){/* Ошибка */}
	//$connect = socket_connect($socket, $GLOBALS['ws']['addr'], $GLOBALS['ws']['port']);
	//if(isset($socket))	socket_close($socket);
	//
	//if($connect === false) {  //Подключиться не удалось
	//	return false;				
	//} else {	//Подключиться удалось
	//	return true;
	//}

	return true;
}


//-----------------------------------------------------------------------------------
/**
* Раскладывание переменной на значения
*/
public static function test_var_value($variable){//Вспомогательная для test_var
    	if (!isset($variable) ) //Если переменная не определена
    		return "undefined";

    	$res="";
    	if (is_null($variable) ){ //Если NULL
    		$res.="NULL";
    	}elseif (is_callable($variable)){
    		$res.= "<b>callable</b> ";
    		if (is_string($variable)){
    		    $functions = get_defined_functions();
    		    $res.= array_search($variable, $functions['internal'])? 'internal':'user';
    		    $res.= ' function '.htmlspecialchars($variable).'()';
    		} elseif (is_array($variable)){
    		    reset($variable);
    		    $class  = current($variable);
    		    $method = next($variable);
    		    if (is_string($class))      {  $res.= 'static class '.$class.'::'.$method.'()';				 }
    		    elseif (is_object($class))	 {  $res.= 'object of class '.get_class($class).'->'.$method.'()';	 }
    		    else						 {  $res.= 'unknown "'.strval($variable).'"';						 }
    		} else {
    		    $res.= 'unknown "'.strval($variable).'"';
    		}
    	}elseif ( is_array($variable) ){//Если массив, показываем все подзначения
    		$res.="<b>array</b>";
    		$res.="<ul>";
    		foreach( $variable as $key => $value ){
    			$res.="<li>";
    			$res.="[ ".self::test_var_value($key)." ] = ".self::test_var_value($value);
    			$res.="</li>";
    		}
    		$res.="</ul>";
    	}elseif (is_int($variable)){
    		$res.="<b>integer</b> ";
    		$res.=$variable;
    	}elseif (is_bool($variable)){
    		$res.="<b>bool</b>";
    		if ( $variable )
    			$res.="<i>True</i>";
    		else
    			$res.="<i>False</i>";
    	}elseif (is_string($variable)){
    		$res.= "<b>string</b>[".strlen($variable)."] ";
    		$res.= "\"".htmlspecialchars($variable)."\"";
    	}elseif (is_float($variable)){
    		$res.= "<b>float</b> ";
    		$res.= $variable;
    	}elseif (is_resource($variable)){
    		$res.= "<b>resource</b> ";
    		$res.= '"'.get_resource_type($variable).'"';
    	}elseif (is_object($variable)  ){
    		$res.= "<b>object</b>[".get_class($variable)."] ";
    		$res.= print_r($variable,1);
    	}else{
         $res.= "<b>Unknown type</b>";
    	}
    	return $res;
}
}

?>