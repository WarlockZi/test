import './edit.scss'
import {post, $, validate, popup} from '../common'

$("[name = 'edit']").on("click", async function (e) {
        e.preventDefault()
        let data = {
            email: check_email(),
            name: $('[name = "name"]').el[0].value,
            surName: $('[name = "surName"]').el[0].value,
            middleName: $('[name = "middleName"]').el[0].value,
            birthDate: $('[name = "birthDate"]').el[0].value,
            phone: $('[name = "phone"]').el[0].value,
        }
        let res = await post('/user/edit', data)
        if (res === 'ok'){
            debugger
            popup.show('Сохранено')
        }

    }
)

function check_email() {
    let email = $('input[type = email]').el[0].value
    if (!validate.email(email)) {
        let $result = $(".message").el[0];
        $result.innerText = "Неправильный формат почты"
        $($result).addClass('error')
        return false
    }
    return email
}


// setTimeout(function () {
//     let p = document.querySelector("p.result");
//     p.parentNode.remove();
// }, 2000);

