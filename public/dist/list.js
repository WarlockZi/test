(()=>{"use strict";var e={317:(e,t,n)=>{n.d(t,{$:()=>c,Ds:()=>o,v_:()=>i});var s=n(546);const o=function(e){let t,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:700;return function(){const s=()=>e.apply(this,arguments);clearTimeout(t),t=setTimeout(s,n)}};function r(e){try{JSON.parse(e)}catch(e){return!1}return!0}let a={show:function(e,t){let n=this.el("div","popup__close");n.innerText="X";let s=this.el("div","popup__item");s.innerText=e,s.append(n);let o=c(".popup")[0];o||(o=this.el("div","popup")),o.append(s),o.addEventListener("click",this.close,!0),document.body.append(o),setTimeout((()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")}),5e3),setTimeout((()=>{s.remove(),t&&t()}),5950)},close:function(e){e.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(e,t){let n=document.createElement(e);return n.classList.add(t),n}};async function i(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(n,o){t.token=document.querySelector('meta[name="token"]').getAttribute("content");let i=new XMLHttpRequest;i.open("POST",e,!0),i.setRequestHeader("X-Requested-With","XMLHttpRequest"),t instanceof FormData?i.send(t):(i.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),i.send("param="+JSON.stringify(t))),i.onerror=function(e){o(Error("Network Error"+e.message))},i.onload=function(){try{var e;if(!r(i.response))return void console.log(i.response);const o=JSON.parse(i.response);let l=c(".message")[0];var t;null!=o&&o.popup||null!=o&&null!==(e=o.arr)&&void 0!==e&&e.popup?a.show(o.popup??(null==o||null===(t=o.arr)||void 0===t?void 0:t.popup)):o.msg?l&&(l.innerHTML=o.msg,c(l).removeClass("success"),c(l).removeClass("error")):o.success?l&&(l.innerHTML=o.success,c(l).addClass("success"),c(l).removeClass("error")):o.error&&(l.innerHTML=o.error,c(l).addClass("error"),c(l).removeClass("success"),(0,s.Z)(o.error)),n(o)}catch(e){return console.log("////////////********* REQUEST ERROR ***********//////////////////////"),console.log(i.response),!1}}}))}class l extends Array{on(e,t,n){"function"==typeof t?this.forEach((n=>n.addEventListener(e,t))):this[0].querySelectorAll(t).forEach((t=>{t.addEventListener(e,n)}))}value=function(){return this[0].getAttribute("value")};first=function(){return this[0]};attr=function(e,t){return t&&this[0].setAttribute(e,t),this[0].getAttribute(e)};selectedIndexValue=function(){if(this.length)return this[0].selectedOptions[0].value};options=function(){if(this.length)return this[0].options};count=function(){return this.length};text=function(){if(this.length)return this[0].innerText};checked=function(){if(this.length)return this[0].checked};getWithStyle=function(e,t){let n=[];return this.forEach((s=>{s.style[e]===t&&n.push(s)})),n};addClass=function(e){this.forEach((t=>{t.classList.add(e)}))};removeClass=function(e){this.forEach((t=>{t.classList.remove(e)}))};hasClass=function(e){if(this.classList.contains(e))return!0};append=function(e){this[0].appendChild(e)};find=function(e){return"string"==typeof e?this[0].querySelector(e):this[0].filter((t=>t===e))[0]};findAll=function(e){if("string"==typeof e)return this[0].querySelectorAll(e)};css=function(e,t){if(!t)return this[0].style[e];this.forEach((n=>{n.style[e]=t}))};ready(e){this.some((e=>null!=e.readyState&&"loading"!=e.readyState))?e():document.addEventListener("DOMContentLoaded",e)}}function c(e){return"string"==typeof e||e instanceof String?new l(...document.querySelectorAll(e)):new l(e)}},546:(e,t,n)=>{n.d(t,{Z:()=>o});var s=n(317);function o(e){let t=(0,s.$)(".adm-content")[0];if(!t)return;let n=document.createElement("div");n.classList.add("message"),n.classList.add("error"),n.innerText=e,t.prepend(n),setTimeout(function(){n.style.scale=0,setTimeout(function(){n.remove()}.bind(this),500)}.bind(this),3e3)}}},t={};function n(s){var o=t[s];if(void 0!==o)return o.exports;var r=t[s]={exports:{}};return e[s](r,r.exports,n),r.exports}n.d=(e,t)=>{for(var s in t)n.o(t,s)&&!n.o(e,s)&&Object.defineProperty(e,s,{enumerable:!0,get:t[s]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e=n(317);class t{constructor(e){let t=e.parentNode;this._morph={},this._morph.relation=t.dataset.morphRelation,this._morph.oneormany=t.dataset.morphOneormany,this._morph.slug=t.dataset.morphSlug,this._morph.path=e.dataset.path??""}get morph(){return this._morph}set morph(e){this._morph=e}}function s(e){return new t(e).morph}const o=(0,e.$)("[custom-list]");o&&[].forEach.call(o,(function(t){const n=(0,e.$)("[contenteditable]"),o=t.querySelectorAll(".head"),r=t.querySelectorAll("[hidden]"),a=t.querySelectorAll("[data-sort]"),i=(0,e.$)(t).findAll(".head input"),l=function(){let n=(0,e.$)(t)[0].querySelectorAll("[data-id]");return[].filter.call(n,(function(e){return"0"!==e.dataset.id}))}(),c=t.dataset.model??null,d=p(),u=(0,e.$)("[custom-select]");async function f(t){let{target:n}=t,s=n.closest("[data-model]"),o=s.dataset.model,r=s.dataset.id,a=s.dataset.field,i=`/adminsc/${o}/updateOrCreate`,l=n.options.selectedIndex,c={[a]:n.options[l].value,id:r};await(0,e.v_)(i,c)}[].forEach.call(u,(e=>{e.onchange=f})),(0,e.$)(t).on("click",function(n){let i=n.target;if("add-model"===i.className)!async function(n){let o={};o.model=n.closest("[custom-list]").dataset.model,o.id=0;let a=t.dataset.relation;a&&(o=function(e,t,n){let s=t.closest(".item-wrap");return e.model=s.dataset.model,e.id=s.dataset.id,e.relation=n,e}(o,t,a)),t.parentNode.dataset.morphRelation&&(o=function(e,t,n){let o=t.closest(".item-wrap");return e.model=o.dataset.model,e.id=o.dataset.id,e.morph=new s(t),e}(o,t));let i=await(0,e.v_)(`/adminsc/${o.model}/updateOrCreate`,o);var l;i.arr.id&&(l=i.arr.id,[].forEach.call(r,(function(n){let s=n.cloneNode(!0);s.removeAttribute("hidden"),(0,e.$)(t).find(".custom-list").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=l:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=l})))}(i);else if(".del:not(.head)"===i.className||i.closest(".del:not(.head)"))!async function(t){if(!confirm("Удалить?"))return;let n=t.dataset.id;await(0,e.v_)(`/adminsc/${c}/delete`,{id:n})&&function(t){let n=(0,e.$)(`[data-id='${t}']`);[].forEach.call(n,(function(e){e.remove()}))}(n)}(i.closest(".del:not(.head)"));else if("edit:not(.head)"===i.className||i.closest(".edit:not(.head)"))n.preventDefault(),function(e){let t=e.closest("[custom-list]").dataset.model,n=e.dataset.id;window.location=`/adminsc/${t}/edit/${n}`}(i);else if(i.classList.contains("head")||i.classList.contains("icon")){let e=i.closest(".head");e.hasAttribute("data-sort")&&function(e){let t=p();const n=m[e]||"asc",s="asc"===n?1:-1,r=Array.from(t);r.sort((function(t,n){const o=t[e].innerHTML,r=n[e].innerHTML,a=v(e,o),i=v(e,r);switch(!0){case a>i:return 1*s;case a<i:return-1*s;case a===i:return 0}})),[].forEach.call(t,(function(e){[].forEach.call(e,(e=>{e.remove()}))})),m[e]="asc"===n?"desc":"asc",r.forEach((function(e){(e=Array.from(e)).reverse(),[].forEach.call(e,(e=>{o[o.length-1].after(e)}))}))}([].findIndex.call(a,((t,n,s)=>t===e)))}}.bind(this)),(0,e.$)(t).on("keyup",function(e){let s=e.target;if(e.cancelBubble=!0,s.hasAttribute("contenteditable"))h(t,n,s);else if(s.closest(".head")){let e=s.closest(".head");!function(e,t){[].forEach.call(d,(e=>{[].forEach.call(e,(e=>{e.style.display="flex"}))}));const n=t.value;[].forEach.call(i,(e=>{e!==t&&(e.value="")})),[].forEach.call(d,(function(t){const s=t[e].innerText,o=new RegExp(`${n}`,"gi");s.match(o)||[].forEach.call(t,(e=>{e.style.display="none"}))}))}([].findIndex.call(o,((t,n,s)=>t===e)),s)}}.bind(this)),(0,e.$)(t).on("paste",function(e){e.target.innerText=e.clipboardData.getData("text/plain"),y(0,0,e.target),e.target.innerText=""}.bind(this));let h=(0,e.Ds)(y);function p(){let n=[];for(let s=0;s<l.length;s++){let o=l[s].dataset.id,r=(0,e.$)(t)[0].querySelectorAll(`[data-id='${o}']`);n.push(r)}return n}const m=Array.from(a).map((function(e){return""}));function v(e,t){if(a[e])return"number"===a[e].getAttribute("data-type")?parseFloat(t):t}function y(t,n,s){if(!s.hasAttribute("contenteditable"))return!1;let o=function(e,t){e.closest("[custom-list]").dataset.model,e.dataset.id;let n=e.dataset.field;return{model:{id:e.dataset.id,[n]:e.innerText},modelName:t}}(s,c);!async function(t){let n=`/adminsc/${t.modelName}/updateOrCreate`;await(0,e.v_)(n,t.model)}(o)}}))})()})();
//# sourceMappingURL=list.js.map