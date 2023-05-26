!function(){"use strict";var t={317:function(t,e,n){n.d(e,{$:function(){return d},Ds:function(){return o},v_:function(){return l}});var s=n(546);function r(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}const o=function(t){let e,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:700;return function(){const s=()=>t.apply(this,arguments);clearTimeout(e),e=setTimeout(s,n)}};function i(t){try{JSON.parse(t)}catch(t){return!1}return!0}let a={show:function(t,e){let n=this.el("div","popup__close");n.innerText="X";let s=this.el("div","popup__item");s.innerText=t,s.append(n);let r=d(".popup")[0];r||(r=this.el("div","popup")),r.append(s),r.addEventListener("click",this.close,!0),document.body.append(r),setTimeout((()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")}),5e3),setTimeout((()=>{s.remove(),e&&e()}),5950)},close:function(t){t.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(t,e){let n=document.createElement(t);return n.classList.add(e),n}};async function l(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(n,r){e.token=document.querySelector('meta[name="token"]').getAttribute("content");let o=new XMLHttpRequest;o.open("POST",t,!0),o.setRequestHeader("X-Requested-With","XMLHttpRequest"),e instanceof FormData?o.send(e):(o.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),o.send("param="+JSON.stringify(e))),o.onerror=function(t){r(Error("Network Error"+t.message))},o.onload=function(){try{var t;if(!i(o.response))return void console.log(o.response);const r=JSON.parse(o.response);let l=d(".message")[0];var e;null!=r&&r.popup||null!=r&&null!==(t=r.arr)&&void 0!==t&&t.popup?a.show(r.popup??(null==r||null===(e=r.arr)||void 0===e?void 0:e.popup)):r.msg?l&&(l.innerHTML=r.msg,l.innerHTML=r.msg,d(l).removeClass("success"),d(l).removeClass("error")):r.success?l&&(l.innerHTML=r.success,d(l).addClass("success"),d(l).removeClass("error")):r.error&&(l.innerHTML=r.error,d(l).addClass("error"),d(l).removeClass("success"),(0,s.Z)(r.error)),n(r)}catch(t){return console.log("////////////********* REQUEST ERROR ***********//////////////////////"),console.log(o.response),!1}}}))}class c extends Array{constructor(){super(...arguments),r(this,"value",(function(){return this[0].getAttribute("value")})),r(this,"first",(function(){return this[0]})),r(this,"attr",(function(t,e){return e&&this[0].setAttribute(t,e),this[0].getAttribute(t)})),r(this,"selectedIndexValue",(function(){if(this.length)return this[0].selectedOptions[0].value})),r(this,"options",(function(){if(this.length)return this[0].options})),r(this,"count",(function(){return this.length})),r(this,"text",(function(){if(this.length)return this[0].innerText})),r(this,"checked",(function(){if(this.length)return this[0].checked})),r(this,"getWithStyle",(function(t,e){let n=[];return this.forEach((s=>{s.style[t]===e&&n.push(s)})),n})),r(this,"addClass",(function(t){this.forEach((e=>{e.classList.add(t)}))})),r(this,"removeClass",(function(t){this.forEach((e=>{e.classList.remove(t)}))})),r(this,"hasClass",(function(t){if(this.classList.contains(t))return!0})),r(this,"append",(function(t){this[0].appendChild(t)})),r(this,"find",(function(t){return"string"==typeof t?this[0].querySelector(t):this[0].filter((e=>e===t))[0]})),r(this,"findAll",(function(t){if("string"==typeof t)return this[0].querySelectorAll(t)})),r(this,"css",(function(t,e){if(!e)return this[0].style[t];this.forEach((n=>{n.style[t]=e}))}))}on(t,e,n){"function"==typeof e?this.forEach((n=>n.addEventListener(t,e))):this[0].querySelectorAll(e).forEach((e=>{e.addEventListener(t,n)}))}ready(t){this.some((t=>null!=t.readyState&&"loading"!=t.readyState))?t():document.addEventListener("DOMContentLoaded",t)}}function d(t){return"string"==typeof t||t instanceof String?new c(...document.querySelectorAll(t)):new c(t)}},546:function(t,e,n){n.d(e,{Z:function(){return r}});var s=n(317);function r(t){let e=(0,s.$)(".adm-content")[0];if(!e)return;let n=document.createElement("div");n.classList.add("message"),n.classList.add("error"),n.innerText=t,e.prepend(n),setTimeout(function(){n.style.scale=0,setTimeout(function(){n.remove()}.bind(this),500)}.bind(this),3e3)}}},e={};function n(s){var r=e[s];if(void 0!==r)return r.exports;var o=e[s]={exports:{}};return t[s](o,o.exports,n),o.exports}n.d=function(t,e){for(var s in e)n.o(e,s)&&!n.o(t,s)&&Object.defineProperty(t,s,{enumerable:!0,get:e[s]})},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},function(){var t=n(317);class e{constructor(t){let e=t.parentNode;return this._morph={},this._morph.relation=e.dataset.morphRelation,this._morph.oneormany=e.dataset.morphOneormany,this._morph.slug=e.dataset.morphSlug,this._morph.path=t.dataset.path??"",this}get morph(){return this._morph}set morph(t){this._morph=t}}function s(t){return new e(t).morph}const r=(0,t.$)("[custom-list]");r&&[].forEach.call(r,(function(e){const n=(0,t.$)("[contenteditable]"),r=e.querySelectorAll(".head"),o=e.querySelectorAll("[hidden]"),i=e.querySelectorAll("[data-sort]"),a=(0,t.$)(e).findAll(".head input"),l=function(){let n=(0,t.$)(e)[0].querySelectorAll("[data-id]");return[].filter.call(n,(function(t){return"0"!==t.dataset.id}))}(),c=e.dataset.model??null,d=p(),u=(0,t.$)("[custom-select]");async function h(e){let{target:n}=e,s=n.closest("[data-model]"),r=s.dataset.model,o=s.dataset.id,i=s.dataset.field,a=`/adminsc/${r}/updateOrCreate`,l=n.options.selectedIndex,c={[i]:n.options[l].value,id:o};await(0,t.v_)(a,c)}[].forEach.call(u,(t=>{t.onchange=h})),(0,t.$)(e).on("click",function(n){let a=n.target;if("add-model"===a.className)!async function(n){let r={};r.model=n.closest("[custom-list]").dataset.model,r.id=0;let i=e.dataset.relation;i&&(r=function(t,e,n){let s=e.closest(".item_wrap");return t.model=s.dataset.model,t.id=s.dataset.id,t.relation=n,t}(r,e,i)),e.parentNode.dataset.morphRelation&&(r=function(t,e,n){let r=e.closest(".item_wrap");return t.model=r.dataset.model,t.id=r.dataset.id,t.morph=new s(e),t}(r,e));let a=await(0,t.v_)(`/adminsc/${r.model}/updateOrCreate`,r);var l;a.arr.id&&(l=a.arr.id,[].forEach.call(o,(function(n){let s=n.cloneNode(!0);s.removeAttribute("hidden"),(0,t.$)(e).find(".custom-list").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=l:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=l})))}(a);else if(".del:not(.head)"===a.className||a.closest(".del:not(.head)"))!async function(e){if(!confirm("Удалить?"))return;let n=e.dataset.id;await(0,t.v_)(`/adminsc/${c}/delete`,{id:n})&&function(e){let n=(0,t.$)(`[data-id='${e}']`);[].forEach.call(n,(function(t){t.remove()}))}(n)}(a.closest(".del:not(.head)"));else if("edit:not(.head)"===a.className||a.closest(".edit:not(.head)"))n.preventDefault(),function(t){let e=t.closest("[custom-list]").dataset.model,n=t.dataset.id;window.location=`/adminsc/${e}/edit/${n}`}(a);else if(a.classList.contains("head")||a.classList.contains("icon")){let t=a.closest(".head");t.hasAttribute("data-sort")&&function(t){let e=p();const n=m[t]||"asc",s="asc"===n?1:-1,o=Array.from(e);o.sort((function(e,n){const r=e[t].innerHTML,o=n[t].innerHTML,i=v(t,r),a=v(t,o);switch(!0){case i>a:return 1*s;case i<a:return-1*s;case i===a:return 0}})),[].forEach.call(e,(function(t){[].forEach.call(t,(t=>{t.remove()}))})),m[t]="asc"===n?"desc":"asc",o.forEach((function(t){(t=Array.from(t)).reverse(),[].forEach.call(t,(t=>{r[r.length-1].after(t)}))}))}([].findIndex.call(i,((e,n,s)=>e===t)))}}.bind(this)),(0,t.$)(e).on("keyup",function(t){let s=t.target;if(t.cancelBubble=!0,s.hasAttribute("contenteditable"))f(e,n,s);else if(s.closest(".head")){let t=s.closest(".head");!function(t,e){[].forEach.call(d,(t=>{[].forEach.call(t,(t=>{t.style.display="flex"}))}));const n=e.value;[].forEach.call(a,(t=>{t!==e&&(t.value="")})),[].forEach.call(d,(function(e){const s=e[t].innerText,r=new RegExp(`${n}`,"gi");s.match(r)||[].forEach.call(e,(t=>{t.style.display="none"}))}))}([].findIndex.call(r,((e,n,s)=>e===t)),s)}}.bind(this)),(0,t.$)(e).on("paste",function(t){t.target.innerText=t.clipboardData.getData("text/plain"),y(0,0,t.target),t.target.innerText=""}.bind(this));let f=(0,t.Ds)(y);function p(){let n=[];for(let s=0;s<l.length;s++){let r=l[s].dataset.id,o=(0,t.$)(e)[0].querySelectorAll(`[data-id='${r}']`);n.push(o)}return n}const m=Array.from(i).map((function(t){return""}));function v(t,e){if(i[t])return"number"===i[t].getAttribute("data-type")?parseFloat(e):e}function y(e,n,s){if(!s.hasAttribute("contenteditable"))return!1;let r=function(t,e){t.closest("[custom-list]").dataset.model,t.dataset.id;let n=t.dataset.field;return{model:{id:t.dataset.id,[n]:t.innerText},modelName:e}}(s,c);!async function(e){let n=`/adminsc/${e.modelName}/updateOrCreate`;await(0,t.v_)(n,e.model)}(r)}}))}()}();
//# sourceMappingURL=list.js.map