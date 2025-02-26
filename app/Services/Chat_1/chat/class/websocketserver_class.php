<?php

class websocketserver_class{

	private $config; 
	private $starttime;
	private $server;
	private $connects;
	private $users;
	private $ips; //Массив IP адресов, запрещаем больше х подключений с одного IP
	private $id; //счётчик id подключений
	private $online;
	private $chat; //Класс чата

	public function __construct($config) {
        $this->config = $config;
		$this->connects = array();
		$this->users = array();
		$this->ips = array();
		$this->id = 1; //Начинаем с 1го номера
		$this->online = 0; 

		if($this->config['log']){
			ws::consolestart();
			ws::consolemsg("WebsocketServer __construct"); 
		}
    }

	public function __destruct() {
		ws::consolemsg("__destruct()"); 
		ws::consolemsg("time = ".(round(microtime(true),2) - $this->starttime)); 
		/*
		fclose($this->server);
		ws::consolemsg("socket - closed");	
		unlink($this->config['pidfile']);
		ws::consolemsg("pidfile ".$this->config['pidfile']." unlinked");
		*/
		ws::consoleend();
		exit();		
    }

    public function start() {

		$this->chat = new chat_class();

		$pidfile = $this->config['pidfile'];
		$offfile = $this->config['offfile'];

		$sslphp = $this->config['sslphp'];

		$pemcrtfile = $this->config['pemcrtfile'];
		$pemkeyfile = $this->config['pemkeyfile'];

		$pemfile = $this->config['pemfile'];

		$this->starttime = round(microtime(true),2);

		file_put_contents($pidfile, getmypid());//СОХРАНЯЕМ PID в файле

		ws::consolemsg("getmypid() = ".getmypid()); 

		if($sslphp){ //Запускаем WSS c SSL-шифрованием на PHP используя сертификат HTTPS

			ws::consolemsg("WebsocketServer start() certificate pem file (".$pemfile.") creation...");

			// выборка файлов и получение их содержимого	
			$pem_file_content = '';
			$pem_file_content .= file_get_contents($pemcrtfile)."\r\n";
			$pem_file_content .= file_get_contents($pemkeyfile)."\r\n";

			// сохранение полученной информации в файл
			file_put_contents($pemfile, $pem_file_content, LOCK_EX);

			$context = stream_context_create();
			stream_context_set_option($context, 'ssl', 'local_cert', $pemfile);
			stream_context_set_option($context, 'ssl', 'passphrase', '');
			stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
			//stream_context_set_option($context, 'ssl', 'chipers', 'ALL');
			stream_context_set_option($context, 'ssl', 'verify_peer', false);

			ws::consolemsg("WebsocketServer start() stream_socket_server(ssl://".$this->config['host'].":".$this->config['port'].")...");

			$this->server = stream_socket_server("ssl://".$this->config['host'].":".$this->config['port'], $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);

		}else{//Запускаем WS без SSL-шифрования на стороне PHP (для WSS нужен используя прокси)

			ws::consolemsg("WebsocketServer start() stream_socket_server(tcp://".$this->config['host'].":".$this->config['port'].")...");

			$this->server = stream_socket_server("tcp://".$this->config['host'].":".$this->config['port'], $errno, $errstr);

		}

		if (!$this->server) { //Если сокеты не работают
			ws::consolemsg("WebsocketServer start() ERROR socket unavailable " .$errstr. "(" .$errno. ")");
			unlink($pidfile);
			ws::consolemsg("pidfile ".$pidfile." ulinked");
			ws::consoleend();
			die($errstr. "(" .$errno. ")\n");
		}

		$msgtosend = "";


        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////MAIN CYCLE/////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		while (true) {
			ws::consolemsg("WebsocketServer start() while(true)");

			//формируем массив прослушиваемых сокетов:
			$read = $this->connects;
			$read[]= $this->server;
			$write = $except = null;

			if (!stream_select($read, $write, $except, null)) {//ожидаем сокеты доступные для чтения (без таймаута)
				break;
			}

			if (in_array($this->server, $read)) {//есть новое соединение то обязательно делаем handshake
				//принимаем новое соединение и производим рукопожатие:
				if (($connect = stream_socket_accept($this->server, -1)) && $info = $this->handshake($connect)) {

					if(!isset($this->ips[$info['ip']])){
						$this->ips[$info['ip']] = 1; // Одно подключение
					} else {
						$this->ips[$info['ip']]++;
						if($this->ips[$info['ip']]>$this->config['max_connects_from_ip']){
							ws::consolemsg("WebsocketServer too much connections from ip (".$info['ip'].")... reject OK"); 
							continue;
						}
					}
					ws::consolemsg("WebsocketServer new connection... this->ips=".ws::test_var_value($this->ips));  

					$this->connects[] = $connect;//добавляем его в список необходимых для обработки

					$info['id'] = $this->id++;
					if($this->id > 10000) $this->id = 1; 

					$this->online ++;

					$this->users[] = $info;

					ws::consolemsg("WebsocketServer new connection... info=".ws::test_var_value($info)." OK");      

					$this->onOpen($connect, $info);//вызываем пользовательский сценарий
				}
				unset($read[ array_search($this->server, $read) ]);
			}

			foreach($read as $connect) {//обрабатываем все соединения
				$data = fread($connect, 100000);

				if (!$data) { //соединение было закрыто

					$uid = array_search($connect, $this->connects);//определяем uid закрытого соединения

					if($this->ips[$this->users[$uid]['ip']]==1) unset($this->ips[$this->users[$uid]['ip']]); //Удаляем IP адрес из списка коннектов
					else $this->ips[$this->users[$uid]['ip']]--;

					$this->online --;

					unset($this->users[ array_search($connect, $this->connects) ]); //Удаляем информацию о пользователе соединения
					unset($this->connects[ array_search($connect, $this->connects) ]); //Удаляем ресурс подключения

					fclose($connect);//Закрываем соединение

                    $arraytosend = $this->chat->wsmsg("{\"act\":\"end\"}", $uid, $this->online, $this->users[$uid]['ip'].":".$this->users[$uid]['port']);//Отправляем серверу сообщение о выходе игрока

                    foreach($this->connects as $connect){ //обрабатываем все соединения
                        foreach($arraytosend as $uid => $msg){//обрабатываем все сообщения
                            if($uid == array_search($connect, $this->connects)){//Если нам есть что отправить пользователю с uid
                                fwrite($connect, $this->encode($msg));//echo функция ответа
                            }
                        }
                    }

					$this->onClose($connect);//вызываем пользовательский сценарий
					ws::consolemsg("WebsocketServer connection closed");    
					continue;
				}

				$this->onMessage($connect, $data);//вызываем пользовательский сценарий
			}

			if(file_exists($offfile)){   //Если встретили offile то завершаем процесс
				ws::consolemsg("off file found"); 
				ws::consolemsg("time = ".(round(microtime(true),2) - $this->starttime)); 
				fclose($this->server);
				ws::consolemsg("socket - closed");	
				unlink($pidfile);
				ws::consolemsg("pidfile ".$pidfile." unlinked");
					
				if(!unlink($offfile)) {
					ws::consolemsg("ERROR DELETING OFF FILE".$offfile);
					//не могу уничтожить pid-файл. ошибка
					exit(-1);
				}

				ws::consolemsg("offfile ".$offfile." unlinked");
				ws::consoleend();
				exit();		
			}
		}
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////MAIN CYCLE/////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

	}


	//--------------------------------------------------------------------------------------------------------------

	private function handshake($connect) { //Функция рукопожатия
		$info = array();

		$line = fgets($connect);
		$header = explode(' ', $line);
		$info['method'] = $header[0];
		$info['uri'] = $header[1];

		//считываем заголовки из соединения
		while ($line = rtrim(fgets($connect))) {
			if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
				$info[$matches[1]] = $matches[2];
			} else {
				break;
			}
		}

		$address = explode(':', stream_socket_get_name($connect, true)); //получаем адрес клиента
		$info['ip'] = $address[0];
		$info['port'] = $address[1];

		if (empty($info['Sec-WebSocket-Key'])) {
			return false;
		}

		//отправляем заголовок согласно протоколу вебсокета
		$SecWebSocketAccept = base64_encode(pack('H*', sha1($info['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		$upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
			"Upgrade: websocket\r\n" .
			"Connection: Upgrade\r\n" .
			"Sec-WebSocket-Accept:".$SecWebSocketAccept."\r\n\r\n";
		fwrite($connect, $upgrade);

		return $info;
	}

	//--------------------------------------------------------------------------------------------------------------

	private function encode($payload, $type = 'text', $masked = false) {
		$frameHead = array();
		$payloadLength = strlen($payload);

		switch ($type) {
			case 'text':
				// first byte indicates FIN, Text-Frame (10000001):
				$frameHead[0] = 129;
				break;

			case 'close':
				// first byte indicates FIN, Close Frame(10001000):
				$frameHead[0] = 136;
				break;

			case 'ping':
				// first byte indicates FIN, Ping frame (10001001):
				$frameHead[0] = 137;
				break;

			case 'pong':
				// first byte indicates FIN, Pong frame (10001010):
				$frameHead[0] = 138;
				break;
		}

		// set mask and payload length (using 1, 3 or 9 bytes)
		if ($payloadLength > 65535) {
			$payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
			$frameHead[1] = ($masked === true) ? 255 : 127;
			for ($i = 0; $i < 8; $i++) {
				$frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
			}
			// most significant bit MUST be 0
			if ($frameHead[2] > 127) {
				return array('type' => '', 'payload' => '', 'error' => 'frame too large (1004)');
			}
		} elseif ($payloadLength > 125) {
			$payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
			$frameHead[1] = ($masked === true) ? 254 : 126;
			$frameHead[2] = bindec($payloadLengthBin[0]);
			$frameHead[3] = bindec($payloadLengthBin[1]);
		} else {
			$frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
		}

		// convert frame-head to string:
		foreach (array_keys($frameHead) as $i) {
			$frameHead[$i] = chr($frameHead[$i]);
		}
		if ($masked === true) {
			// generate a random mask:
			$mask = array();
			for ($i = 0; $i < 4; $i++) {
				$mask[$i] = chr(rand(0, 255));
			}

			$frameHead = array_merge($frameHead, $mask);
		}
		$frame = implode('', $frameHead);

		// append payload to frame:
		for ($i = 0; $i < $payloadLength; $i++) {
			$frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
		}

		return $frame;
	}

	//--------------------------------------------------------------------------------------------------------------

	private function decode($data){
		$unmaskedPayload = '';
		$decodedData = array();

		// estimate frame type:
		$firstByteBinary = sprintf('%08b', ord($data[0]));
		$secondByteBinary = sprintf('%08b', ord($data[1]));
		$opcode = bindec(substr($firstByteBinary, 4, 4));
		$isMasked = ($secondByteBinary[0] == '1') ? true : false;
		$payloadLength = ord($data[1]) & 127;

		// unmasked frame is received:
		if (!$isMasked) {
			return array('type' => '', 'payload' => '', 'error' => 'protocol error (1002)');
		}

		switch ($opcode) {
			// text frame:
			case 1:
				$decodedData['type'] = 'text';
				break;

			case 2:
				$decodedData['type'] = 'binary';
				break;

			// connection close frame:
			case 8:
				$decodedData['type'] = 'close';
				break;

			// ping frame:
			case 9:
				$decodedData['type'] = 'ping';
				break;

			// pong frame:
			case 10:
				$decodedData['type'] = 'pong';
				break;

			default:
				return array('type' => '', 'payload' => '', 'error' => 'unknown opcode (1003)');
		}

		if ($payloadLength === 126) {
			$mask = substr($data, 4, 4);
			$payloadOffset = 8;
			$dataLength = bindec(sprintf('%08b', ord($data[2])) . sprintf('%08b', ord($data[3]))) + $payloadOffset;
		} elseif ($payloadLength === 127) {
			$mask = substr($data, 10, 4);
			$payloadOffset = 14;
			$tmp = '';
			for ($i = 0; $i < 8; $i++) {
				$tmp .= sprintf('%08b', ord($data[$i + 2]));
			}
			$dataLength = bindec($tmp) + $payloadOffset;
			unset($tmp);
		} else {
			$mask = substr($data, 2, 4);
			$payloadOffset = 6;
			$dataLength = $payloadLength + $payloadOffset;
		}

		/**
		 * We have to check for large frames here. socket_recv cuts at 1024 bytes
		 * so if websocket-frame is > 1024 bytes we have to wait until whole
		 * data is transferd.
		 */
		if (strlen($data) < $dataLength) {
			return false;
		}

		if ($isMasked) {
			for ($i = $payloadOffset; $i < $dataLength; $i++) {
				$j = $i - $payloadOffset;
				if (isset($data[$i])) {
					$unmaskedPayload .= $data[$i] ^ $mask[$j % 4];
				}
			}
			$decodedData['payload'] = $unmaskedPayload;
		} else {
			$payloadOffset = $payloadOffset - 4;
			$decodedData['payload'] = substr($data, $payloadOffset);
		}

		return $decodedData;
	}

	//пользовательские сценарии:

	protected function onOpen($connect, $info) {
		$uid = array_search($connect, $this->connects);

		//fwrite($connect, $this->encode("chat-name:<b style=\"color:".$this->users[$uid]['color']."\">".$this->users[$uid]['name']."</b>"));//echo функция ответа

		//fwrite($connect, $this->encode("chat-users:".$this->online));//обновляем количество пользователей он-лайн

		//$msgtosend = 	"<b style=\"color:".$this->users[$uid]['color']."\">".$this->users[$uid]['name']." вошел в чат</b>";
		//chatlogmsg("(".$this->users[$uid]['ip'].":".$this->users[$uid]['port'].")".$msgtosend);

		//foreach($this->connects as $connect){ //обрабатываем все соединения
		//	fwrite($connect, $this->encode($msgtosend));//echo функция ответа
		//	fwrite($connect, $this->encode("chat-users:".$this->online));//обновляем количество пользователей он-лайн
		//}

		//ws::consolemsg("open OK"); 
		//fwrite($connect, encode('Привет, мы соеденены'));
	}

	protected function onClose($connect) {
		//ws::consolemsg("close OK");
	}

	protected function onMessage($connect, $data) {	



		$uid = array_search($connect, $this->connects);


        /*
        TODO проверка о том сколько времени прошло с моента последнего запроса. Идеально сделать не больше 50 запросов за 30 секунд
        хранить время последнего запроса для каждого пользователя

        if(round(microtime(true)-$this->player->lasttime,2) < TIME_BETWEEN_REQUESTS) { //Если с момента последнего запроса прошло меньше чем пол секунды
            $this->player->possibleways($this->map);

            $this->communicator= new communicator_class();
            $this->communicator->reject($this);
            return true;
        }
        */

        $timestart = microtime(true);

		$f = $this->decode($data); 
		
		if($f['payload'] == "" || $f['payload'] == " ") return;

		//$msgtosend = 	"[".date("H:i")."] <b style=\"color:".$this->users[$uid]['color']."\">".$this->users[$uid]['name'].":</b> ".htmlspecialchars($f['payload']);

		$arraytosend = $this->chat->wsmsg($f['payload'], $uid, $this->online, $this->users[$uid]['ip'].":".$this->users[$uid]['port']);

        foreach($this->connects as $connect){ //обрабатываем все соединения
            foreach($arraytosend as $uid => $msg){//обрабатываем все сообщения
                if($uid == array_search($connect, $this->connects)){//Если нам есть что отправить пользователю с uid
			        fwrite($connect, $this->encode($msg));//echo функция ответа
			    }
			}
	    }


	    ws::consolemsg("time of process:".round(microtime(true) - $timestart,4));

        //fwrite($connect, $this->encode($msgtosend));//отправить ответ пользователю

		//chatlogmsg("(".$this->users[$uid]['ip'].":".$this->users[$uid]['port'].")".$msgtosend);

		//ws::consolemsg("connect = ".ws::test_var_value($connect));
		//ws::consolemsg("f = ".ws::test_var_value($f));

	}

}

