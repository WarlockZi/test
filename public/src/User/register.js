import {post, $} from '../common'

$("[name = 'reg']").on("click", async function (e) {
        e.preventDefault()
    let email = $('input[type = email]').el[0].value
    if(!email) return false

        let data = {
            "email": email,
            "password": $("input[type= password]").el[0].value,
            "surName": $("[name='surName']").el[0].value,
            "name": $("[name='name']").el[0].value,
            "token": $('meta[name="token"]').el[0].getAttribute('content'),
        }
        let res = await post('/user/register', data)
        res = JSON.parse(res)
        if (res.msg === 'ok') {
            $('.message').addClass('success')
            $('.message').el[0].innerHTML = 'Зарегистрирован. Теперь, чтобы попасть в личный кабинет, необходимо зайти на почту, с которой производилась регистрация и перейти по ссылке для подтверждения почты.'
        } else if (res.msg === 'mail exists') {
            $('.message').addClass('error')
            $('.error').el[0].innerHTML = 'Почта уже зарегистрирована. Вам необходимо <a href="/user/login">ВОЙТИ</a>'

        } else {
            $('.error').el[0].innerHTML = res
        }
    }
)



