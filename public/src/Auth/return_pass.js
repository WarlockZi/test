import {$, post, popup} from "../common"
import "../components/popup.scss"

$('.returnpass').on('click', async function (e) {
    let email = $('input[type="email"]').el[0].value
    let res = await post(
        '/user/forgot-password',
        {email: email}
    )
    res = await JSON.parse(res)
    if (res) {
        popup.show(res.msg, function () {
            window.location = '/user/login'
        })
    }

})