(()=>{"use strict";var t,e={317:(t,e,n)=>{function i(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}n.d(e,{$:()=>o,d8:()=>c,ej:()=>r}),n(546);class s extends Array{constructor(){super(...arguments),i(this,"value",(function(){return this[0].getAttribute("value")})),i(this,"first",(function(){return this[0]})),i(this,"attr",(function(t,e){return e&&this[0].setAttribute(t,e),this[0].getAttribute(t)})),i(this,"selectedIndexValue",(function(){if(this.length)return this[0].selectedOptions[0].value})),i(this,"options",(function(){if(this.length)return this[0].options})),i(this,"count",(function(){return this.length})),i(this,"text",(function(){if(this.length)return this[0].innerText})),i(this,"checked",(function(){if(this.length)return this[0].checked})),i(this,"getWithStyle",(function(t,e){let n=[];return this.forEach((i=>{i.style[t]===e&&n.push(i)})),n})),i(this,"addClass",(function(t){this.forEach((e=>{e.classList.add(t)}))})),i(this,"removeClass",(function(t){this.forEach((e=>{e.classList.remove(t)}))})),i(this,"hasClass",(function(t){if(this.classList.contains(t))return!0})),i(this,"append",(function(t){this[0].appendChild(t)})),i(this,"find",(function(t){return"string"==typeof t?this[0].querySelector(t):this[0].filter((e=>e===t))[0]})),i(this,"findAll",(function(t){if("string"==typeof t)return this[0].querySelectorAll(t)})),i(this,"css",(function(t,e){if(!e)return this[0].style[t];this.forEach((n=>{n.style[t]=e}))}))}on(t,e,n){"function"==typeof e?this.forEach((n=>n.addEventListener(t,e))):this[0].querySelectorAll(e).forEach((e=>{e.addEventListener(t,n)}))}ready(t){this.some((t=>null!=t.readyState&&"loading"!=t.readyState))?t():document.addEventListener("DOMContentLoaded",t)}}function o(t){return"string"==typeof t||t instanceof String?new s(...document.querySelectorAll(t)):new s(t)}function r(t){let e=document.cookie.match("(^|;)?"+t+"=([^;]*)");return!!e&&e[2]}function c(t,e,n,i){let s=arguments.length>4&&void 0!==arguments[4]?arguments[4]:"/",o={s:1,m:60,h:3600,d:86400,w:604800,M:2592e3,y:31536e3},r=new Date;r.setTime(r.getTime()+n*o.unit),document.cookie=`${t}=${e}; expires=${r} path=${s}; SameSite=lax`}},546:(t,e,n)=>{n(317)}},n={};function i(t){var s=n[t];if(void 0!==s)return s.exports;var o=n[t]={exports:{}};return e[t](o,o.exports,i),o.exports}i.d=(t,e)=>{for(var n in e)i.o(e,n)&&!i.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},i.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(0,(t=i(317)).ej)("cn")?(0,t.$)("#cookie-notice").css("bottom","-100%"):(0,t.$)("#cookie-notice").css("bottom","0"),(0,t.$)("#cn-accept-cookie").on("click",(function(){(0,t.d8)("cn",1,3,"Gol.js"),(0,t.$)("#cookie-notice").css("bottom","-100%")}))})();
//# sourceMappingURL=cookie.js.map