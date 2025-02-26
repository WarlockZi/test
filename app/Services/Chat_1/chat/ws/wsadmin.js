// =============================================================
// script written by Petukhovsky - 2014.06.16
// http://petukhovsky.com
// =============================================================

"use strict"; //All my JavaScript written in Strict Mode http://ecma262-5.com/ELS5_HTML.htm#Annex_C

(function () {
	// ======== global vars from config ========   
	var srvaddress = 'https://localhost/chat/ws/';//url каталога
	var adminaddress = srvaddress+'wsadmin.php?';
	var logfile = 'https://localhost/chat/log/wslog.html?';
	var errorfile = 'https://localhost/chat/log/wserrors.txt?';



	// ======== private vars ========


	var xhttp, xhttplog, xhttperror, xhttpauth;

    ////////////////////////////////////////////////////////////////////////////
    var init = function () {

		if(document.getElementById('ws-status-refresh')==null) {

			document.getElementById('gologin').onclick = function () { //При нажатии на кнопку login

				//Отправка POST данных на сервер и если всё OK перезагружка страницы
				document.getElementById('gologin').disabled = true;
				xhttpauth = new XMLHttpRequest();
				xhttpauth.open('POST',adminaddress,true);
				xhttpauth.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

				var params = 'login=' + encodeURIComponent(document.getElementById("login").value) +
				'&pass=' + encodeURIComponent(document.getElementById("pass").value);

				xhttpauth.send(params);
				xhttpauth.onreadystatechange=function(){
					if (xhttpauth.readyState==4){
						 //Принятое содержимое json файла должно быть вначале обработано функцией eval
						var json=eval( '('+xhttpauth.responseText+')' ); 

						if (json.msg==1){ //Если авторизация успешна, перезагружаем страницу. 
							location.reload();
						} else {
							//иначе месседж 
							document.getElementById('loginmsg').innerHTML = 'Bad login/pass, try again';
						}
						document.getElementById('gologin').disabled = false;
					}
				}
			}; 			

			return; //Если мы в режиме ввода логина/пароля, завершаем инициализацию
		}


		loaddataloop();

		document.getElementById('ws-start').onclick = function () {
			loaddata('act=start');
		}; 

		document.getElementById('ws-stop').onclick = function () {
			loaddata('act=stop');
		}; 

		document.getElementById('ws-status-refresh').onclick = function () {
			loaddata('act=status');
		}; 

		document.getElementById('ws-logfile-refresh').onclick = function () {
			load_log();
		}; 

		document.getElementById('ws-logfile-clear').onclick = function () {
			clear_log();
		}; 

		document.getElementById('ws-errorfile-refresh').onclick = function () {
			load_errors();
		}; 

		document.getElementById('ws-errorfile-clear').onclick = function () {
			clear_errors();
		}; 


		document.getElementById('ws-exit').onclick = function () {
			loaddata('act=exit');
		}; 

    };

    //////////////////////////////DATAEXCHANGE/////////////////////////////////////
    var loaddata = function(act) {
		if(document.getElementById('ws-status-refresh')==null) return; //Если в режиме авторизации - не обрабатываем
		
		document.getElementById('ws-status-refresh').disabled = true;
		document.getElementById('ws-start').disabled = true;
		document.getElementById('ws-stop').disabled = true;

        xhttp = new XMLHttpRequest();
        xhttp.open('GET',adminaddress+act,true);
        xhttp.send();
        xhttp.onreadystatechange=function(){
            if (xhttp.readyState==4){
				//Принятое содержимое файла должно быть опубликовано
				console.log(xhttp.responseText);
                 //Принятое содержимое json файла должно быть вначале обработано функцией eval
				var json=eval( '('+xhttp.responseText+')' ); 

				if(json.msg==-1) location.reload(); //Если пришел сигнал о том, что пользователь не авторизован, перезагружаем страницу
				document.getElementById('ws-status').style.color = json.color;
				document.getElementById('ws-status').innerHTML = json.msg;
				document.getElementById('ws-status-refresh').disabled = false;
				document.getElementById('ws-start').disabled = false;
				document.getElementById('ws-stop').disabled = false;

			}
        }
    };


    var load_log = function() {
		if(document.getElementById('ws-status-refresh')==null) return; //Если в режиме авторизации - не обрабатываем

		document.getElementById('ws-logfile-refresh').disabled = true;
        xhttplog = new XMLHttpRequest();
        xhttplog.open('GET',logfile+Math.random(),true); //Добавляем случайное число, чтобы избежать проблем с кешированием
        xhttplog.send();
        xhttplog.onreadystatechange=function(){
            if (xhttplog.readyState==4){
                //Принятое содержимое файла должно быть опубликовано
                document.getElementById('ws-logfile').innerHTML = xhttplog.responseText;
				document.getElementById("ws-logfile").scrollTop = document.getElementById("ws-logfile").scrollHeight;
				document.getElementById('ws-logfile-refresh').disabled = false;
            }
        }
    };

    var clear_log = function() {
		loaddata('act=clearlog');
        load_log();
    };

    var clear_errors = function() {
		loaddata('act=clearwserrorslogfile');
        load_errors();
    };


    var load_errors = function() {
		if(document.getElementById('ws-status-refresh')==null) return; //Если в режиме авторизации - не обрабатываем

		document.getElementById('ws-errorfile-refresh').disabled = true;
        xhttperror = new XMLHttpRequest();
        xhttperror.open('GET',errorfile+Math.random(),true); //Добавляем случайное число, чтобы избежать проблем с кешированием
        xhttperror.send();
        xhttperror.onreadystatechange=function(){
            if (xhttperror.readyState==4){
                //Принятое содержимое файла должно быть опубликовано
                document.getElementById('ws-errorfile').innerHTML = '<pre>'+xhttperror.responseText+'</pre>';
				document.getElementById("ws-errorfile").scrollTop = document.getElementById("ws-errorfile").scrollHeight;
				document.getElementById('ws-errorfile-refresh').disabled = false;
            }
        }
    };


    //////////////////////////////MAIN LOOP/////////////////////////////////////
    var loaddataloop = function () {
		if(document.getElementById('ws-status-refresh')==null) return; //Если в режиме авторизации - не обрабатываем
		loaddata('act=status');
        load_log();
		load_errors();
        setTimeout(loaddataloop, 30000);
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