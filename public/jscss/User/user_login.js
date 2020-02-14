// import "jquery";
import {post} from '../common';
import '../components/header/header.sass';

///////////////////////////    Login     /////////////////////
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
            let obj = {};
            obj.email = document.querySelector('input[type = email]').value,
                obj.pass = document.querySelector('input[type= password]').value,
                obj.token = document.querySelector("[name = 'token']").value;
            debugger;

            let res = await post('/user/login', obj);
            let overlayWrap = document.createElement('div');
            overlayWrap.innerHTML = res;
            document.querySelector('body').append(overlayWrap);
            overlayWrap.querySelector('.overlay').style.display = "block";
        });
};