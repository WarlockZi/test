import {$, post} from '../common'

$('.changepassword').on('click', async function (e) {

  let data = {
    'old_password': $('[name="old_password"]')[0].value,
    'new_password': $('[name="new_password"]')[0].value
  }
  let msg = $('.message')[0]

  let res = await post('/auth/changepassword', data)

  if (res.success) {
    msg.innerText = res.success
    $(msg).addClass('success')
    $(msg).removeClass('error')
  } else if(res.error){
    msg.innerText = res.error
    $(msg).addClass('error')
    $(msg).removeClass('success')
  }

})