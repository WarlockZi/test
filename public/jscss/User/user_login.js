import {post} from '../common';
import '../components/header/header';
import './login.scss'
import '../components/footer/footer.sass'
import '../components/forms.sass'
import {reg} from './register'

window.onload = function () {

    document.querySelector("body").addEventListener("click",
        function (e) {
            if (e.target.className === "messageClose") {
                window.location.href = "/user/cabinet";
            }
        });
    document.querySelector("#login").addEventListener("click",
        async function (e) {
            e.preventDefault();
            var data = {
                "email": document.querySelector('input[type = email]').value,
                "password": document.querySelector("input[type= password]").value,
                "token": document.querySelector("[name = 'token']").value,
            }

            let res = await post('/user/login', data);
            let overlayWrap = document.createElement('div');
            overlayWrap.innerHTML = res;
            document.querySelector('body').append(overlayWrap);
            overlayWrap.querySelector('.overlay').style.display = "block";
        });
};