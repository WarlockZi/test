import './login.scss'
import {$, post, validate} from "../common";

$('.password-control').on('click', toggle)

function toggle() {
    if ($('[name="password"]').attr('type') == 'password') {
        $('[name="password"]').attr('type', 'text');
    } else {
        $('[name="password"]').attr('type', 'password');
    }
    this.classList.toggle('view')
}


let loginBtn = $("#login").el[0]
if (loginBtn) {
    $(loginBtn).on("click",
        function (e) {
            e.preventDefault();
            let email = $('input[type = email]').el[0].value
            let pass = $('input[name= password]').el[0].value

            if (validateEmailLogin(email, pass)) send(email, pass)
        }
    )
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

async function send(email) {
    let res = await post('/user/login', {
        "email": email,
        "password": $('input[name="password"]').el[0].value,
    })
    res = JSON.parse(res)
    let msg = $('.message').el[0]
    if (res.msg === 'fail') {
        msg.innerHTML = 'Не верный email или пароль'
        $(msg).addClass('error')
        $(msg).removeClass('success')
    } else if (res.msg === 'not confirmed') {
        msg.innerHTML = "Зайдите на почту чтобы подтвердить регистрацию"
        $(msg).addClass('error')
        $(msg).removeClass('success')
    } else if (res.msg === 'ok') {
        window.location = '/user/cabinet'
    } else if (res.msg === 'not_registered') {
        msg.innerHTML = "email не зарегистрирован <br> Для регистрации перейдите в раздел <a href = '/user/register'>Регистрация</a>"
        $(msg).addClass('error')
        $(msg).removeClass('success')
    }
}
