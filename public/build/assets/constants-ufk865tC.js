const v="modulepreload",w=function(t){return"/public/build/"+t},m={},x=function(e,n,s){let o=Promise.resolve();if(n&&n.length>0){document.getElementsByTagName("link");const r=document.querySelector("meta[property=csp-nonce]"),i=r?.nonce||r?.getAttribute("nonce");o=Promise.allSettled(n.map(l=>{if(l=w(l),l in m)return;m[l]=!0;const u=l.endsWith(".css"),f=u?'[rel="stylesheet"]':"";if(document.querySelector(`link[href="${l}"]${f}`))return;const a=document.createElement("link");if(a.rel=u?"stylesheet":v,u||(a.as="script"),a.crossOrigin="",a.href=l,i&&a.setAttribute("nonce",i),document.head.appendChild(a),u)return new Promise((h,d)=>{a.addEventListener("load",h),a.addEventListener("error",()=>d(new Error(`Unable to preload CSS for ${l}`)))})}))}function c(r){const i=new Event("vite:preloadError",{cancelable:!0});if(i.payload=r,window.dispatchEvent(i),!i.defaultPrevented)throw r}return o.then(r=>{for(const i of r||[])i.status==="rejected"&&c(i.reason);return e().catch(c)})},S=()=>{const t=document.documentElement.scrollTop||document.body.scrollTop;t>0&&(window.requestAnimationFrame(S),window.scrollTo(0,t-t/8))},F=new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2});function M(t,e,n=new FormData){if(self.formData=n,typeof e=="FileList")for(let s=0;s<e.length;s++)self.formData.append(s,e[s]);else self.formData.append("file",e);return self.createFormData=function(s,o=""){for(let c in s){let r=s[c],i=o?o+"["+c+"]":c;typeof r=="string"||typeof r=="number"?self.formData.append(i,r):typeof r=="object"&&self.createFormData(r,i)}},self.createFormData(t),self.formData}const R=(t,e=700)=>{let n;return function(){const s=()=>t.apply(this,arguments);clearTimeout(n),n=setTimeout(s,e)}};function _(t){try{JSON.parse(t)}catch{return!1}return!0}const b={show:function(t){const e=this.el("div","popup"),n=this.el("div","popup__close");n.innerText="X";const s=this.el("div","popup__item");s.innerText=t,s.append(n),e.append(s),e.addEventListener("click",this.close,!0),document.body.append(e);const o=5e3;setTimeout(()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")},o);const c=o+950;setTimeout(()=>{s.remove()},c)},close:function({target:t}){t.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(t,e){const n=document.createElement(t);return n.classList.add(e),n}};function L(){return document.querySelector('meta[name="phpSession"]').getAttribute("content")??null}function C(t){if(!t)return;const e={"&":"&amp;","<":"&lt;",">":"&gt;","'":"&#39;","(":"&fp",")":"&bp","/":"&fs","\\":"&bs",";":"&sc","|":"&or","?php":"&?php",delete:"&del"},n=/[&<>'()\/\\;]/gi;return t.replace(n,s=>e[s])}function P(t){const n=[],s=/[a-zA-Z0-9\@\-\_\.А-я]*/;return t.length||n.push("Поле не должно быть пустым"),t.replace(s,"").length&&n.push("Разрешены только английские"),t.length<6&&n.push("Длина меньше 6 символов"),n}function N(t){const e=decodeURI(t),n=2,s="(.){2,}@(.){2,}",o=".",c="^(.){2,}@(.){2,}.(.){2,}$",r=[],i=/[a-zA-Z0-9\@\-\_\.]*/;return e.length||r.push("Поле не должно быть пустым"),e.replace(i,"").length&&r.push("Разрешены только английские"),e.length<n&&r.push("Длина меньше 2 символов"),/[\@]/.test(e)||r.push("Нет знака @"),e.match(s)||r.push("Меньше 2 знаков после @"),e.includes(o)||r.push("Нет точки"),e.match(c)||r.push("Меньше 2 знаков После точки"),r}function k(t,e="",n=""){let s=document.createElement(t);return e&&s.classList.add(e),s.innerText=n||"",s}class O{constructor(){this.attributes=[]}tag(e){return this.tag=e,this}className(e){return this._className=e,this}field(e){return this._field=e,this}text(e){return this._text=e,this}html(e){return this._html=e,this}attr(e,n){return this.attributes.push([e,n]),this}get(){let e=document.createElement(this.tag);return this._text&&(e.innerText=this._text),this._html&&(e.innerHTML=this._html),this._className&&e.classList.add(this._className),this._field&&(e.dataset.field=this._field),this.attributes.forEach((n,s)=>{e.setAttribute(n[0],n[1])}),e}}async function J(t,e={}){const n=T(t,e),s=await A(t,n).catch(o=>{console.log(o)});return D(s),y(s),s}function T(t,e){e.phpSession=L();const n={"X-Requested-With":"XMLHttpRequest"};if(!(e instanceof FormData))n["Content-Type"]="application/x-www-form-urlencoded";else return{method:"POST",body:e};return{method:"POST",headers:n,body:"params="+JSON.stringify(e)}}function A(t,e){return new Promise(async(n,s)=>{await fetch(t,e).then(async o=>{if(o.status===200){const c=await o.json();n(c)}}).catch(o=>{console.log("Fetch error"+o.message),s(o.message)})})}function y(t){const e=p(".message")[0];if(!e)return!1;t.msg?e.innerHTML=t.msg:t.success?e.innerHTML=t.success:t.error&&(e.innerHTML=t.error),p(e).removeClass("success"),p(e).removeClass("error")}function D(t){try{return t?.arr?.popup?b.show(t?.arr?.popup):y(t),t}catch{return console.log("////////////********* REQUEST ERROR ***********//////////////////////"),_(t.response)?console.log(JSON.parse(t.response)):console.log(t.response),!1}}class g extends Array{on(e,n,s){typeof n=="function"?this.forEach(o=>o.addEventListener(e,n)):this[0].querySelectorAll(n).forEach(c=>{c.addEventListener(e,s)})}value=function(){return this[0].getAttribute("value")};first=function(){return this[0]};attr=function(e,n){return n&&this[0].setAttribute(e,n),this[0].getAttribute(e)};selectedIndexValue=function(){if(this.length)return this[0].selectedOptions[0].value};options=function(){if(this.length)return this[0].options};count=function(){return this.length};text=function(){if(this.length)return this[0].innerText};checked=function(){if(this.length)return this[0].checked};getWithStyle=function(e,n){let s=[];return this.forEach(o=>{o.style[e]===n&&s.push(o)}),s};addClass=function(e){this.forEach(n=>{n.classList.add(e)})};removeClass=function(e){this.forEach(n=>{n.classList.remove(e)})};hasClass=function(e){if(this.classList.contains(e))return!0};append=function(e){this[0].appendChild(e)};find=function(e){return typeof e=="string"?this[0].querySelector(e):this[0].filter(s=>s===e)[0]};findAll=function(e){if(typeof e=="string")return this[0].querySelectorAll(e)};css=function(e,n){if(!n)return this[0].style[e];this.forEach(s=>{s.style[e]=n})};ready(e){this.some(s=>s.readyState!=null&&s.readyState!="loading")?e():document.addEventListener("DOMContentLoaded",e)}}function p(t){return typeof t=="string"||t instanceof String?new g(...document.querySelectorAll(t)):new g(t)}function I(t){return q(t)&&(document.cookie=t+"=; Max-Age=-1;"),!1}function q(t){return!!document.cookie.match("(^|;)?"+t+"=([^;]*)")}function U(t,e,n,s,o,c){let r=new Date(t),i=["January","February","March","April","May","June","July","August","September","October","November","December"],l=["Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье"],u=r.getFullYear(),f=r.getMonth()+1,a=r.getDate(),h=i[r.getMonth()],d=r.getDay(),E=l[r.getDay()];return a<10&&(a="0"+a),f<10&&(f="0"+f),{yyyy:u,mm:f,dd:a,M:h,D:d,wd:E}}const H="querySelector",$="querySelectorAll",j="addEventListener",z="innerText";document.querySelectorAll.bind(document);const W=document.querySelector.bind(document);export{p as $,x as _,j as a,C as b,O as c,R as d,N as e,U as f,L as g,P as h,W as i,$ as j,k,b as l,z as m,F as n,M as o,J as p,H as q,I as r,S as s};
//# sourceMappingURL=constants-ufk865tC.js.map
