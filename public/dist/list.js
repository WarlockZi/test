(()=>{"use strict";var e={448:(e,t,n)=>{n.d(t,{$:()=>l,bE:()=>a,sg:()=>r});var s=n(869);new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2});const r=function(e){let t,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:700;return function(){clearTimeout(t),t=setTimeout((()=>e.apply(this,arguments)),n)}};let o={show:function(e,t){let n=this.el("div","popup__close");n.innerText="X";let s=this.el("div","popup__item");s.innerText=e,s.append(n);let r=l(".popup")[0];r||(r=this.el("div","popup")),r.append(s),r.addEventListener("click",this.close,!0),document.body.append(r),setTimeout((()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")}),5e3),setTimeout((()=>{s.remove(),t&&t()}),5950)},close:function(e){e.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(e,t){let n=document.createElement(e);return n.classList.add(t),n}};async function a(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(n,r){t.token=document.querySelector('meta[name="token"]').getAttribute("content");let a=new XMLHttpRequest;a.open("POST",e,!0),a.setRequestHeader("X-Requested-With","XMLHttpRequest"),t instanceof FormData?a.send(t):(a.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),a.send("param="+JSON.stringify(t))),a.onerror=function(e){r(Error("Network Error"+e.message))},a.onload=function(){try{var e;if(!function(e){try{JSON.parse(e)}catch(e){return!1}return!0}(a.response))return void console.log(a.response);const r=JSON.parse(a.response);let i=l(".message")[0];var t;null!=r&&r.popup||null!=r&&null!==(e=r.arr)&&void 0!==e&&e.popup?o.show(r.popup??(null==r||null===(t=r.arr)||void 0===t?void 0:t.popup)):r.msg?i&&(i.innerHTML=r.msg,l(i).removeClass("success"),l(i).removeClass("error")):r.success?i&&(i.innerHTML=r.success,l(i).addClass("success"),l(i).removeClass("error")):r.error&&(i.innerHTML=r.error,l(i).addClass("error"),l(i).removeClass("success"),(0,s.A)(r.error)),n(r)}catch(e){return console.log("////////////********* REQUEST ERROR ***********//////////////////////"),console.log(a.response),!1}}}))}class i extends Array{on(e,t,n){"function"==typeof t?this.forEach((n=>n.addEventListener(e,t))):this[0].querySelectorAll(t).forEach((t=>{t.addEventListener(e,n)}))}value=function(){return this[0].getAttribute("value")};first=function(){return this[0]};attr=function(e,t){return t&&this[0].setAttribute(e,t),this[0].getAttribute(e)};selectedIndexValue=function(){if(this.length)return this[0].selectedOptions[0].value};options=function(){if(this.length)return this[0].options};count=function(){return this.length};text=function(){if(this.length)return this[0].innerText};checked=function(){if(this.length)return this[0].checked};getWithStyle=function(e,t){let n=[];return this.forEach((s=>{s.style[e]===t&&n.push(s)})),n};addClass=function(e){this.forEach((t=>{t.classList.add(e)}))};removeClass=function(e){this.forEach((t=>{t.classList.remove(e)}))};hasClass=function(e){if(this.classList.contains(e))return!0};append=function(e){this[0].appendChild(e)};find=function(e){return"string"==typeof e?this[0].querySelector(e):this[0].filter((t=>t===e))[0]};findAll=function(e){if("string"==typeof e)return this[0].querySelectorAll(e)};css=function(e,t){if(!t)return this[0].style[e];this.forEach((n=>{n.style[e]=t}))};ready(e){this.some((e=>null!=e.readyState&&"loading"!=e.readyState))?e():document.addEventListener("DOMContentLoaded",e)}}function l(e){return"string"==typeof e||e instanceof String?new i(...document.querySelectorAll(e)):new i(e)}},869:(e,t,n)=>{n.d(t,{A:()=>r});var s=n(448);function r(e){let t=(0,s.$)(".adm-content")[0];if(!t)return;let n=document.createElement("div");n.classList.add("message"),n.classList.add("error"),n.innerText=e,t.prepend(n),setTimeout(function(){n.style.scale=0,setTimeout(function(){n.remove()}.bind(this),500)}.bind(this),3e3)}}},t={};function n(s){var r=t[s];if(void 0!==r)return r.exports;var o=t[s]={exports:{}};return e[s](o,o.exports,n),o.exports}n.d=(e,t)=>{for(var s in t)n.o(t,s)&&!n.o(e,s)&&Object.defineProperty(e,s,{enumerable:!0,get:t[s]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e=n(448);class t{constructor(e){let t=e.parentNode;this._morph={},this._morph.relation=t.dataset.morphRelation,this._morph.oneormany=t.dataset.morphOneormany,this._morph.slug=t.dataset.morphSlug,this._morph.path=e.dataset.path??""}get morph(){return this._morph}set morph(e){this._morph=e}}function s(e){return new t(e).morph}const r=(0,e.$)("[custom-list]");r&&[].forEach.call(r,(function(t){const n=(0,e.$)("[contenteditable]"),r=t.querySelectorAll(".head"),o=t.querySelectorAll("[hidden]"),a=t.querySelectorAll("[data-sort]"),i=(0,e.$)(t).findAll(".head input"),l=function(){let n=(0,e.$)(t)[0].querySelectorAll("[data-id]");return[].filter.call(n,(function(e){return"0"!==e.dataset.id}))}(),c=t.dataset.model??null,d=p(),u=(0,e.$)("[custom-select]");async function f(t){let{target:n}=t,s=n.closest("[data-model]"),r=s.dataset.model,o=s.dataset.id,a=s.dataset.field,i=`/adminsc/${r}/updateOrCreate`,l=n.options.selectedIndex,c={[a]:n.options[l].value,id:o};await(0,e.bE)(i,c)}[].forEach.call(u,(e=>{e.onchange=f})),(0,e.$)(t).on("click",function(n){let i=n.target;if("add-model"===i.className)!async function(n){let r={};r.model=n.closest("[custom-list]").dataset.model,r.id=0;let a=t.dataset.relation;a&&(r=function(e,t,n){let s=t.closest(".item-wrap");return e.model=s.dataset.model,e.id=s.dataset.id,e.relation=n,e}(r,t,a)),t.parentNode.dataset.morphRelation&&(r=function(e,t,n){let r=t.closest(".item-wrap");return e.model=r.dataset.model,e.id=r.dataset.id,e.morph=new s(t),e}(r,t));let i=await(0,e.bE)(`/adminsc/${r.model}/updateOrCreate`,r);var l;i.arr.id&&(l=i.arr.id,[].forEach.call(o,(function(n){let s=n.cloneNode(!0);s.removeAttribute("hidden"),(0,e.$)(t).find(".custom-list").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=l:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=l})))}(i);else if(".del:not(.head)"===i.className||i.closest(".del:not(.head)"))!async function(t){if(!confirm("Удалить?"))return;let n=t.dataset.id;await(0,e.bE)(`/adminsc/${c}/delete`,{id:n})&&function(t){let n=(0,e.$)(`[data-id='${t}']`);[].forEach.call(n,(function(e){e.remove()}))}(n)}(i.closest(".del:not(.head)"));else if("edit:not(.head)"===i.className||i.closest(".edit:not(.head)"))n.preventDefault(),function(e){let t=e.closest("[custom-list]").dataset.model,n=e.dataset.id;window.location=`/adminsc/${t}/edit/${n}`}(i);else if(i.classList.contains("head")||i.classList.contains("icon")){let e=i.closest(".head");e.hasAttribute("data-sort")&&function(e){let t=p();const n=m[e]||"asc",s="asc"===n?1:-1,o=Array.from(t);o.sort((function(t,n){const r=t[e].innerHTML,o=n[e].innerHTML,a=y(e,r),i=y(e,o);switch(!0){case a>i:return 1*s;case a<i:return-1*s;case a===i:return 0}})),[].forEach.call(t,(function(e){[].forEach.call(e,(e=>{e.remove()}))})),m[e]="asc"===n?"desc":"asc",o.forEach((function(e){(e=Array.from(e)).reverse(),[].forEach.call(e,(e=>{r[r.length-1].after(e)}))}))}([].findIndex.call(a,((t,n,s)=>t===e)))}}.bind(this)),(0,e.$)(t).on("keyup",function(e){let s=e.target;if(e.cancelBubble=!0,s.hasAttribute("contenteditable"))h(t,n,s);else if(s.closest(".head")){let e=s.closest(".head");!function(e,t){[].forEach.call(d,(e=>{[].forEach.call(e,(e=>{e.style.display="flex"}))}));const n=t.value;[].forEach.call(i,(e=>{e!==t&&(e.value="")})),[].forEach.call(d,(function(t){const s=t[e].innerText,r=new RegExp(`${n}`,"gi");s.match(r)||[].forEach.call(t,(e=>{e.style.display="none"}))}))}([].findIndex.call(r,((t,n,s)=>t===e)),s)}}.bind(this)),(0,e.$)(t).on("paste",function(e){e.target.innerText=e.clipboardData.getData("text/plain"),v(0,0,e.target),e.target.innerText=""}.bind(this));let h=(0,e.sg)(v);function p(){let n=[];for(let s=0;s<l.length;s++){let r=l[s].dataset.id,o=(0,e.$)(t)[0].querySelectorAll(`[data-id='${r}']`);n.push(o)}return n}const m=Array.from(a).map((function(e){return""}));function y(e,t){if(a[e])return"number"===a[e].getAttribute("data-type")?parseFloat(t):t}function v(t,n,s){if(!s.hasAttribute("contenteditable"))return!1;let r=function(e,t){e.closest("[custom-list]").dataset.model,e.dataset.id;let n=e.dataset.field;return{model:{id:e.dataset.id,[n]:e.innerText},modelName:t}}(s,c);!async function(t){let n=`/adminsc/${t.modelName}/updateOrCreate`;await(0,e.bE)(n,t.model)}(r)}}))})()})();
//# sourceMappingURL=list.js.map