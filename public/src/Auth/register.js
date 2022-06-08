import {post, $, validate} from '../common'

let registerForm = $("[data-auth='register']")[0]
if (registerForm) {
  $(registerForm).on('click', sendData.bind(this))
}

let email = $('input[type = email]')[0]
let password = $('input[name = password]')[0]
let msg = $(".message")[0];

function sendData({target}) {
  if (target.classList.contains('submit__button')) {
    if (validateData()) parseRegisterResponse()

  }
}

function validateData() {
  let error = validate.email(email.value)
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  error = validate.password(password.value)
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  return true
}

async function parseRegisterResponse() {
  let msg = $('.message')[0]
  let data = {
    "email": email.value,
    "password": password.value,
    "surName": $("[name='surName']")[0].value,
    "name": $("[name='name']")[0].value,
  }

  let res = await post('/auth/register', data)
  res = JSON.parse(res)

  if (res.msg === 'confirmed') {
    msg.classList.remove('error')
    msg.classList.add('success')
    msg.innerHTML =
      '-Пользователь зарегистрирован.<br>' +
      '-Для подтверждения регистрации зайдите на почту, ' +
      '<bold>email</bold>.<br> ' +
      '-Перейдите по ссылке в письме.'
  } else if (res.msg === 'mail exists') {
    msg.innerHTML = 'Эта почта уже зарегистрирована'
    msg.classList.remove('success')
    msg.classList.add('error')

  } else {
    msg.innerHTML = res.msg
    msg.classList.remove('success')
    msg.classList.add('error')
  }

}





