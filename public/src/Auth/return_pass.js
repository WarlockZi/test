import {$, post, popup} from "../common"
import "../components/popup.scss"

$('.returnpass').on('click', async function (e) {
    let email = $('input[type="email"]').el[0].value
    let res = await post(
        '/auth/returnpass',
        {email: email}
    )
    res = await JSON.parse(res)
    if (res) {
        popup.show(res.msg, function () {
            window.location = '/auth/login'
        })
    }

})