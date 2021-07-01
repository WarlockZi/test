import {post, $} from '../common'

$("[name = 'reg']").on("click", async function (e) {
        e.preventDefault()

        let email = $('input[type = email]').el[0].value
        let password = $('input[type = password]').el[0].value
        if (email) {
            if (!validateEmail(email)) {
                return false
            }
            if (password) {
                if (!validatePassword(password)) {
                    return false
                }
            }
            if(send(email)==='ok'){
                window.location = '/user/cabinet'
            }
        }
    }
)

function validateEmail(email) {
    let $result = $(".message").el[0];
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (!re.test(email)) {
        $result.innerText = "Неправильный формат почты"
        $($result).addClass('error')
        return false
    }
    return true;
}

function validatePassword(password) {
    let $result = $(".message").el[0];
    const re = /^[a-zA-Z\-0-9]{6,20}$/;

    if (!re.test(password)) {
        $result.innerText = "Пароль может состоять из \n " +
            "- Большие латинские бкувы \n" +
            "- Мальенькие латинские буквы \n" +
            "- Цифры \n" +
            "- должен содержать не менее 6 символов"

        $($result).addClass('error')
        return false
    }
    return true;
}

async function send(email) {
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
        $('.message').removeClass('error')
        $('.message').addClass('success')
        $('.message').el[0].innerHTML =
            'Пользователь зарегистрирован.\n' +
            'Для подтверждения регистрации зайдите на почту, ' +
            'с которой производилась регистрация, ' +
            'и перейдите по ссылке в письме.'
    } else if (res.msg === 'mail exists') {
        $('.message').addClass('error')
        $('.error').el[0].innerHTML = 'Почта уже зарегистрирована. Вам необходимо <a href="/user/login">войти</a>'

    } else {
        $('.error').el[0].innerHTML = res
    }

}



