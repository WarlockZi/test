import {post, $} from '../common';
import '../var.scss'
import '../components/header/header';
import '../components/header/autocomplete'
import '../components/footer/footer.sass'
import '../components/forms.sass'
import './login.scss'
import '../normalize.scss'
import './register'
import './cabinet'

$("body").on("click",
    function (e) {
        if (e.target.className === "messageClose") {
            window.location.href = "/user/cabinet";
        }
    });

if (typeof $("#login").el[0] !== 'undefined') {
    $("#login").on("click",
        async function (e) {
            e.preventDefault();

            var data = {
                "email": document.querySelector('input[type = email]').value,
                "password": document.querySelector("input[type= password]").value,
                "token": document.querySelector("[name = 'token']").getAttribute('content'),
            }

            let res = await post('/user/login', data);
            let overlayWrap = document.createElement('div');
            overlayWrap.innerHTML = res;
            document.body.append(overlayWrap);
            overlayWrap.querySelector('.overlay').style.display = "block";
        })
}

