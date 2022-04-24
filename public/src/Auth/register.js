import {post, $, validate} from '../common'

$(".forgot").on("click", async function () {
    window.location.href = '/auth/returnpass'
  }
)
$(".login").on("click", async function () {
    window.location.href = '/auth/login'
  }
)

$(".reg").on("click", async function () {

    let email = $('input[type = email]')[0].value
    let password = $('input[name = password]')[0].value
    let msg = $(".message")[0];
    if (!email || !password) {
      msg.innerText = "Заполните email и пароль"
      $(msg).addClass('error')
      return false
    }
    if (email) {
      if (!validate.email(email)) {
        msg.innerText = "Неправильный формат почты"
        $(msg).addClass('error')
        return false
      }
      if (password) {
        if (!validate.password(password)) {
          msg.innerText = "Пароль может состоять из \n " +
            "- больших латинских букв \n" +
            "- маленьких латинских букв \n" +
            "- цифр \n" +
            "- должен содержать не менее 6 символов"

          $(msg).addClass('error')
          return false
        }
      }
      let data = getData(email,password)
      let res = await send(data)
    }
  }
)


function getData(email,password) {
 return  {
    "email": email,
    "password": password,
    "surName": $("[name='surName']")[0].value,
    "name": $("[name='name']")[0].value,
    // "token": $('meta[name="token"]')[0].getAttribute('content'),
  }
}
async function send(data) {

  let res = await post('/auth/register', data)
  let msg = $('.message')

  if (res === 'confirm') {
    msg.removeClass('error')
    msg.addClass('success')
    msg[0].innerHTML =
      '-Пользователь зарегистрирован.<br>' +
      '-Для подтверждения регистрации зайдите на почту, ' +
      '<bold>email</bold>.<br> ' +
      '-Перейдите по ссылке в письме.'
  } else if (res === 'mail exists') {
    msg[0].innerHTML = 'Эта почта уже зарегистрирована'
    msg.removeClass('success')
    msg.addClass('error')
  } else if (res === 'empty password') {
    msg[0].innerHTML = 'Зполните пароль'
    msg.removeClass('success')
    msg.addClass('error')

  } else {
    msg[0].innerHTML = res
    msg.removeClass('success')
    msg.addClass('error')
  }
}



