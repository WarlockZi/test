!function(){"use strict";var e={317:function(e,t,s){function n(e,t,s){return t in e?Object.defineProperty(e,t,{value:s,enumerable:!0,configurable:!0,writable:!0}):e[t]=s,e}function a(e){return function(e){return e.trim()}(e=function(e){var t=new RegExp("s","g");return e.replace(t,"")}(e=function(e){var t=new RegExp("\\t?","g");return e.replace(t,"")}(e=function(e){var t=new RegExp("\\n?","g");return e.replace(t,"")}(e=function(e){var t=new RegExp("&nbsp;?","g");return e.replace(t," ")}(e)))))}s.d(t,{$:function(){return c},Gu:function(){return i},mN:function(){return a},v_:function(){return r}});let i={sort:()=>{let e=(void 0).nextElementSibling;(void 0).value.match(/\D+/)?(e.innerText="Только цифры",e.style.opacity="1"):"1"===e.style.opacity&&(e.style.opacity="0")},email:e=>!!e&&(!/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(e).toLowerCase())&&"Неправильный формат почты"),password:e=>!!e&&(!/^[a-zA-Z\-0-9]{6,20}$/.test(e)&&"Пароль может состоять из \n - Большие латинские бкувы \n- Маленькие латинские буквы \n- Цифры \n- Должен содержать не менее 6 символов")},l={show:function(e,t){let s=this.el("div","popup__close");s.innerText="X";let n=this.el("div","popup__item");n.innerText=e,n.append(s);let a=c(".popup")[0];a||(a=this.el("div","popup")),a.append(n),a.addEventListener("click",this.close,!0),document.body.append(a),setTimeout((()=>{n.classList.remove("popup__item"),n.classList.add("popup-hide")}),5e3),setTimeout((()=>{n.remove(),t&&t()}),5950)},close:function(e){e.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(e,t){let s=document.createElement(e);return s.classList.add(t),s}};async function r(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(s,n){t.token=document.querySelector('meta[name="token"]').getAttribute("content");let a=new XMLHttpRequest;a.open("POST",e,!0),a.setRequestHeader("X-Requested-With","XMLHttpRequest"),t instanceof FormData?a.send(t):(a.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),a.send("param="+JSON.stringify(t))),a.onerror=function(e){n(Error("Network Error"+e))},a.onload=function(){var e;let t=JSON.parse(a.response),n=c(".message")[0];var i;t.popup||null!=t&&null!==(e=t.arr)&&void 0!==e&&e.popup?l.show(t.popup??(null==t||null===(i=t.arr)||void 0===i?void 0:i.popup)):t.msg?n&&(n.innerHTML=t.msg,n.innerHTML=t.msg,c(n).removeClass("success"),c(n).removeClass("error")):t.success?n&&(n.innerHTML=t.success,c(n).addClass("success"),c(n).removeClass("error")):t.error&&n&&(n.innerHTML="",n.innerHTML=t.error,c(n).removeClass("success"),c(n).addClass("error")),s(t)}}))}class o extends Array{constructor(){super(...arguments),n(this,"value",(function(){return this[0].getAttribute("value")})),n(this,"attr",(function(e,t){return t&&this[0].setAttribute(e,t),this[0].getAttribute(e)})),n(this,"selectedIndexValue",(function(){if(this.length)return this[0].selectedOptions[0].value})),n(this,"options",(function(){if(this.length)return this[0].options})),n(this,"count",(function(){return this.length})),n(this,"text",(function(){if(this.length)return this[0].innerText})),n(this,"checked",(function(){if(this.length)return this[0].checked})),n(this,"getWithStyle",(function(e,t){let s=[];return this.forEach((n=>{n.style[e]===t&&s.push(n)})),s})),n(this,"addClass",(function(e){this.forEach((t=>{t.classList.add(e)}))})),n(this,"removeClass",(function(e){this.forEach((t=>{t.classList.remove(e)}))})),n(this,"hasClass",(function(e){if(this.classList.contains(e))return!0})),n(this,"append",(function(e){this[0].appendChild(e)})),n(this,"find",(function(e){return"string"==typeof e?this[0].querySelector(e):this[0].filter((t=>t===e))[0]})),n(this,"findAll",(function(e){if("string"==typeof e)return this[0].querySelectorAll(e)})),n(this,"css",(function(e,t){if(!t)return this[0].style[e];this.forEach((s=>{s.style[e]=t}))}))}on(e,t,s){"function"==typeof t?this.forEach((s=>s.addEventListener(e,t))):this.forEach((n=>{n.addEventListener(e,(e=>{e.target===t&&s(e)}))}))}ready(e){this.some((e=>null!=e.readyState&&"loading"!=e.readyState))?e():document.addEventListener("DOMContentLoaded",e)}}function c(e){return"string"==typeof e||e instanceof String?new o(...document.querySelectorAll(e)):new o(e)}},261:function(e,t,s){var n=s(317);document.cookie.match("(^|;)?cn=([^;]*)")?(0,n.$)("#cookie-notice").css("bottom","-100%"):(0,n.$)("#cookie-notice").css("bottom","0"),(0,n.$)("#cn-accept-cookie").on("click",(function(){(function(){const e=new Date;e.setTime(e.getTime()+2592e5),document.cookie="cn=1; expires="+e+"path=/; SameSite=lax"})(),(0,n.$)("#cookie-notice").css("bottom","-100%")}))},312:function(e,t,s){var n=s(317);(0,n.$)(".gamburger")[0]&&(0,n.$)(".gamburger").on("click",(function(e){e.target.closest(".utils").querySelector(".mobile-menu").classList.toggle("show")}))}},t={};function s(n){var a=t[n];if(void 0!==a)return a.exports;var i=t[n]={exports:{}};return e[n](i,i.exports,s),i.exports}s.d=function(e,t){for(var n in t)s.o(t,n)&&!s.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){s(312);var e=s(317);[...(0,e.$)(".search input")].map((t=>{t&&t.addEventListener("input",(function(){!async function(t){let s=t.parentNode,n=(0,e.$)(s).find(".search__result");if(t.value.length<1)return void(n&&(n.innerHTML=""));let a=await fetch("/search?q="+t.value);a=await a.json(a),0!==n.childNodes.length&&(n.innerHTML=""),a.map((e=>{let t=document.createElement("a");t.href=e.alias,t.innerHTML=`<img src='/pic/${e.preview_pic}' alt='${e.name}'>`+e.name,n.appendChild(t)})),(0,e.$)("body").on("click",(function(e){n&&e.target!==n&&(n.innerHTML="")}))}(t)}),!0)})),s(261),(0,e.$)(".changepassword").on("click",(async function(t){let s={old_password:(0,e.$)('[name="old_password"]')[0].value,new_password:(0,e.$)('[name="new_password"]')[0].value},n=(0,e.$)(".message")[0],a=await(0,e.v_)("/auth/changepassword",s);a.success?(n.innerText=a.success,(0,e.$)(n).addClass("success"),(0,e.$)(n).removeClass("error")):a.error&&(n.innerText=a.error,(0,e.$)(n).addClass("error"),(0,e.$)(n).removeClass("success"))}));let t=(0,e.$)("[data-auth='login']")[0];t&&(0,e.$)(t).on("click",function(t){let{target:s}=t;s.classList.contains("submit__button")&&function(){let t=e.Gu.email(n.value);return t?(i.innerText="",i.innerText=t,(0,e.$)(i).addClass("error"),!1):"vvoronik@yandex.ru"===n.value||(t=e.Gu.password(a.value),!t)||(i.innerText="",i.innerText=t,(0,e.$)(i).addClass("error"),!1)}()&&async function(){let t={email:n.value,password:a.value},s=await(0,e.v_)("/auth/login",t);"employee"===s.arr.role?window.location="/adminsc":"user"===s.arr.role&&(window.location="/auth/cabinet")}()}.bind(void 0));let n=(0,e.$)("input[type = email]")[0],a=(0,e.$)("input[name= password]")[0],i=(0,e.$)(".message")[0],l=(0,e.$)("[data-auth='register']")[0];l&&(0,e.$)(l).on("click",(function(t){let{target:s}=t,n=(0,e.mN)((0,e.$)("input[type = email]")[0].value),a=(0,e.mN)((0,e.$)("input[name = password]")[0].value);s.classList.contains("submit__button")&&function(t,s){let n=e.Gu.email(t),a=(0,e.$)(".message")[0];return n?(a.innerText=a.innerText+n,(0,e.$)(a).addClass("error"),!1):(n=e.Gu.password(s),!n||(a.innerText=a.innerText+n,(0,e.$)(a).addClass("error"),!1))}(n,a)&&async function(t,s){let n=(0,e.$)(".message")[0],a={email:t,password:s,surName:(0,e.$)("[name='surName']")[0].value,name:(0,e.$)("[name='name']")[0].value},i=await(0,e.v_)("/auth/register",a);"confirmed"===i.msg?(n.classList.remove("error"),n.classList.add("success"),n.innerHTML="-Пользователь зарегистрирован.<br>-Для подтверждения регистрации зайдите на почту, <bold>email</bold>.<br> -Перейдите по ссылке в письме."):"mail exists"===i.msg?(n.innerHTML="Эта почта уже зарегистрирована",n.classList.remove("success"),n.classList.add("error")):(n.innerHTML=i.msg,n.classList.remove("success"),n.classList.add("error"))}(n,a)})),(0,e.$)('[data-auth="returnpass"]')[0]&&(0,e.$)(".submit__button").on("click",(async function(t){let s=(0,e.$)('input[type="email"]')[0].value;await(0,e.v_)("/auth/returnpass",{email:s})&&(window.location="/auth/login")})),(0,e.$)("#save").on("click",(async function(t){t.preventDefault();let s={name:(0,e.$)('[name = "name"]')[0].value,surName:(0,e.$)('[name = "surName"]')[0].value,middleName:(0,e.$)('[name = "middleName"]')[0].value,birthDate:(0,e.$)('[name = "birthDate"]')[0].value,phone:(0,e.$)('[name = "phone"]')[0].value,sex:void 0};await(0,e.v_)("/user/edit",s)}));class r{constructor(e){return!!e&&!e.multiple&&(this.title=e.title??"",this.field=e.dataset.field,this.model=e.dataset.model,this.modelId=e.dataset.id,this.options=(t=e.querySelectorAll("option"),[...t].map((e=>({value:e.value,label:e.label,selected:e.selected,element:e})))),this.sel=document.createElement("div"),e.className&&this.sel.classList.add(e.className),this.label=document.createElement("span"),this.arrow=document.createElement("div"),this.space=document.createElement("div"),this.ul=document.createElement("ul"),function(e){let t;e.title&&(e.titleElement=document.createElement("div"),e.titleElement.classList.add("title"),e.titleElement.innerText=e.title,e.sel.append(e.titleElement)),e.sel.setAttribute("custom-select",""),e.sel.dataset.model=e.model,e.sel.dataset.modelId=e.modelId,e.field&&(e.sel.dataset.field=e.field),e.sel.dataset.value=e.selectedOption.value,e.sel.tabIndex=0,e.sel.append(e.label),e.space.classList.add("space"),e.space.innerText=e.selectedOption.label,e.label.append(e.space),e.arrow.classList.add("arrow"),e.label.append(e.arrow),e.ul.classList.add("options"),e.options.forEach((t=>{!function(t){const s=document.createElement("li");s.innerText=t.label,s.dataset.value=t.value,s.classList.toggle("selected",t.selected),s.addEventListener("click",(()=>{e.selectValue(t.value),e.ul.classList.remove("show")})),e.ul.append(s)}(t)})),e.sel.append(e.ul),e.label.addEventListener("click",(()=>{e.ul.classList.toggle("show")})),e.sel.addEventListener("blur",(()=>{e.ul.classList.remove("show")}));let s="";e.sel.addEventListener("keydown",(n=>{switch(n.code){case"Space":e.ul.classList.toggle("show");break;case"ArrowUp":{const t=e.options[e.selectedOptionIndex-1];t&&e.selectValue(t.value);break}case"ArrowDown":{const t=e.options[e.selectedOptionIndex+1];t&&e.selectValue(t.value);break}case"Enter":case"Escape":e.ul.classList.remove("show");break;default:{clearTimeout(t),s+=n.key,t=setTimeout((()=>{s=""}),500);const a=e.options.find((e=>e.label.toLowerCase().startsWith(s)));a&&e.selectValue(a.value)}}}))}(this),e.after(this.sel),void e.remove());var t}get selectedOption(){return this.options.find((e=>e.selected))}get selectedOptionIndex(){return this.options.indexOf(this.selectedOption)}selectValue(e){const t=this.options.find((t=>t.value===e)),s=this.selectedOption;s.selected=!1,t.selected=!0,this.space.innerText=t.label,this.label.closest("[custom-select]").dataset.value=t.value,this.ul.querySelector(`[data-value="${s.value}"]`).classList.remove("selected");const n=this.ul.querySelector(`[data-value="${t.value}"]`);n.classList.add("selected"),n.scrollIntoView({block:"nearest"})}}!function(){let t=(0,e.$)("[custom-radio]");[].map.call(t,(function(t){(0,e.$)(t).on("click",(function(e){let{target:s}=e,n=s.closest("label");t.dataset.value=n.dataset.value}))}))}(),function(){let t=(0,e.$)("[multi-select] ");t&&[].forEach.call(t,(function(t){t.addEventListener("click",(function(t){let{target:s}=t,n=s.closest("[multi-select]");if(s.closest(".arrow")||["chip-wrap"].includes(s.className))n.querySelector("ul").classList.toggle("show");else if(["view.components.Builders.ListBuilder.del"].includes(s.className))a=s.closest(".chip").dataset.id,(0,e.$)(n).find(`label[data-id='${a}']`).classList.remove("selected"),s.closest(".chip").remove();else if("label"===s.tagName.toLowerCase()){let t=s.dataset.id,a=n.querySelectorAll(".chip"),i=[].some.call(a,(e=>e.dataset.id===t)),l=(0,e.$)(n).find(".chip-wrap");if(i)s.classList.toggle("selected"),l.querySelector(`[data-id='${t}']`).remove();else{s.classList.toggle("selected");let e=function(e){let t=document.createElement("div");t.classList.add("chip"),t.innerText=s.innerText,t.dataset.id=e;let n=document.createElement("div");return n.classList.add("view.components.Builders.ListBuilder.del"),n.innerText="X",t.append(n),t}(t);l.append(e)}}var a}),!1),t.addEventListener("blur",(function(t){let{target:s}=t,n=(0,e.$)(this).find(".show");n&&n.classList.remove("show")}),!1)}))}(),function(){let t=(0,e.$)(".item_wrap")[0];if(t){(0,e.$)(t).on("click",(async function(s){let{target:n}=s,a=t,i=a.dataset.model;n.closest(".save")?async function(t){if(function(){let t=(0,e.$)("[required]"),s=0;return[].forEach.call(t,(function(t){if(!t.innerText){if(t.style.borderColor="red",(0,e.$)(t).find(".error"))return;let n=document.createElement("div");n.innerText="Заполните поле",n.classList.add("error"),t.closest(".value").appendChild(n),s++}})),s}())return!1;let s=function(t){let s=(0,e.$)(`[data-field][data-model='${t}']`),n={};return[].map.call(s,(t=>{if(t.closest("[data-parent]"))return n;if(t.hasAttribute("data-value")||t.hasAttribute("custom-select")||t.hasAttribute("custom-radio")||t.hasAttribute("tab"))n[t.dataset.field]=t.dataset.value;else if(t.hasAttribute("multi-select")){let e=t.querySelectorAll(".chip"),s=[].map.call(e,(e=>e.dataset.id));n[t.dataset.field]=s.toString()}else"inputs"===t.dataset.type?n[t.dataset.field]=function(e){let t=e.querySelectorAll("input"),s=[];return t.forEach((e=>{if(!e.checked)return;let t=e.parentNode.querySelector(".name").innerText;t&&s.push(t)})),s.join(",")}(t):"date"===t.type?n[t.dataset.field]=t.value:n[t.dataset.field]=(0,e.mN)(t.innerText)}),n),n}(t);await(0,e.v_)(`/adminsc/${t}/updateorcreate`,s)}(i):n.closest(".del")&&n.closest(".del").dataset.model?async function(t,s){let n=t.dataset.id;await(0,e.v_)(`/adminsc/${s}/delete`,{id:n})&&(window.location.href=`/adminsc/${s}/edit`)}(a,n.closest(".del").dataset.model):n.classList.contains("tab")&&async function(t){(0,e.$)("[data-tab].show")[0].classList.toggle("show"),(0,e.$)(`[data-tab='${t.dataset.tabId}']`)[0].classList.toggle("show"),(0,e.$)(".tab.active")[0].classList.toggle("active"),t.classList.toggle("active")}(n)}));let s=(0,e.$)("[custom-select]");s&&[].map.call(s,(function(e){new r(e)}))}}(),(0,e.$)(".password-control")&&(0,e.$)(".password-control").on("click",(function(e){let{target:t}=e,s=t.parentNode.querySelector("input");"password"===s.getAttribute("type")?s.setAttribute("type","text"):s.setAttribute("type","password"),t.classList.toggle("view")}))}()}();
//# sourceMappingURL=auth.js.map