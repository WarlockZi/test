!function(){"use strict";var t={317:function(t,e,n){function i(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}n.d(e,{$:function(){return l},Ds:function(){return r},v_:function(){return o}});const r=function(t){let e,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:700;return function(){const i=()=>t.apply(this,arguments);clearTimeout(e),e=setTimeout(i,n)}};let s={show:function(t,e){let n=this.el("div","popup__close");n.innerText="X";let i=this.el("div","popup__item");i.innerText=t,i.append(n);let r=l(".popup")[0];r||(r=this.el("div","popup")),r.append(i),r.addEventListener("click",this.close,!0),document.body.append(r),setTimeout((()=>{i.classList.remove("popup__item"),i.classList.add("popup-hide")}),5e3),setTimeout((()=>{i.remove(),e&&e()}),5950)},close:function(t){t.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(t,e){let n=document.createElement(t);return n.classList.add(e),n}};async function o(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(n,i){e.token=document.querySelector('meta[name="token"]').getAttribute("content");let r=new XMLHttpRequest;r.open("POST",t,!0),r.setRequestHeader("X-Requested-With","XMLHttpRequest"),e instanceof FormData?r.send(e):(r.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),r.send("param="+JSON.stringify(e))),r.onerror=function(t){i(Error("Network Error"+t))},r.onload=function(){var t;let e=JSON.parse(r.response),i=l(".message")[0];var o;e.popup||null!=e&&null!==(t=e.arr)&&void 0!==t&&t.popup?s.show(e.popup??(null==e||null===(o=e.arr)||void 0===o?void 0:o.popup)):e.msg?i&&(i.innerHTML=e.msg,i.innerHTML=e.msg,l(i).removeClass("success"),l(i).removeClass("error")):e.success?i&&(i.innerHTML=e.success,l(i).addClass("success"),l(i).removeClass("error")):e.error&&i&&(i.innerHTML="",i.innerHTML=e.error,l(i).removeClass("success"),l(i).addClass("error")),n(e)}}))}class a extends Array{constructor(){super(...arguments),i(this,"value",(function(){return this[0].getAttribute("value")})),i(this,"attr",(function(t, e){return e&&this[0].setAttribute(t,e),this[0].getAttribute(t)})),i(this,"selectedIndexValue",(function(){if(this.length)return this[0].selectedOptions[0].value})),i(this,"options",(function(){if(this.length)return this[0].options})),i(this,"count",(function(){return this.length})),i(this,"text",(function(){if(this.length)return this[0].innerText})),i(this,"checked",(function(){if(this.length)return this[0].checked})),i(this,"getWithStyle",(function(t,e){let n=[];return this.forEach((i=>{i.style[t]===e&&n.push(i)})),n})),i(this,"addClass",(function(t){this.forEach((e=>{e.classList.add(t)}))})),i(this,"removeClass",(function(t){this.forEach((e=>{e.classList.remove(t)}))})),i(this,"hasClass",(function(t){if(this.classList.contains(t))return!0})),i(this,"append",(function(t){this[0].appendChild(t)})),i(this,"find",(function(t){return"string"==typeof t?this[0].querySelector(t):this[0].filter((e=>e===t))[0]})),i(this,"findAll",(function(t){if("string"==typeof t)return this[0].querySelectorAll(t)})),i(this,"css",(function(t,e){if(!e)return this[0].style[t];this.forEach((n=>{n.style[t]=e}))}))}on(t,e,n){"function"==typeof e?this.forEach((n=>n.addEventListener(t,e))):this.forEach((i=>{i.addEventListener(t,(t=>{t.target===e&&n(t)}))}))}ready(t){this.some((t=>null!=t.readyState&&"loading"!=t.readyState))?t():document.addEventListener("DOMContentLoaded",t)}}function l(t){return"string"==typeof t||t instanceof String?new a(...document.querySelectorAll(t)):new a(t)}}},e={};function n(i){var r=e[i];if(void 0!==r)return r.exports;var s=e[i]={exports:{}};return t[i](s,s.exports,n),s.exports}n.d=function(t,e){for(var i in e)n.o(e,i)&&!n.o(t,i)&&Object.defineProperty(t,i,{enumerable:!0,get:e[i]})},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},function(){var t=n(317);const e=(0,t.$)(".custom-list__wrapper");e&&[].forEach.call(e,(function(e){const n=(0,t.$)("[contenteditable]"),i=e.querySelectorAll(".head"),r=e.querySelectorAll("[hidden]"),s=e.querySelectorAll("[data-sort]"),o=(0,t.$)(e).findAll(".head input"),a=function(){let n=(0,t.$)(e)[0].querySelectorAll("[data-id]");return[].filter.call(n,(function(t){return"0"!==t.dataset.id}))}(),l=e.dataset.model,c=e.dataset.parent??null,u=e.dataset.parentid??null,d=e.dataset.morph??null,f=e.dataset.morphid??null,h=v();(0,t.$)(e).on("click",function(e){let n=e.target;if("add-model"===n.className)!async function(e,n,i,r,s){let o=arguments.length>5&&void 0!==arguments[5]?arguments[5]:0,a={};n&&(a={[n+"_id"]:+i}),r&&(a={morph_type:r,morph_id:s}),a.id=o;let l=await(0,t.v_)(`/adminsc/${e}/updateOrCreate`,a);l.arr.id&&m(l.arr.id)}(l,c,u,d,f,0);else if(".del:not(.head)"===n.className||n.closest(".del:not(.head)"))!async function(e){if(!confirm("Удалить?"))return;let n=e.dataset.id;await(0,t.v_)(`/adminsc/${l}/delete`,{id:n})&&function(e){let n=(0,t.$)(`[data-id='${e}']`);[].forEach.call(n,(function(t){t.remove()}))}(n)}(n.closest(".del:not(.head)"));else if(".edit:not(.head)"===n.className||n.closest(".edit:not(.head)"))e.preventDefault(),function(t,e){let n=t.closest(".edit:not(.head)").dataset.id;window.location=`/adminsc/${e}/edit/${n}`}(n,l);else if(n.classList.contains("head")||n.classList.contains("icon")){let t=n.closest(".head");t.hasAttribute("data-sort")&&function(t){let e=v();const n=y[t]||"asc",r="asc"===n?1:-1,s=Array.from(e);s.sort((function(e,n){const i=e[t].innerHTML,s=n[t].innerHTML,o=g(t,i),a=g(t,s);switch(!0){case o>a:return 1*r;case o<a:return-1*r;case o===a:return 0}})),[].forEach.call(e,(function(t){[].forEach.call(t,(t=>{t.remove()}))})),y[t]="asc"===n?"desc":"asc",s.forEach((function(t){(t=Array.from(t)).reverse(),[].forEach.call(t,(t=>{i[i.length-1].after(t)}))}))}([].findIndex.call(s,((e,n,i)=>e===t)))}}.bind(this)),(0,t.$)(e).on("keyup",function(t){let{target:r}=t;if(r.hasAttribute("contenteditable"))p(e,n,r);else if(r.closest(".head")){let t=r.closest(".head");!function(t,e){[].forEach.call(h,(t=>{[].forEach.call(t,(t=>{t.style.display="flex"}))}));const n=e.value;[].forEach.call(o,(t=>{t!==e&&(t.value="")})),[].forEach.call(h,(function(e){const i=e[t].innerText,r=new RegExp(`${n}`,"gi");i.match(r)||[].forEach.call(e,(t=>{t.style.display="none"}))}))}([].findIndex.call(i,((e,n,i)=>e===t)),r)}}.bind(this)),(0,t.$)(e).on("paste",function(t){let e=t.clipboardData.getData("text/plain");t.target.innerText=e,E(0,0,t.target),t.target.innerText=""}.bind(this));let p=(0,t.Ds)(E);function m(n){let i=[...r];[].forEach.call(i,(function(i){let r=i.cloneNode(!0);r.removeAttribute("hidden"),(0,t.$)(e).find(".custom-list").appendChild(r),["id"].includes(r.dataset.field)?r.innerText=n:["del","edit","save"].includes(r.className)||(r.innerText=""),r.dataset.id=n}))}function v(){let n=[];for(let i=0;i<a.length;i++){let r=a[i].dataset.id,s=(0,t.$)(e)[0].querySelectorAll(`[data-id='${r}']`);n.push(s)}return n}const y=Array.from(s).map((function(t){return""}));function g(t,e){if(s[t])return"number"===s[t].getAttribute("data-type")?parseFloat(e):e}function E(e,n,i){if(!i.hasAttribute("contenteditable"))return!1;!async function(e){let n=`/adminsc/${e.modelName}/updateOrCreate`;await(0,t.v_)(n,e.model)}(b(i,l))}function b(t,n){let i=t.dataset.field,r=e.dataset.parent+"_id",s=e.dataset.parentid,o={model:{id:t.dataset.id,[i]:t.innerText},modelName:n};return r&&(o.model[r]=s),o}}))}()}();
//# sourceMappingURL=list.js.map