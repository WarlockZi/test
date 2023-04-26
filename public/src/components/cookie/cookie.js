import './cookie.scss'
import {$, getCookie, setCookie} from "../../common";

check_cookie('cn');
$('#cn-accept-cookie').on('click', clicked);

function check_cookie(cookie_name) {
  if (getCookie(cookie_name))
    $('#cookie-notice').css('bottom', '-100%');
  else
    $('#cookie-notice').css('bottom', "0");
}

function clicked() {
  setCookie('cn', 1, 3, 'd');
  $('#cookie-notice').css('bottom', '-100%');
}

