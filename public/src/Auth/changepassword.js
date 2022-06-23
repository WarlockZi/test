import {$, post} from '../common'

$('.changepassword').on('click', async function (e) {

  let data = {
    'old_password': $('[name="old_password"]')[0].value,
    'new_password': $('[name="new_password"]')[0].value
  }
  let msg = $('.message')[0]

  let res = await post('/auth/changepassword', data)
  if (res) {
    msg.innerText = 'Пароль сменен'
    $(msg).addClass('success')
    $(msg).removeClass('error')
  } else {
    msg.innerText = 'Что-то пошло не так'
    $(msg).addClass('error')
    $(msg).removeClass('success')
  }
})