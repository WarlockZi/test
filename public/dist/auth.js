!function(){"use strict";var e={317:function(e,t,n){n.d(t,{$:function(){return d},Ds:function(){return a},Gu:function(){return r},mN:function(){return o},v_:function(){return l}});var s=n(546);function i(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}const a=function(e){let t,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:700;return function(){const s=()=>e.apply(this,arguments);clearTimeout(t),t=setTimeout(s,n)}};function o(e){return function(e){return e.trim()}(e=function(e){var t=new RegExp("\\t?","g");return e.replace(t,"")}(e=function(e){var t=new RegExp("\\n?","g");return e.replace(t,"")}(e=function(e){var t=new RegExp("&nbsp;?","g");return e.replace(t," ")}(e))))}let r={sort:()=>{let e=(void 0).nextElementSibling;(void 0).value.match(/\D+/)?(e.innerText="Только цифры",e.style.opacity="1"):"1"===e.style.opacity&&(e.style.opacity="0")},email:e=>!!e&&(!/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(e).toLowerCase())&&"Неправильный формат почты"),password:e=>!!e&&(!/^[a-zA-Z\-0-9]{6,20}$/.test(e)&&"Пароль может состоять из \n - Большие латинские бкувы \n- Маленькие латинские буквы \n- Цифры \n- Должен содержать не менее 6 символов")},c={show:function(e,t){let n=this.el("div","popup__close");n.innerText="X";let s=this.el("div","popup__item");s.innerText=e,s.append(n);let i=d(".popup")[0];i||(i=this.el("div","popup")),i.append(s),i.addEventListener("click",this.close,!0),document.body.append(i),setTimeout((()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")}),5e3),setTimeout((()=>{s.remove(),t&&t()}),5950)},close:function(e){e.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(e,t){let n=document.createElement(e);return n.classList.add(t),n}};async function l(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(n,i){t.token=document.querySelector('meta[name="token"]').getAttribute("content");let a=new XMLHttpRequest;a.open("POST",e,!0),a.setRequestHeader("X-Requested-With","XMLHttpRequest"),t instanceof FormData?a.send(t):(a.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),a.send("param="+JSON.stringify(t))),a.onerror=function(e){i(Error("Network Error"+e.message))},a.onload=function(){try{var e;const i=JSON.parse(a.response);let o=d(".message")[0];var t;null!=i&&i.popup||null!=i&&null!==(e=i.arr)&&void 0!==e&&e.popup?c.show(i.popup??(null==i||null===(t=i.arr)||void 0===t?void 0:t.popup)):i.msg?o&&(o.innerHTML=i.msg,o.innerHTML=i.msg,d(o).removeClass("success"),d(o).removeClass("error")):i.success?o&&(o.innerHTML=i.success,d(o).addClass("success"),d(o).removeClass("error")):i.error&&(0,s.Z)(i.error),n(i)}catch(e){return console.log("////////////********* REQUEST ERROR ***********//////////////////////"),console.log(a.response),!1}}}))}class u extends Array{constructor(){super(...arguments),i(this,"value",(function(){return this[0].getAttribute("value")})),i(this,"first",(function(){return this[0]})),i(this,"attr",(function(e,t){return t&&this[0].setAttribute(e,t),this[0].getAttribute(e)})),i(this,"selectedIndexValue",(function(){if(this.length)return this[0].selectedOptions[0].value})),i(this,"options",(function(){if(this.length)return this[0].options})),i(this,"count",(function(){return this.length})),i(this,"text",(function(){if(this.length)return this[0].innerText})),i(this,"checked",(function(){if(this.length)return this[0].checked})),i(this,"getWithStyle",(function(e,t){let n=[];return this.forEach((s=>{s.style[e]===t&&n.push(s)})),n})),i(this,"addClass",(function(e){this.forEach((t=>{t.classList.add(e)}))})),i(this,"removeClass",(function(e){this.forEach((t=>{t.classList.remove(e)}))})),i(this,"hasClass",(function(e){if(this.classList.contains(e))return!0})),i(this,"append",(function(e){this[0].appendChild(e)})),i(this,"find",(function(e){return"string"==typeof e?this[0].querySelector(e):this[0].filter((t=>t===e))[0]})),i(this,"findAll",(function(e){if("string"==typeof e)return this[0].querySelectorAll(e)})),i(this,"css",(function(e,t){if(!t)return this[0].style[e];this.forEach((n=>{n.style[e]=t}))}))}on(e,t,n){"function"==typeof t?this.forEach((n=>n.addEventListener(e,t))):this[0].querySelectorAll(t).forEach((t=>{t.addEventListener(e,n)}))}ready(e){this.some((e=>null!=e.readyState&&"loading"!=e.readyState))?e():document.addEventListener("DOMContentLoaded",e)}}function d(e){return"string"==typeof e||e instanceof String?new u(...document.querySelectorAll(e)):new u(e)}},261:function(e,t,n){var s=n(317);document.cookie.match("(^|;)?cn=([^;]*)")?(0,s.$)("#cookie-notice").css("bottom","-100%"):(0,s.$)("#cookie-notice").css("bottom","0"),(0,s.$)("#cn-accept-cookie").on("click",(function(){(function(){const e=new Date;e.setTime(e.getTime()+2592e5),document.cookie="cn=1; expires="+e+"path=/; SameSite=lax"})(),(0,s.$)("#cookie-notice").css("bottom","-100%")}))},546:function(e,t,n){n.d(t,{Z:function(){return i}});var s=n(317);function i(e){let t=(0,s.$)(".adm-content")[0];if(!t)return;let n=document.createElement("div");n.classList.add("message"),n.classList.add("error"),n.innerText=e,t.prepend(n),setTimeout(function(){n.style.scale=0,setTimeout(function(){n.remove()}.bind(this),500)}.bind(this),3e3)}},355:function(e,t,n){var s=n(317);[...(0,s.$)(".search input")].map((e=>{e&&e.addEventListener("input",(function(){!async function(e){let t=e.parentNode,n=(0,s.$)(t).find(".search__result");if(e.value.length<1)return void(n&&(n.innerHTML=""));let i=await fetch("/search?q="+e.value);i=await i.json(i),0!==n.childNodes.length&&(n.innerHTML=""),i.map((e=>{let t=document.createElement("a");t.href=e.alias,t.innerHTML=`<img src='/pic/${e.preview_pic}' alt='${e.name}'>`+e.name,n.appendChild(t)})),(0,s.$)("body").on("click",(function(e){n&&e.target!==n&&(n.innerHTML="")}))}(e)}),!0)}))}},t={};function n(s){var i=t[s];if(void 0!==i)return i.exports;var a=t[s]={exports:{}};return e[s](a,a.exports,n),a.exports}n.d=function(e,t){for(var s in t)n.o(t,s)&&!n.o(e,s)&&Object.defineProperty(e,s,{enumerable:!0,get:t[s]})},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){n(355);var e=n(317);n(261),(0,e.$)(".changepassword").on("click",(async function(t){let n={old_password:(0,e.$)('[name="old_password"]')[0].value,new_password:(0,e.$)('[name="new_password"]')[0].value},s=(0,e.$)(".message")[0],i=await(0,e.v_)("/auth/changepassword",n);i.success?(s.innerText=i.success,(0,e.$)(s).addClass("success"),(0,e.$)(s).removeClass("error")):i.error&&(s.innerText=i.error,(0,e.$)(s).addClass("error"),(0,e.$)(s).removeClass("success"))}));let t=(0,e.$)("[data-auth='login']")[0];t&&(0,e.$)(t).on("click",function(t){let{target:n}=t;n.classList.contains("submit__button")&&function(){let t=e.Gu.email(s.value);return t?(a.innerText="",a.innerText=t,(0,e.$)(a).addClass("error"),!1):"vvoronik@yandex.ru"===s.value||(t=e.Gu.password(i.value),!t)||(a.innerText="",a.innerText=t,(0,e.$)(a).addClass("error"),!1)}()&&async function(){var t,n;let a={email:s.value,password:i.value},o=await(0,e.v_)("/auth/login",a);"employee"===(null==o||null===(t=o.arr)||void 0===t?void 0:t.role)?window.location="/adminsc":"user"===(null==o||null===(n=o.arr)||void 0===n?void 0:n.role)&&(window.location="/auth/cabinet")}()}.bind(void 0));let s=(0,e.$)("input[type = email]")[0],i=(0,e.$)("input[name= password]")[0],a=(0,e.$)(".message")[0],o=(0,e.$)("[data-auth='register']")[0];o&&(0,e.$)(o).on("click",(function(t){let{target:n}=t,s=(0,e.mN)((0,e.$)("input[type = email]")[0].value),i=(0,e.mN)((0,e.$)("input[name = password]")[0].value);n.classList.contains("submit__button")&&function(t,n){let s=e.Gu.email(t),i=(0,e.$)(".message")[0];return s?(i.innerText=i.innerText+s,(0,e.$)(i).addClass("error"),!1):(s=e.Gu.password(n),!s||(i.innerText=i.innerText+s,(0,e.$)(i).addClass("error"),!1))}(s,i)&&async function(t,n){let s=(0,e.$)(".message")[0],i={email:t,password:n,surName:(0,e.$)("[name='surName']")[0].value,name:(0,e.$)("[name='name']")[0].value},a=await(0,e.v_)("/auth/register",i);"confirmed"===a.msg?(s.classList.remove("error"),s.classList.add("success"),s.innerHTML="-Пользователь зарегистрирован.<br>-Для подтверждения регистрации зайдите на почту, <bold>email</bold>.<br> -Перейдите по ссылке в письме."):"mail exists"===a.msg?(s.innerHTML="Эта почта уже зарегистрирована",s.classList.remove("success"),s.classList.add("error")):(s.innerHTML=a.msg,s.classList.remove("success"),s.classList.add("error"))}(s,i)})),(0,e.$)('[data-auth="returnpass"]')[0]&&(0,e.$)(".submit__button").on("click",(async function(t){let n=(0,e.$)('input[type="email"]')[0].value;await(0,e.v_)("/auth/returnpass",{email:n})&&(window.location="/auth/login")})),(0,e.$)("#save").on("click",(async function(t){t.preventDefault();let n={name:(0,e.$)('[name = "name"]')[0].value,surName:(0,e.$)('[name = "surName"]')[0].value,middleName:(0,e.$)('[name = "middleName"]')[0].value,birthDate:(0,e.$)('[name = "birthDate"]')[0].value,phone:(0,e.$)('[name = "phone"]')[0].value,sex:void 0};await(0,e.v_)("/user/edit",n)}));class r{constructor(t,n){return this.container=(0,e.$)(t).first(),this.container?(this.data={},this.setContext(n),this):null}getValue(){let t=[...(0,e.$)("input[type='checkbox']")].filter((e=>e.checked)).map((e=>e.dataset.id));if(t)return t.join(",")}setContext(e){return this.model=e.model,this.data.id=e.id,this}onChange(e){this.container&&(this.container.onchange=function(){let t=this.getValue();this.container.dataset.value=t,this.data[this.container.dataset.field]=t,e.call(this)}.bind(this))}}class c{constructor(t,n){(0,e.$)("[my-checkbox]").on("change",this.changeHandle.bind(t))}async changeHandle(t){let{target:n}=t,s=null==n?void 0:n.dataset.field,i={id:this.id,[s]:+n.checked};await(0,e.v_)(`/adminsc/${this.model}/updateOrCreate`,i)}}!function(){let t=(0,e.$)("[custom-radio]");[].map.call(t,(function(t){(0,e.$)(t).on("click",(function(e){let{target:n}=e,s=n.closest("label");t.dataset.value=s.dataset.value}))}))}(),function(){let t=(0,e.$)("[multi-select] ");t&&[].forEach.call(t,(function(t){t.addEventListener("click",(function(t){let{target:n}=t,s=n.closest("[multi-select]");if(n.closest(".arrow")||["chip-wrap"].includes(n.className))s.querySelector("ul").classList.toggle("show");else if(["view.components.Builders.ListBuilder.del"].includes(n.className))i=n.closest(".chip").dataset.id,(0,e.$)(s).find(`label[data-id='${i}']`).classList.remove("selected"),n.closest(".chip").remove();else if("label"===n.tagName.toLowerCase()){let t=n.dataset.id,i=s.querySelectorAll(".chip"),a=[].some.call(i,(e=>e.dataset.id===t)),o=(0,e.$)(s).find(".chip-wrap");if(a)n.classList.toggle("selected"),o.querySelector(`[data-id='${t}']`).remove();else{n.classList.toggle("selected");let e=function(e){let t=document.createElement("div");t.classList.add("chip"),t.innerText=n.innerText,t.dataset.id=e;let s=document.createElement("div");return s.classList.add("view.components.Builders.ListBuilder.del"),s.innerText="X",t.append(s),t}(t);o.append(e)}}var i}),!1),t.addEventListener("blur",(function(t){let{target:n}=t,s=(0,e.$)(this).find(".show");s&&s.classList.remove("show")}),!1)}))}(),function(){let t=(0,e.$)(".item_wrap")[0];if(t){self.model=t.dataset.model,self.id=+t.dataset.id;let n={model:t.dataset.model,id:+t.dataset.id};(function(){return new r(...arguments)})("[checkboxes]",n).onChange((async function(){await(0,e.v_)(`/adminsc/${this.model}/updateorcreate`,this.data)})),function(){new c(...arguments)}(n),t.onclick=async function(t){let{target:n}=t;this.target=n,n.closest(".save")||n.closest(".detach")||(n.hasAttribute("soft-del")?async function(t){let n=`/adminsc/${t.model}/updateorcreate`,s={deleted_at:(new Date).toLocaleString("ru-RU",{year:"numeric",month:"2-digit",day:"2-digit",hour:"2-digit",hour12:!1,minute:"2-digit"}),id:t.id};await(0,e.v_)(n,s)&&console.log("lk------")}(this):n.classList.contains("tab")?async function(t){let n=(0,e.$)("[data-tab].show")[0],s=(0,e.$)(`[data-tab='${t.dataset.tabId}']`)[0],i=(0,e.$)(".tab.active")[0];n.classList.toggle("show"),s.classList.toggle("show"),i.classList.toggle("active"),t.classList.toggle("active")}(n,this.model):n.getAttribute("type"))}.bind(n),t.onkeyup=(0,e.Ds)(async function(t){let{target:n}=t;if(!n.hasAttribute("contenteditable")||!n.dataset.field)return;let s=n.dataset.field,i={id:this.id,[s]:n.innerText};await(0,e.v_)(`/adminsc/${this.model}/updateOrCreate`,i)}.bind(n))}}(),(0,e.$)(".password-control")&&(0,e.$)(".password-control").on("click",(function(e){let{target:t}=e,n=t.parentNode.querySelector("input");"password"===n.getAttribute("type")?n.setAttribute("type","text"):n.setAttribute("type","password"),t.classList.toggle("view")}))}()}();
//# sourceMappingURL=auth.js.map