!function(){"use strict";var e,t={918:function(e,t,n){(0,n(317).$)(".form__button").on("submit",(function(e){formData}))},317:function(e,t,n){n.d(t,{gk:function(){return i},v_:function(){return o},Gu:function(){return s},$:function(){return a}});let s={sort:()=>{let e=(void 0).nextElementSibling;(void 0).value.match(/\D+/)?(e.innerText="Только цифры",e.style.opacity="1"):"1"===e.style.opacity&&(e.style.opacity="0")},email:e=>!!e&&/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(e).toLowerCase()),password:e=>!!e&&/^[a-zA-Z\-0-9]{6,20}$/.test(e)},i={show:function(e,t){let n=this.el("div","popup__close");n.innerText="X";let s=this.el("div","popup__item");s.innerText=e,s.append(n);let i=a(".popup").el[0];i||(i=this.el("div","popup")),i.append(s),i.addEventListener("click",this.close,!0),document.body.append(i),setTimeout((()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")}),5e3),setTimeout((()=>{s.remove(),t&&t()}),5950)},close:function(e){e.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(e,t){let n=document.createElement(e);return n.classList.add(t),n}};async function o(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((function(n,s){t.token=document.querySelector('meta[name="token"]').getAttribute("content");let i=new XMLHttpRequest;i.open("POST",e,!0),i.setRequestHeader("X-Requested-With","XMLHttpRequest"),t instanceof FormData?i.send(t):(i.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),i.send("param="+JSON.stringify(t))),i.onerror=function(e){s(Error("Network Error"+e))},i.onload=async function(){n(i.response)}}))}function r(e){this.el=e,this.elType={}.toString.call(e),this.on=function(t,n){this.el&&("[object HTMLDivElement]"===this.elType&&this.el.addEventListener(t,n,!0),"[object NodeList]"===this.elType&&e.forEach((e=>e.addEventListener(t,n,!0))))},this.value=function(){return this.el[0].getAttribute("value")},this.attr=function(e,t){return t&&this.el[0].setAttribute(e,t),this.el[0].getAttribute(e)},this.selectedIndexValue=function(){if(this.el.length)return this.el[0].selectedOptions[0].value},this.options=function(){if(this.el.length)return this.el[0].options},this.count=function(){return this.el.length},this.text=function(){if(this.el.length)return this.el[0].innerText},this.checked=function(){if(this.el.length)return this.el[0].checked},this.getWithStyle=function(t,n){let s=[];return e.forEach((e=>{e.style[t]===n&&s.push(e)})),s},this.addClass=function(e){"[object HTMLDivElement]"===this.elType&&this.el.classList.add(e),["[object NodeList]","[object Array]"].includes(this.elType)&&this.el.forEach((t=>{t.classList.add(e)}))},this.removeClass=function(e){"[object HTMLDivElement]"===this.elType&&this.el.classList.remove(e),["[object NodeList]","[object Array]"].includes(this.elType)&&this.el.forEach((t=>{t.classList.remove(e)}))},this.hasClass=function(e){if(this.el.classList.contains(e))return!0},this.append=function(e){this.el[0].appendChild(e)},this.find=function(e){return["[object HTMLDivElement]","[object HTMLInputElement]","[object HTMLLIElement]"].includes(this.elType)?this.el.querySelector(e):["[object NodeList]","[object Array]"].includes(this.elType)?this.el[0].querySelector(e):void 0},this.css=function(t,n){if(!n)return this.el[0].style[t];"[object HTMLDivElement]"===this.elType&&(this.el.style[t]=n),"[object NodeList]"===this.elType&&e.forEach((e=>{e.style[t]=n}))}}function a(e){let t="";return t="string"==typeof e?document.querySelectorAll(e):e,new r(t)}}},n={};function s(e){var i=n[e];if(void 0!==i)return i.exports;var o=n[e]={exports:{}};return t[e](o,o.exports,s),o.exports}s.d=function(e,t){for(var n in t)s.o(t,n)&&!s.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},(0,(e=s(317)).$)(".gamburger").on("click",(function(e){e.target.closest(".utils").querySelector(".mobile-menu").classList.toggle("show")})),[...(0,e.$)(".search input").el].map((t=>{t&&t.addEventListener("input",(function(){!async function(t){let n=t.parentNode,s=(0,e.$)(n).find(".search__result");if(t.value.length<1)return void(s&&(s.innerHTML=""));let i=await fetch("/search?q="+t.value);i=await i.json(i),0!==s.childNodes.length&&(s.innerHTML=""),i.map((e=>{let t=document.createElement("a");t.href=e.alias,t.innerHTML=`<img src='/pic/${e.preview_pic}' alt='${e.name}'>`+e.name,s.appendChild(t)})),(0,e.$)("body").on("click",(function(e){s&&e.target!==s&&(s.innerHTML="")}))}(t)}),!0)})),(0,e.$)("body").on("click",(function(e){"messageClose"===e.target.className&&(window.location.href="/user/cabinet")})),document.cookie.match("(^|;)?cn=([^;]*)")?(0,e.$)("#cookie-notice").css("bottom","-100%"):(0,e.$)("#cookie-notice").css("bottom","0"),(0,e.$)("#cn-accept-cookie").on("click",(function(){(function(){const e=new Date;e.setTime(e.getTime()+2592e5),document.cookie="cn=1; expires="+e+"path=/; SameSite=lax"})(),(0,e.$)("#cookie-notice").css("bottom","-100%")})),(0,e.$)(".changepassword").on("click",(async function(){if("ok"===await(0,e.v_)("/user/changepassword",{old_password:(0,e.$)('[name="old_password"]').el[0].value,new_password:(0,e.$)('[name="new_password"]').el[0].value})){let t=(0,e.$)(".message").el[0];t.innerText="Пароль сменен",(0,e.$)(t).addClass("success"),(0,e.$)(t).removeClass("error")}else{let t=(0,e.$)(".message").el[0];t.innerText="Что-то пошло не так",(0,e.$)(t).addClass("error"),(0,e.$)(t).removeClass("success")}})),(0,e.$)(".password-control").on("click",(function(e){let t=e.target.parentNode.querySelector("input");"password"==t.getAttribute("type")?t.setAttribute("type","text"):t.setAttribute("type","password"),e.target.classList.toggle("view")})),(0,e.$)("#login").on("click",(function(t){t.preventDefault();let n=(0,e.$)("input[type = email]").el[0].value,s=(0,e.$)("input[name= password]").el[0].value;(function(t,n){let s=(0,e.$)(".message").el[0];return e.Gu.email(t)?!!e.Gu.password(n)||(s.innerText="Пароль может состоять из \n - Большие латинские бкувы \n- Маленькие латинские буквы \n- Цифры \n- Должен содержать не менее 6 символов",(0,e.$)($result).addClass("error"),!1):(s.innerText="Неправильный формат почты",(0,e.$)(s).addClass("error"),!1)})(n,s)&&async function(t,n){let s=await(0,e.v_)("/user/login",{email:t,password:n});s=JSON.parse(s);let i=(0,e.$)(".message").el[0];"fail"===s.msg?(i.innerHTML="Не верный email или пароль",(0,e.$)(i).addClass("error"),(0,e.$)(i).removeClass("success")):"not confirmed"===s.msg?(i.innerHTML="Зайдите на почту чтобы подтвердить регистрацию",(0,e.$)(i).addClass("error"),(0,e.$)(i).removeClass("success")):"ok"===s.msg?window.location="/user/cabinet":"not_registered"===s.msg&&(i.innerHTML="email не зарегистрирован <br> Для регистрации перейдите в раздел <a href = '/user/register'>Регистрация</a>",(0,e.$)(i).addClass("error"),(0,e.$)(i).removeClass("success"))}(n,s)})),(0,e.$)(".forgot").on("click",(async function(){window.location.href="/user/returnpass"})),(0,e.$)(".login").on("click",(async function(){window.location.href="/user/login"})),(0,e.$)(".reg").on("click",(async function(){let t=(0,e.$)("input[type = email]").el[0].value,n=(0,e.$)("input[type = password]").el[0].value,s=(0,e.$)(".message").el[0];if(!t||!n)return s.innerText="Заполните email и пароль",(0,e.$)(s).addClass("error"),!1;if(t){if(!e.Gu.email(t))return s.innerText="Неправильный формат почты",(0,e.$)(s).addClass("error"),!1;if(n&&!e.Gu.password(n))return s.innerText="Пароль может состоять из \n - больших латинских букв \n- маленьких латинских букв \n- цифр \n- должен содержать не менее 6 символов",(0,e.$)(s).addClass("error"),!1;await async function(t){let n={email:t,password:(0,e.$)("input[type= password]").el[0].value,surName:(0,e.$)("[name='surName']").el[0].value,name:(0,e.$)("[name='name']").el[0].value,token:(0,e.$)('meta[name="token"]').el[0].getAttribute("content")},s=await(0,e.v_)("/user/register",n),i=(0,e.$)(".message");"confirm"===s?(i.removeClass("error"),i.addClass("success"),i.el[0].innerHTML="-Пользователь зарегистрирован.<br>-Для подтверждения регистрации зайдите на почту, <bold>email</bold>.<br> -Перейдите по ссылке в письме."):"mail exists"===s?(i.el[0].innerHTML="Эта почта уже зарегистрирована",i.removeClass("success"),i.addClass("error")):"empty password"===s?(i.el[0].innerHTML="Зполните пароль",i.removeClass("success"),i.addClass("error")):(i.el[0].innerHTML=s,i.removeClass("success"),i.addClass("error"))}(t)}})),s(918),(0,e.$)(".returnpass").on("click",(async function(t){let n=(0,e.$)('input[type="email"]').el[0].value,s=await(0,e.v_)("/user/returnpass",{email:n});s=await JSON.parse(s),s&&e.gk.show(s.msg,(function(){window.location="/user/login"}))})),(0,e.$)("#save").on("click",(async function(t){t.preventDefault();const n=(0,e.$)('[name="sex"]').el;let s="";for(const e of n)e.checked&&(s=e.value);let i={name:(0,e.$)('[name = "name"]').el[0].value,surName:(0,e.$)('[name = "surName"]').el[0].value,middleName:(0,e.$)('[name = "middleName"]').el[0].value,birthDate:(0,e.$)('[name = "birthDate"]').el[0].value,phone:(0,e.$)('[name = "phone"]').el[0].value,sex:s};"ok"===await(0,e.v_)("/user/edit",i)&&e.gk.show("Сохранено")}))}();