import "jquery";
import {post} from '../common';
import '../components/header/header.sass';

///////////////////////////    Login     /////////////////////
$(function () {
    document.querySelector("body").addEventListener("click",
        function (e) {
            // debugger;
            if (e.target.className === "messageClose") {
                window.location.href = "/user/cabinet";
            }
        });
    document.querySelector("#login").addEventListener("click",
        async function (e) {
            e.preventDefault();
            let obj = {};
            obj.email = $('input[type = email]').val();
            obj.pass = $('input[type= password]').val();
            obj.token = document.querySelector("[name = 'token']").value;

            let response = await post('/user/login', obj);
            $('body').append(response);
            $('.overlay').css({"display": "block"});


        });
});