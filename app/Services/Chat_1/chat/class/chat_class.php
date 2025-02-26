<?php
/*


*/
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
/*
* Класс chat_class
*/
class chat_class{
    public $chater;			//Текущий 
    public $act;            //Action

    //-----------------------------------------------------------------------------------
    /**
    * Конструктор
    *
    */
    function __construct(){

        $this->act = "";
    }

    //-----------------------------------------------------------------------------------
    /**
    * Получение сообщения из websocket
    * $_data - данные
    * $_uid - ID сокет-подключения по логике напоминает сессию
    */
    public function wsmsg($_data, $_uid, $_count, $_addr=""){

        $data = json_decode($_data, true);

        if(isset($data['act'])) $this->act = $data['act'];
        else { //Сюда также будет проваливаться если будет BAD JSON
            chat::logmsg("SERVER:".SERVER_VER. "is OK", $_uid);
            return false;
        }

        //chat::logmsg("client says:".$_data, $_uid);

        //------<ИНИЦИАЛИЗАЦИЯ ИЛИ ЗАГРУЗКА>------------
        if($this->act=='start') { //Если происходит действите старт, инициализируем игру
			$rnd = rand(0, count($GLOBALS['chat']['users'])-1);
            $this->chater['name'] = $GLOBALS['chat']['users'][$rnd]['name'];
            $this->chater['color'] = $GLOBALS['chat']['users'][$rnd]['color'];

			$this->putinsession($_uid);

			$msg = 	"<b style='color:".$this->chater['color']."'>".$this->chater['name']." вошел в чат</b>";
			$chatname = "<b style='color:".$this->chater['color']."'>".$this->chater['name']."</b>";

            $arraytosend = $this->sendall("{msg:\"".$msg."\",chatusers: \"".$_count."\"}", $_addr);
            $arraytosend[$_uid] = "{msg:\"".$msg."\", chatusers:\"".$_count."\", chatname:\"".$chatname."\"}";

            return $arraytosend;
        } else { //Загружаем игровое состояние из сессии
            if(!$this->getfromsession($_uid)) return false;//Если в сессии нет данных об игроке, то выходим. Это может быьт например при переключении сессии при перелогине, старая сессия связи автоматически чистится
        }
        //------</ИНИЦИАЛИЗАЦИЯ ИЛИ ЗАГРУЗКА>------------

        //------<ОБРАБОТКА СООБЩЕНИЙ>------------
        if($this->act=='msg' && isset($data['msg'])){
            $data['msg'] = urldecode($data['msg']);

            $this->putinsession($_uid);

            $msg = "";

			if(substr($data['msg'],0,4)==="/me "){//Выполнение команды me
                $msg = $this->memsgformat(substr($data['msg'],4));
			} elseif(substr($data['msg'],0,5)==="/to \"") {//Выполнение личного сообщения
				$msg = substr($data['msg'],5);
				$to  = substr($msg,0,strpos($msg,"\""));//Выдираем имя
				if (strlen($to)==0) return;//Выбрасываем некорректную команду
    			$msg = substr($msg,strlen($to)+1);
				$msg = $this->pvtmsgformat($to, $msg);
				
				return $this->sendto(array($this->chater['name'], $to), "{msg:\"".$msg."\"}", $_addr);

    		} else {//Обычная отправка
    			$msg = $this->msgformat($data['msg']);
    		}

            return $this->sendall("{msg:\"".$msg."\"}", $_addr);

		}elseif($this->act=='end'){ //Если действите старт не произошло и игра не инициализирована, то выходим
            $msg = 	"<b style='color:".$this->chater['color']."'>".$this->chater['name']." покинул чат</b>";

            $this->clearsession($_uid);//Удаление данных о сессии игрока
            //chat::logmsg("Session close OK", $_uid);

            return $this->sendall("{msg:\"".$msg."\", chatusers:\"".$_count."\"}", $_addr);
        }
        //------</ОБРАБОТКА СООБЩЕНИЙ>------------
    }


	//-----------------------------------------------------------------------------------
	/**
    * Сохранить данные в сессию
    */
    public function putinsession($_uid){
        $GLOBALS['sessions'][$_uid]["chater"] = $this->chater;
    }

	//-----------------------------------------------------------------------------------
	/**
    * Загрузить данные из сессии
    */
    public function getfromsession($_uid){
        if(!isset($GLOBALS['sessions'][$_uid])) return false;//Такая сессия не найдена
        $this->chater = $GLOBALS['sessions'][$_uid]["chater"];
        return true;
    }

	//-----------------------------------------------------------------------------------
	/**
    * clear session
    */
    public function clearsession($_uid){
        unset($GLOBALS['sessions'][$_uid]);
    }

    //-----------------------------------------------------------------------------------
    /**
    * Форматирование сообщения
    */
    public function msgformat($msg){
		$msg = 	"[".date("H:i")."] <b style='color:".$this->chater['color']."'>".$this->chater['name'].":</b> ".addslashes(htmlspecialchars($msg));
        return $msg;
    }

    //-----------------------------------------------------------------------------------
    /**
    * Форматирование сообщения
    */
    public function memsgformat($msg){
		$msg = 	"[".date("H:i")."] <b style='color:".$this->chater['color']."'>".$this->chater['name']." ".addslashes(htmlspecialchars($msg))."</b>";
        return $msg;
    }

    //-----------------------------------------------------------------------------------
    /**
    * Форматирование сообщения
    */
    public function pvtmsgformat($to, $msg){
		$col = "";
		foreach($GLOBALS['sessions'] as $uid => $session){//Ищем цвет среди залогиненых
			if($session["chater"]["name"] === $to){
				$col = $session["chater"]["color"];
				break;
			}
        }
		if(strlen($col)==0) return "[".date("H:i")."] ".$to." отсутствует в чате";
		$msg = 	"[".date("H:i")."] <b style='color:".$this->chater['color']."'>".$this->chater['name']."</b> &gt; <b style='color:".$col."'>".$to.":</b> ".addslashes(htmlspecialchars($msg));
        return $msg;
    }

    //-----------------------------------------------------------------------------------
    /**
    * Подготовка сообщений для рассылки всем
    */
    public function sendall($msg, $addr=""){
		$sendarray = array();

        foreach($GLOBALS['sessions'] as $uid => $session){
			$sendarray[$uid]= $msg;
        }

        chat::logmsg("[".$addr."]".substr($msg,6,-2));

        return $sendarray;
    }

    //-----------------------------------------------------------------------------------
    /**
    * Подготовка сообщений для рассылки по массиву
    */
    public function sendto($arr, $msg, $addr=""){
		$sendarray = array();

        foreach($GLOBALS['sessions'] as $uid => $session){
			if(in_array($session["chater"]["name"], $arr)){
				$sendarray[$uid]= $msg;
			}
        }

        chat::logmsg("[".$addr."]".substr($msg,6,-2));

        return $sendarray;
    }

	//-----------------------------------------------------------------------------------
	/**
    * Деструктор
    */
	function __destruct() {

    }
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------

?>