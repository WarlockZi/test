//ws chat by Petukhovsky.com

"use strict"; //All my JavaScript written in Strict Mode http://ecma262-5.com/ELS5_HTML.htm#Annex_C

(function () {
	// ======== global vars from config ========   
	var srvaddress = 'http://localhost/chat/';//url каталога
	var startserveraddress = srvaddress+'ws/wsstart.php';
	var chataddr = 'ws://localhost:8889';
	var askservertostart = true;


    // ======== private vars ========
	var socket;
	var xhttp;

    ////////////////////////////////////////////////////////////////////////////
    var init = function () {

		if (askservertostart) wsserverrun();
		
		socket = new WebSocket(chataddr);

		socket.onopen = connectionOpen; 
		socket.onmessage = messageReceived; 
		//socket.onerror = errorOccurred; 
		//socket.onopen = connectionClosed;

		document.onkeydown = function(e) {
			var evt = e || event; // w3c dom or IE dom
			switch( evt.keyCode ) {
				case 13: //Enter
					messagesend();
				break;
			}
			//console.log("key="+evt.keyCode);
		}; 

        document.getElementById("msg-send").onclick = function () {
			messagesend();
        };

    };

	function messagesend() {
        //socket.send("Connection with \""+document.getElementById("sock-addr").value+"\" Подключение установлено обоюдно, отлично!");
        if(document.getElementById("chat-msg").value!==""){
            //socket.send("{\"act\":\"msg\", \"msg\":\""+htmlspecialchars(document.getElementById("chat-msg").value)+"\"}" );
            socket.send("{\"act\":\"msg\", \"msg\":\""+encodeURIComponent(document.getElementById("chat-msg").value)+"\"}" );
        }
        document.getElementById("chat-msg").value = "";
	}

	function connectionOpen() {
		//TODO - защиту от кавычек 
		socket.send("{\"act\":\"start\", \"msg\":\"Connection with "+chataddr+". Подключение установлено обоюдно, отлично!\"}");
        //document.getElementById("ws-chat").innerHTML += "Вы подключены к чату и вы можете писать<br />";
	}

	function messageReceived(e) {
        console.log("msg receive:"+e.data);
		var json = eval("(" + e.data + ")");
		if(typeof(json.chatname)!=='undefined'){
			document.getElementById("chat-name").innerHTML = json.chatname;
		}

		if(typeof(json.chatusers)!=='undefined'){
			document.getElementById("chat-users").innerHTML = json.chatusers;
		}

        if(typeof(json.msg)!=='undefined'){
            document.getElementById("ws-chat").innerHTML += (json.msg+"<br />");
        }

		document.getElementById("ws-chat").scrollTop = document.getElementById("ws-chat").scrollHeight;
	}

    function connectionClose() {
        socket.close();
        //document.getElementById("sock-info").innerHTML += "Соединение закрыто <br />";
    }

    var wsserverrun = function() {

        xhttp = new XMLHttpRequest();
        xhttp.open('GET',startserveraddress,true);
        xhttp.send();
        xhttp.onreadystatechange=function(){
            if (xhttp.readyState==4){
				//Принятое содержимое файла должно быть опубликовано
				console.log(xhttp.responseText);
                 //Принятое содержимое json файла должно быть вначале обработано функцией eval
				var json=eval( '('+xhttp.responseText+')' ); 

				if (json.run == 1) return;
				else if (json.run == 2){sleep(500); return;}
			}
        }
    };

    var htmlspecialchars = function(html) {
        // Сначала необходимо заменить &
        html = html.replace(/&/g, "&amp;");
        // А затем всё остальное в любой последовательности
        html = html.replace(/</g, "&lt;");
        html = html.replace(/>/g, "&gt;");
        html = html.replace(/"/g, "&quot;");
        // Возвращаем полученное значение
        return html;
    };


	function sleep(ms) {
		ms += new Date().getTime();
		while (new Date().getTime() < ms){}
	};
    
	return {
        ////////////////////////////////////////////////////////////////////////////
        // ---- onload event ----
        load : function () {
            window.addEventListener('load', function () {
                init();
            }, false);
        }
    }
})().load();