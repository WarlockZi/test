import {$, post, popup} from "../common"
import "../components/popup.scss"

let returnpass = $(`[data-auth="returnpass"]`)[0]
if (returnpass){
    $('.submit__button').on('click', async function (e) {
        let email = $('input[type="email"]')[0].value
        let res = await post('/auth/returnpass',{email})
        res = await JSON.parse(res)
        if (res) {
            popup.show(res.msg, function () {
                window.location = '/auth/login'
            })
        }

    })
}
