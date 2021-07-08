import {post, $, validate} from '../common'

$("[name = 'reg']").on("click", async function (e) {
        e.preventDefault()

        let email = $('input[type = email]').el[0].value
        let password = $('input[type = password]').el[0].value
        if (email) {
            if (!validate.email(email)) {
                let $result = $(".message").el[0];
                $result.innerText = "Неправильный формат почты"
                $($result).addClass('error')
                return false
            }
            if (password) {
                if (!validate.password(password)) {
                    let msg = $(".message").el[0]
                    msg.innerText = "Пароль может состоять из \n " +
                        "- больших латинских букв \n" +
                        "- маленьких латинских букв \n" +
                        "- цифр \n" +
                        "- должен содержать не менее 6 символов"

                    $(msg).addClass('error')
                    return false
                }
            }
            send(email)
        }
    }
)


async function send(email) {
    let data = {
        "email": email,
        "password": $("input[type= password]").el[0].value,
        "surName": $("[name='surName']").el[0].value,
        "name": $("[name='name']").el[0].value,
        "token": $('meta[name="token"]').el[0].getAttribute('content'),
    }
    let res = await post('/user/register', data)
    let msg = $('.message')

    if (res === 'ok') {
        $('.message').removeClass('error')
        $('.message').addClass('success')
        $('.message').el[0].innerHTML =
            'Пользователь зарегистрирован.\n' +
            'Для подтверждения регистрации зайдите на почту, ' +
            'с которой производилась регистрация, ' +
            'и перейдите по ссылке в письме.'
    } else if (res === 'mail exists') {
        msg.el[0].innerHTML = 'Эта почта уже зарегистрирована'
        msg.removeClass('success')
        msg.addClass('error')
    } else if (res === 'empty password') {
        msg.el[0].innerHTML = 'Зполните пароль'
        msg.removeClass('success')
        msg.addClass('error')
    } else if(res==='confirm'){
        msg.el[0].innerHTML = "Для подтвержения регистрации перейдите по ссылке в письме. <br>Письмо может попасть в папку СПАМ"
        msg.removeClass('error')
        msg.addClass('success')
    }
}



