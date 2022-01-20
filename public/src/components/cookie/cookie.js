import './cookie.scss'
import {$} from "../../common";




check_cookie('cn')

function check_cookie(cookie_name) {
    if (getCookie(cookie_name))
        $('#cookie-notice').css('bottom','-100%');
    else
        $('#cookie-notice').css('bottom', "0");
}

function getCookie(cookie_name) {
    return document.cookie.match('(^|;)?' + cookie_name + '=([^;]*)')
}





$('#cn-accept-cookie').on('click', clicked)

function clicked() {
    setCookie()
    $('#cookie-notice').css('bottom', '-100%');
}

function setCookie() {
    const date = new Date(),
        minute = 60 * 1000,
        day = minute * 60 * 24;

    let days = 3;
    date.setTime(date.getTime() + (days * day))
    document.cookie = "cn=1; expires=" + date + "path=/; SameSite=lax";
}