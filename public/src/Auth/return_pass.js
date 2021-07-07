import {$, post} from "../common"

$('.return_pass').on('click', async function (e) {
    e.preventDefault();
    if (e.target.classList.contains('returnpass')){
        let email = $('input[type="email"]').el[0].value
        let res = await post(
            '/user/returnPass',
            {email:email}
            )
        if (res==='ok') {
            window.location = '/user/login'
        }
    }
})