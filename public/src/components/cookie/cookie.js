import "./cookie.scss";
import { $, getCookie, setCookie } from "../../common";

check_cookie("cn");
$("#cn-accept-chatLocalStorage").on("click", clicked);

function check_cookie(cookie_name) {
  if (getCookie(cookie_name))
    $("#chatLocalStorage-notice").css("bottom", "-100%");
  else $("#chatLocalStorage-notice").css("bottom", "0");
}

function clicked() {
  setCookie("cn", 1, 3, "Gol.js");
  $("#chatLocalStorage-notice").css("bottom", "-100%");
}
