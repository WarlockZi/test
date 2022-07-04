import './login.scss'
import {$, post, validate} from "../common";
// import 'dotenv/config'

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
    msg.innerText = ''
    msg.innerText = error
    $(msg).addClass('error')
    return false
  }
  let suemail = process.env.SU_EMAIL
  let su = suemail === email.value
  if (!su) {
    error = validate.password(pass.value)
    if (error) {
      msg.innerText = ''
      msg.innerText = error
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
  if (res.arr.role === 'employee') {
    window.location = '/adminsc'
  } else if (res.arr.role === 'user') {
    window.location = '/auth/cabinet'
  }
}
