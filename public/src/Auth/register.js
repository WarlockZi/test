import {post, $, validate} from '../common'

let registerForm = $("[data-auth='register']")[0]
if (registerForm) {
  $(registerForm).on('click', sendData.bind(this))
}

let email = $('input[type = email]')[0]
let password = $('input[name = password]')[0]
let msg = $(".message")[0];

function sendData() {
  if (validateData()) parseRegisterResponse()
}

function validateData() {
  let error = validate.email(email.value)
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  error = validate.password(pass.value)
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  return true
}

async function parseRegisterResponse()
{
  let data = {
    "email": email.value,
    "password": password.value,
    "surName": $("[name='surName']")[0].value,
    "name": $("[name='name']")[0].value,
  }

  let res = await post('/auth/register', data)

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

  } else {
    msg[0].innerHTML = res
    msg.removeClass('success')
    msg.addClass('error')
  }

}





