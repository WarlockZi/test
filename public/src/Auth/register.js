import { $, post, trimStr, validate } from "../common";

let registerForm = $("[data-auth='register']")[0];
if (registerForm) {
  $(registerForm).on("click", sendData);
}

function sendData({ target }) {
  parseRegisterResponse(email, password);
}

async function parseRegisterResponse(email, password) {
  const msg = $(".message")[0];
  const data = {
    email,
    password,
    surName: $("[name='surName']")[0].value,
    name: $("[name='name']")[0].value,
  };
  // debugger

  const res = await post("/auth/register", data);

  if (res?.arr?.success === "confirm") {
    msg.classList.remove("error");
    msg.classList.add("success");
    msg.innerHTML =
      "-Пользователь зарегистрирован.<br>" +
      "-Для подтверждения регистрации зайдите на почту, " +
      "<bold>email</bold>.<br> " +
      "-Перейдите по ссылке в письме.";
  } else if (res.msg === "mail exists") {
    msg.innerHTML =
      "Эта почта уже зарегистрирована. Войдите в систему по кнопке внизу Войти или, если не помните пароль, восстановите пароль по кнопке Забыл пароль";
    msg.classList.remove("success");
    msg.classList.add("error");
  } else {
    msg.innerHTML = res.msg;
    msg.classList.remove("success");
    msg.classList.add("error");
  }
}
