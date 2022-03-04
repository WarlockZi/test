import './login.scss'
import {$, post, validate} from "../common";

$('.password-control').on('click', viewPassword)

function viewPassword(event) {
  let input = event.target.parentNode.querySelector('input')
  if (input.getAttribute('type') == 'password') {
    input.setAttribute('type', 'text');
  } else {
    input.setAttribute('type', 'password');
  }
  event.target.classList.toggle('view')
}

$("#login").on('click', sendData)

function sendData(e) {
  e.preventDefault();
  let email = $('input[type = email]').el[0].value
  let pass = $('input[name= password]').el[0].value
  if (validateEmailLogin(email, pass)) send(email, pass)
}


function validateEmailLogin(email, pass) {
  let $message = $(".message").el[0];

  if (!validate.email(email)) {
    $message.innerText = "Неправильный формат почты"
    $($message).addClass('error')
    return false
  }
  if (!validate.password(pass)) {
    $message.innerText = "Пароль может состоять из \n " +
      "- Большие латинские бкувы \n" +
      "- Маленькие латинские буквы \n" +
      "- Цифры \n" +
      "- Должен содержать не менее 6 символов"

    $($result).addClass('error')
    return false
  }
  return true
}

async function send(email, password) {
  let res = await post('/auth/login', {
    email, password
  })
  res = JSON.parse(res)
  let msg = $('.message').el[0]
  if (res.msg === 'wrong pass') {
    msg.innerHTML = 'Не верный email или пароль'
    $(msg).addClass('error')
    $(msg).removeClass('success')
  } else if (res.msg === 'not confirmed') {
    msg.innerHTML = "Зайдите на почту чтобы подтвердить регистрацию"
    $(msg).addClass('error')
    $(msg).removeClass('success')
  } else if (res.msg === 'not_registered') {
    msg.innerHTML = "email не зарегистрирован <br> Для регистрации перейдите в раздел <a href = '/auth/register'>Регистрация</a>"
    $(msg).addClass('error')
    $(msg).removeClass('success')
  } else if (res.msg === 'employee') {
    window.location = '/adminsc'
  }else if (res.msg === 'user') {
    window.location = '/auth/cabinet'
  }
}
