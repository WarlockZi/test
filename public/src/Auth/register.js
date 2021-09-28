import {post, $, validate} from '../common'

$(".forgot").on("click", async function () {
        window.location.href = '/user/returnpass'
    }
)
$(".login").on("click", async function () {
        window.location.href = '/user/login'
    }
)

$(".reg").on("click", async function () {

        let email = $('input[type = email]').el[0].value
        let password = $('input[type = password]').el[0].value
        let msg = $(".message").el[0];
        if (!email || !password) {
            msg.innerText = "Заполните email и пароль"
            $(msg).addClass('error')
            return false
        }
        if (email) {
            if (!validate.email(email)) {
                msg.innerText = "Неправильный формат почты"
                $(msg).addClass('error')
                return false
            }
            if (password) {
                if (!validate.password(password)) {
                    msg.innerText = "Пароль может состоять из \n " +
                        "- больших латинских букв \n" +
                        "- маленьких латинских букв \n" +
                        "- цифр \n" +
                        "- должен содержать не менее 6 символов"

                    $(msg).addClass('error')
                    return false
                }
            }
            let res = await send(email)
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

    if (res === 'confirm') {
        msg.removeClass('error')
        msg.addClass('success')
        msg.el[0].innerHTML =
            '-Пользователь зарегистрирован.<br>' +
            '-Для подтверждения регистрации зайдите на почту, ' +
            '<bold>email</bold>.<br> ' +
            '-Перейдите по ссылке в письме.'
    } else if (res === 'mail exists') {
        msg.el[0].innerHTML = 'Эта почта уже зарегистрирована'
        msg.removeClass('success')
        msg.addClass('error')
    } else if (res === 'empty password') {
        msg.el[0].innerHTML = 'Зполните пароль'
        msg.removeClass('success')
        msg.addClass('error')

    } else {
        msg.el[0].innerHTML = res
        msg.removeClass('success')
        msg.addClass('error')
    }
}



