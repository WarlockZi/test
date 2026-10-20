import { createElement } from "@src/common.js";
import {
  forgotAction,
  handleYandexClick,
  login,
  registerAction,
} from "@src/Auth/authForms/logic.js";

export function createButton(text) {
  return new createElement()
    .tag("button")
    .attr("type", "submit")
    .attr("class", "button")
    .attr("id", "forgot")
    .text(text)
    .get();
}
export function getForgotButton() {
  const forgotPassword = createButton("Забыл пароль");
  forgotPassword.addEventListener("click", forgotAction.bind(this));
  return forgotPassword;
}
export function getLoginButton() {
  const loginButton = createButton("Войти");
  loginButton.addEventListener("click", login.bind(this));
  return loginButton;
}
export function getYandexAuthButton() {
  const yaButton = new createElement()
    .tag("button")
    .attr("class", "yandex")
    .attr("title", "Авторизация Яндекс")
    .get();
  yaButton.addEventListener("click", handleYandexClick);
  return yaButton;
}
export function getRegisterButton() {
  const registerButton = createButton("Регистрация");
  registerButton.addEventListener("click", registerAction.bind(this));
  return registerButton;
}
