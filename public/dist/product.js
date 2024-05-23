(()=>{"use strict";var t={448:(t,e,n)=>{n.d(e,{$:()=>u,bE:()=>i,lY:()=>r});var s=n(869);new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2});let r={show:function(t,e){let n=this.el("div","popup__close");n.innerText="X";let s=this.el("div","popup__item");s.innerText=t,s.append(n);let r=u(".popup")[0];r||(r=this.el("div","popup")),r.append(s),r.addEventListener("click",this.close,!0),document.body.append(r),setTimeout((()=>{s.classList.remove("popup__item"),s.classList.add("popup-hide")}),5e3),setTimeout((()=>{s.remove(),e&&e()}),5950)},close:function(t){t.target.classList.contains("popup__close")&&this.closest(".popup").remove()},el:function(t,e){let n=document.createElement(t);return n.classList.add(e),n}};async function i(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise((async function(n,i){e.token=document.querySelector('meta[name="token"]').getAttribute("content");let o=new XMLHttpRequest;o.open("POST",t,!0),o.setRequestHeader("X-Requested-With","XMLHttpRequest"),e instanceof FormData?o.send(e):(o.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),o.send("param="+JSON.stringify(e))),o.onerror=function(t){i(Error("Network Error"+t.message))},o.onload=function(){try{var t;if(!function(t){try{JSON.parse(t)}catch(t){return!1}return!0}(o.response))return void console.log(o.response);const i=JSON.parse(o.response);let l=u(".message")[0];var e;null!=i&&i.popup||null!=i&&null!==(t=i.arr)&&void 0!==t&&t.popup?r.show(i.popup??(null==i||null===(e=i.arr)||void 0===e?void 0:e.popup)):i.msg?l&&(l.innerHTML=i.msg,u(l).removeClass("success"),u(l).removeClass("error")):i.success?l&&(l.innerHTML=i.success,u(l).addClass("success"),u(l).removeClass("error")):i.error&&(l.innerHTML=i.error,u(l).addClass("error"),u(l).removeClass("success"),(0,s.A)(i.error)),n(i)}catch(t){return console.log("////////////********* REQUEST ERROR ***********//////////////////////"),console.log(o.response),!1}}}))}class o extends Array{on(t,e,n){"function"==typeof e?this.forEach((n=>n.addEventListener(t,e))):this[0].querySelectorAll(e).forEach((e=>{e.addEventListener(t,n)}))}value=function(){return this[0].getAttribute("value")};first=function(){return this[0]};attr=function(t,e){return e&&this[0].setAttribute(t,e),this[0].getAttribute(t)};selectedIndexValue=function(){if(this.length)return this[0].selectedOptions[0].value};options=function(){if(this.length)return this[0].options};count=function(){return this.length};text=function(){if(this.length)return this[0].innerText};checked=function(){if(this.length)return this[0].checked};getWithStyle=function(t,e){let n=[];return this.forEach((s=>{s.style[t]===e&&n.push(s)})),n};addClass=function(t){this.forEach((e=>{e.classList.add(t)}))};removeClass=function(t){this.forEach((e=>{e.classList.remove(t)}))};hasClass=function(t){if(this.classList.contains(t))return!0};append=function(t){this[0].appendChild(t)};find=function(t){return"string"==typeof t?this[0].querySelector(t):this[0].filter((e=>e===t))[0]};findAll=function(t){if("string"==typeof t)return this[0].querySelectorAll(t)};css=function(t,e){if(!e)return this[0].style[t];this.forEach((n=>{n.style[t]=e}))};ready(t){this.some((t=>null!=t.readyState&&"loading"!=t.readyState))?t():document.addEventListener("DOMContentLoaded",t)}}function u(t){return"string"==typeof t||t instanceof String?new o(...document.querySelectorAll(t)):new o(t)}},869:(t,e,n)=>{n.d(e,{A:()=>r});var s=n(448);function r(t){let e=(0,s.$)(".adm-content")[0];if(!e)return;let n=document.createElement("div");n.classList.add("message"),n.classList.add("error"),n.innerText=t,e.prepend(n),setTimeout(function(){n.style.scale=0,setTimeout(function(){n.remove()}.bind(this),500)}.bind(this),3e3)}}},e={};function n(s){var r=e[s];if(void 0!==r)return r.exports;var i=e[s]={exports:{}};return t[s](i,i.exports,n),i.exports}n.d=(t,e)=>{for(var s in e)n.o(e,s)&&!n.o(t,s)&&Object.defineProperty(t,s,{enumerable:!0,get:e[s]})},n.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(()=>{var t=n(448);const e=()=>{let e=".detail-text",n=(0,t.$)(e)[0];function s(e){let n=this.getContents();!async function(e){let n=(0,t.$)('[data-field="id"]').first();n=+n.innerText;let s={id:n,txt:e};await(0,t.bE)("/adminsc/product/updateOrCreate",s)}(JSON.stringify(n))}n&&function(){let t=new Quill(e,function(){const t=window.location.pathname.split("/").includes("adminsc");return{debug:"warn",modules:t?{toolbar:[["bold","italic","underline","blockquote"],[{align:"justify"},{align:"center"},{align:"right"}]]}:{toolbar:!1},placeholder:"Compose an epic...",readOnly:!t,theme:"snow"}}());t.getContents(),function(t,e){let s=n.innerText;if(function(t){try{JSON.parse(t)}catch(t){return!1}return!0}(s)){let e=JSON.parse(s);t.setContents(e)}}(t),t.on(Quill.events.TEXT_CHANGE,s.bind(t))}()},s="querySelector";class r{constructor(t){if(!t)return!1;this.target=t,this.table=t.closest(".shippable-table"),this.table.addEventListener("click",this.handleClick.bind(this)),this.blueButton=this.table[s](".blue-button"),this.greenButtonWrap=this.table[s](".green-button-wrap"),this.price=+this.table.dataset.price,this.sid=this.table.dataset["1sid"],this.total=this.table[s]("[data-total]"),this.formatter=new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2}),this.showButtons(),this.renderSums()}showButtons(){this.getTotalCount()?(this.blueButton&&(this.blueButton.style.display="none"),this.greenButtonWrap.style.display="flex"):(this.blueButton&&(this.blueButton.style.display="flex"),this.greenButtonWrap.style.display="none")}handleClick(t){let{target:e}=t;const n=e??this.target;if(n.classList.contains("blue-button"))this.showGreenButton(n);else if(n.classList.contains("green-button"))window.location.href="/cart";else if(n.classList.contains("plus")){const t=n.closest(".unit-row");this.increment(t)}else if(n.classList.contains("minus")){const t=n.closest(".unit-row");this.decrement(t)}else if(n.classList.contains("input")){const t=n.closest(".unit-row");this.handleChange(t)}return this}increment(t){t.querySelector("input").value++,this.handleChange(t)}decrement(t){const e=t.querySelector("input");+e.value<2?e.value="":e.value--,this.handleChange(t)}getTotalCount(t){return[...this.table.querySelectorAll("input")].reduce(((t,e)=>t+ +e.value),0)}getTotalSum(){return[...this.table.querySelectorAll(".sub-sum")].reduce(((t,e)=>t+ +e.value),0)}handleChange(t){const e=this.getTotalCount(t);this.renderSums(),0===e&&this.showBlueButton(),this.toServer(this.dto(t))}renderSums(){let t=[...this.table.querySelectorAll(".unit-row")].reduce(((t,e,n)=>{const s=this.rowDto(e);let r=+s.price*+s.multiplier*+s.count;return s.sub_sum&&(s.sub_sum.innerText=this.formatter.format(r)),t+r}),0);this.total&&(this.total.innerText=this.formatter.format(t))}rowDto(t){return{s_id:this.sid,price:this.price,unit_id:t.dataset.unitid,count:t.querySelector("input").value,multiplier:t.dataset.multiplier,sub_sum:t.querySelector(".sub-sum")}}dto(t){return{unit_id:t.dataset.unitid,count:t.querySelector("input").value,product_id:this.sid}}toServer(e){(0,t.bE)("/adminsc/orderitem/updateOrCreate",e)}showBlueButton(){this.greenButtonWrap.style.display="none",this.greenButtonWrap.querySelector("input").value=0}showGreenButton(){this.greenButtonWrap.style.display="flex";const t=+this.greenButtonWrap.querySelector("input").value;this.greenButtonWrap.querySelector("input").value=t||1}}window.onload=function(){const n=(0,t.$)(".product-card").first();if(!n)return!1;n.addEventListener("click",r.bind(n)),r(),(()=>{let e=(0,t.$)(".zoom").first();e&&(e.onmousemove=function(t){let e=0,n=0;var s=t.currentTarget;e=t.offsetX?t.offsetX:t.touches[0].pageX,t.offsetY?n=t.offsetY:e=t.touches[0].pageX;let r=e/s.offsetWidth*100,i=n/s.offsetHeight*100;s.style.backgroundPosition=r+"% "+i+"%"})})(),(()=>{const e=(0,t.$)("[data-shortLink]").first();e&&e.addEventListener("click",(async e=>{navigator.permissions.query({name:"clipboard-write"}).then((n=>{"granted"!==n.state&&"prompt"!==n.state||(t.lY.show("Ссылка скопирована"),navigator.clipboard.writeText(e.target.dataset.shortlink))}))}))})(),e()}})()})();
//# sourceMappingURL=product.js.map