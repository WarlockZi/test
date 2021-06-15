import {post, $} from '../common'

$("[name = 'reg']").on("click", function (e) {
        e.preventDefault()

        let data = {
            "email": $('input[type = email]').el[0].value,
            "password": $("input[type= password]").el[0].value,
            "surName": $("[name='surName']").el[0].value,
            "name": $("[name='name']").el[0].value,
            "token": $('meta[name="token"]').el[0].getAttribute('content'),
        }
        post('/user/register', data)
    }
)



