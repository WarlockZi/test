import {$, post} from '../common'

$('.changepassword').on('click', async function (e) {
    e.preventDefault
    let res = await post('/auth/changepassword', {
        'old_password':$('[name="old_password"]').el[0].value,
        'new_password':$('[name="new_password"]').el[0].value
    })
    if (res === 'ok') {
        let msg = $('.message').el[0]
            msg.innerText = 'Пароль сменен'
        $(msg).addClass('success')
        $(msg).removeClass('error')
    }else {
        let msg = $('.message').el[0]
        msg.innerText = 'Что-то пошло не так'
        $(msg).addClass('error')
        $(msg).removeClass('success')
    }
})