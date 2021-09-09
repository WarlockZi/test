import {$, post, popup} from "../common"
import "../components/popup.scss"

$('.return_pass').on('click', async function (e) {
    e.preventDefault();
    if (e.target.classList.contains('returnpass')) {
        let email = $('input[type="email"]').el[0].value
        let res = await post(
            '/user/returnPass',
            {email: email}
        )
        res = await JSON.parse(res)
        if (res) {
            popup.show(res.msg, function () {
                window.location = '/user/login'
            })
        }
    }
})