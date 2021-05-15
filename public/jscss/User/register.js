import {post} from '../common'

window.onload = function () {
    document.querySelector("[name = 'reg']").addEventListener("click", function (e) {
            e.preventDefault()

            var data = {
                "email": document.querySelector('input[type = email]').value,
                "password": document.querySelector("input[type= password]").value,
                "surName": document.querySelector("[name='surName']").innerText,
                "name": document.querySelector("[name='name']").innerText,
                "token": document.querySelector('meta[name="token"]').getAttribute('content'),
            }
            post('/user/register', data)
        }
    )
}


