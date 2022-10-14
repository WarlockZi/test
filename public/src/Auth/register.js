import {post, $, validate, trimStr} from '../common'

let registerForm = $("[data-auth='register']")[0]
if (registerForm) {
  $(registerForm).on('click', sendData)
}


function sendData({target}) {
  let email = trimStr($('input[type = email]')[0].value)
  let password = trimStr($('input[name = password]')[0].value)

  if (target.classList.contains('submit__button')) {
    if (validateData(email,password))
      parseRegisterResponse(email,password)
  }
}

function validateData(email,password) {


  let error = validate.email(email)
  let msg = $('.message')[0]
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  error = validate.password(password)
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  return true
}

async function parseRegisterResponse(email,password) {
  let msg = $(".message")[0];
  let data = {
    email,
    password,
    "surName": $("[name='surName']")[0].value,
    "name": $("[name='name']")[0].value,
  }

  let res = await post('/auth/register', data)

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





