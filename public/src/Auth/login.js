import './login.scss'
import {$, post, validate} from "../common";

let loginForm = $("[data-auth='login']")[0]
if (loginForm) {
  $(loginForm).on('click', sendData.bind(this))
}

let email = $('input[type = email]')[0]
let pass = $('input[name= password]')[0]
let msg = $('.message')[0]

function sendData({target}) {
  if (target.classList.contains('submit__button')) {
    if (validateData()) parseLoginResponse()
  }
}


function validateData() {
  let error = validate.email(email.value)
  if (error) {
    msg.innerText = msg.innerText + error
    $(msg).addClass('error')
    return false
  }
  let su = process.env.SU_EMAIL === email.value
  if (!su) {
    error = validate.password(pass.value)
    if (error) {
      msg.innerText = msg.innerText + error
      $(msg).addClass('error')
      return false
    }
  }
  return true

}


async function parseLoginResponse() {

  let data = {
    "email": email.value,
    "password": pass.value,
  }

  let res = await post('/auth/login', data)
  res = JSON.parse(res)


  if (res.msg === 'Не верный email или пароль') {
    msg.innerHTML = res.msg
    $(msg).addClass('error')
    $(msg).removeClass('success')
  } else if (res.msg === 'Пользователь не зарегистрирован') {
    msg.innerHTML = "email не зарегистрирован <br> Для регистрации перейдите в раздел <a href = '/auth/register'>Регистрация</a>"
    $(msg).addClass('error')
    $(msg).removeClass('success')
  } else if (res.msg === 'Зайдите на почту чтобы подтвердить регистрацию') {
    msg.innerHTML = res.msg
    $(msg).addClass('error')
    $(msg).removeClass('success')
  } else if (res.role === 'employee') {
    window.location = '/adminsc'
  } else if (res.role === 'user') {
    window.location = '/auth/cabinet'
  } else {
    msg.innerText = res.msg
    $(msg).addClass('error')
    $(msg).removeClass('success')
  }
}
