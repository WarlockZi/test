import './login.scss'
import {$, post, validate} from "../common";

let loginBtn = $("#login").el[0]
if (loginBtn) {
    $(loginBtn).on("click",
        async function (e) {
            e.preventDefault();

            let email = $('input[type = email]').el[0].value
            let password = $('input[type = password]').el[0].value
            if (!validate.email(email)) {
                let $result = $(".message").el[0];
                $result.innerText = "Неправильный формат почты"
                $($result).addClass('error')
                return false
            }
            if (!validate.password(password)) {
                let $result = $(".message").el[0]
                $result.innerText = "Пароль может состоять из \n " +
                    "- Большие латинские бкувы \n" +
                    "- Маленькие латинские буквы \n" +
                    "- Цифры \n" +
                    "- Должен содержать не менее 6 символов"

                $($result).addClass('error')
                return false
            }
            send(email)
        })
}

async function send(email) {
    let res = await post('/user/login', {
        "email": email,
        "password": $("input[type= password]").el[0].value,
    })
    let msg = $('.message').el[0]
    if (res === 'fail') {
        msg.innerHTML = 'Не верный email или пароль'
        $(msg).addClass('error')
        $(msg).removeClass('success')
    }else if(res==='ok'){
        window.location = '/user/cabinet'
    }  else if(res==='not_registered'){
        msg.innerHTML = "Для регистрации перейдите в раздел <a href = '/user/register'>Регистрация</a>"
        $(msg).addClass('error')
        $(msg).removeClass('success')
    }
}

//
// $("body").on("click",
//     function (e) {
//         if (e.target.className === "messageClose") {
//             window.location.href = "/user/cabinet";
//         }
//     })