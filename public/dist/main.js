!function(){"use strict";function e(e){this.el=e,this.elType={}.toString.call(e),this.on=function(t,i){this.el&&("[object HTMLDivElement]"===this.elType&&this.el.addEventListener(t,i),"[object NodeList]"===this.elType&&e.forEach((e=>e.addEventListener(t,i))))},this.value=function(){return this.el[0].getAttribute("value")},this.attr=function(e,t){return t&&this.el[0].setAttribute(e,t),this.el[0].getAttribute(e)},this.selectedIndexValue=function(){if(this.el.length)return this.el[0].selectedOptions[0].value},this.options=function(){if(this.el.length)return this.el[0].options},this.count=function(){return this.el.length},this.text=function(){if(this.el.length)return this.el[0].innerText},this.checked=function(){if(this.el.length)return this.el[0].checked},this.getWithStyle=function(t,i){let n=[];return e.forEach((e=>{e.style[t]===i&&n.push(e)})),n},this.addClass=function(e){"[object HTMLDivElement]"===this.elType&&this.el.classList.add(e),["[object NodeList]","[object Array]"].includes(this.elType)&&this.el.forEach((t=>{t.classList.add(e)}))},this.removeClass=function(e){"[object HTMLDivElement]"===this.elType&&this.el.classList.remove(e),["[object NodeList]","[object Array]"].includes(this.elType)&&this.el.forEach((t=>{t.classList.remove(e)}))},this.hasClass=function(e){if(this.el.classList.contains(e))return!0},this.append=function(e){this.el[0].appendChild(e)},this.find=function(e){return["[object HTMLDivElement]","[object HTMLInputElement]"].includes(this.elType)?this.el.querySelector(e):["[object NodeList]","[object Array]"].includes(this.elType)?this.el[0].querySelector(e):void 0},this.css=function(t,i){if(!i)return this.el[0].style[t];"[object HTMLDivElement]"===this.elType&&(this.el.style[t]=i),"[object NodeList]"===this.elType&&e.forEach((e=>{e.style[t]=i}))}}function t(t){let i="";return i="string"==typeof t?document.querySelectorAll(t):t,new e(i)}[...t(".search input").el].map((e=>{e&&e.addEventListener("input",(function(){!async function(e){let i=t(e.parentNode).find(".search__result");if(e.value.length<1)return void(i&&(i.innerHTML=""));let n=await fetch("/search?q="+e.value);n=await n.json(n),0!==i.childNodes.length&&(i.innerHTML=""),n.map((e=>{let t=document.createElement("a");t.href=e.alias,t.innerHTML=`<img src='/pic/${e.preview_pic}' alt='${e.name}'>`+e.name,i.appendChild(t)})),t("body").on("click",(function(e){i&&e.target!==i&&(i.innerHTML="")}))}(e)}))})),t(".gamburger").on("click",(function(e){e.target.closest(".utils").querySelector(".mobile-menu").classList.toggle("show")})),document.cookie.match("(^|;)?cn=([^;]*)")?t("#cookie-notice").css("bottom","-100%"):t("#cookie-notice").css("bottom","0"),t("#cn-accept-cookie").on("click",(function(){(function(){const e=new Date;e.setTime(e.getTime()+864e5),document.cookie="cn=1; expires="+e+"path=/; SameSite=lax"})(),t("#cookie-notice").css("bottom","-100%")}))}();