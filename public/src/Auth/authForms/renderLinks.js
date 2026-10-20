import { createElement } from "@src/common.js";
import { switchBoxes } from "@src/Auth/authForms/logic.js";

export function getLoginWarning() {
  return new createElement()
    .tag("p")
    .text(
      "Оставляя свои данные, вы соглашаетесь с политикой конфиденциальности",
    )
    .get();
}

export function getForgotLink() {
  const forgotPassword = createLink("Забыл пароль", 3);
  forgotPassword.addEventListener("click", switchBoxes.bind(this));
  return forgotPassword;
}
export function createLink(text, dataTarget) {
  return new createElement()
    .tag("div")
    .attr("class", "link")
    .attr("data-target", dataTarget)
    .text(text)
    .get();
}
export function getRegisterLink() {
  const registerButton = createLink("Регистрация", 2);
  registerButton.addEventListener("click", switchBoxes.bind(this));
  return registerButton;
}
export function getLoginLink() {
  const loginButton = createLink("Войти", 1);
  loginButton.addEventListener("click", switchBoxes.bind(this));
  return loginButton;
}

export function createLinks(type) {
  const wrap = new createElement().tag("div").attr("class", "row").get();
  if (type === "register") {
    wrap.appendChild(getLoginLink());
    wrap.appendChild(getForgotLink());
  } else if (type === "login") {
    wrap.appendChild(getRegisterLink());
    wrap.appendChild(getForgotLink());
  } else if (type === "forgot") {
    wrap.appendChild(getLoginLink());
    wrap.appendChild(getRegisterLink());
  }
  return wrap;
}
