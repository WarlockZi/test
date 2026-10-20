import { emailValidator, passwordValidator, post } from "@src/common.js";

import { sanitizeInput } from "@src/common.js";
import { qs } from "@src/constants.js";

export async function handleYandexClick() {
  window.location.href = "/auth/yandex";
}

export async function login(e) {
  window.YM("click_on_login");
  const dto = authDTO(e),
    content = e.target.closest(".content"),
    res = await post("/auth/login", dto);

  if (res?.error) {
    content.innerHTML = res?.error;
    return;
  }

  content.innerHTML = "Вход выполнен";

  const id = res.id ?? null;

  if (["employee", "admin"].includes(res?.role)) {
    window.location = window.location.pathname;
  } else if (res?.role === "guest") {
    window.location = window.location.pathname;
  }
}

export function onInputEmail({ target }) {
  const container = target.closest(".input-container");
  const email = target.value;
  const errors = emailValidator(email);
  container.querySelector("#emailError").innerText = errors.length
    ? errors[0]
    : "";
  container.querySelector("label").style.color = errors.length
    ? "#dc2f55"
    : "#2fdcdb";
  target.style.outline = errors.length
    ? "solid 1px #dc2f55"
    : "solid 1px #2fdcdb";
}
export function onInputPassword({ target }) {
  const container = target.closest(".input-container");
  const pass = target.value;
  const errors = passwordValidator(pass);
  container.querySelector("#emailError").innerText = errors.length
    ? errors[0]
    : "";
  container.querySelector("label").style.color = errors.length
    ? "#dc2f55"
    : "#2fdcdb";
  target.style.outline = errors.length
    ? "solid 1px #dc2f55"
    : "solid 1px #2fdcdb";
}
export function switchBoxes({ target }) {
  const event = new Event("modal.switch", { bubbles: true });
  target.dispatchEvent(event);
}

export async function registerAction(e) {
  window.YM("click_on_register");
  const res = await post("/auth/register", this.authDTO(e));
  const content = e.target.closest(".content");
  if (res?.success) {
    content.innerHTML =
      "<p>-Пользователь зарегистрирован.</p>" +
      "<p>-Для подтверждения регистрации зайдите на почту, </p>" +
      "<p><bold>email.</bold></p>" +
      "<p>-Перейдите по ссылке в письме.</p>";
  } else if (res?.error === "mail exists") {
    content.innerHTML =
      "Эта почта уже зарегистрирована. Войдите в систему по кнопке внизу Войти или, если не помните пароль, восстановите пароль по кнопке Забыл пароль";
  } else {
    content.innerHTML = res?.error ?? "Неизвестная ошибка";
  }
}

export async function forgotAction(e) {
  const dto = authDTO(e);
  const res = await post("/auth/returnpass", dto);
  if (res?.success) {
    const content = e.target.closest(".content");
    content.innerHTML = res?.message;
  }
}
function authDTO(e) {
  e.preventDefault();
  const form = e.target.closest(".box");
  const email = sanitizeInput(form[qs]("input#email")?.value) ?? null;
  const password = sanitizeInput(form[qs]("input#password")?.value) ?? null;
  return { email, password };
}
