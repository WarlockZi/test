import{$ as c,debounce as b,post as g,createEl as d}from"./common-CWUZwUnI.js";const E="modulepreload",P=function(s){return"/"+s},h={},w=function(n,e,t){let i=Promise.resolve();if(e&&e.length>0){document.getElementsByTagName("link");const o=document.querySelector("meta[property=csp-nonce]"),a=o?.nonce||o?.getAttribute("nonce");i=Promise.allSettled(e.map(r=>{if(r=P(r),r in h)return;h[r]=!0;const f=r.endsWith(".css"),m=f?'[rel="stylesheet"]':"";if(document.querySelector(`link[href="${r}"]${m}`))return;const l=document.createElement("link");if(l.rel=f?"stylesheet":E,f||(l.as="script"),l.crossOrigin="",l.href=r,a&&l.setAttribute("nonce",a),document.head.appendChild(l),f)return new Promise((y,v)=>{l.addEventListener("load",y),l.addEventListener("error",()=>v(new Error(`Unable to preload CSS for ${r}`)))})}))}function u(o){const a=new Event("vite:preloadError",{cancelable:!0});if(a.payload=o,window.dispatchEvent(a),!a.defaultPrevented)throw o}return i.then(o=>{for(const a of o||[])a.status==="rejected"&&u(a.reason);return n().catch(u)})},_="querySelector",q="querySelectorAll",p="addEventListener",L="innerText";document.querySelectorAll.bind(document);const T=document.querySelector.bind(document);var k=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{};function O(s){return s&&s.__esModule&&Object.prototype.hasOwnProperty.call(s,"default")?s.default:s}function j(s){if(s.__esModule)return s;var n=s.default;if(typeof n=="function"){var e=function t(){return this instanceof t?Reflect.construct(n,arguments,this.constructor):n.apply(this,arguments)};e.prototype=n.prototype}else e={};return Object.defineProperty(e,"__esModule",{value:!0}),Object.keys(s).forEach(function(t){var i=Object.getOwnPropertyDescriptor(s,t);Object.defineProperty(e,t,i.get?i:{enumerable:!0,get:function(){return s[t]}})}),e}class x{constructor(n=0,e=null){this.id=n??e?.parentNode?.dataset?.id??0,this.attach=e?.parentNode?.dataset?.attach??!1,this.fields={[e?.dataset?.field]:e?.dataset?.value??e?.checked??e?.innerText};const t=e?.dataset?.field,i=t?{[t]:e?.dataset?.value??e.innerText??e.checked}:{};this.relation={name:e?.dataset?.relation??e?.closest("[data-relation]")?.dataset?.relation??"",id:e?.dataset?.value??e?.dataset?.id??0,fields:i,pivot:{field:e?.dataset?.pivotField??e?.parentNode?.dataset?.pivot,value:e?.dataset?.pivotValue??e?.innerText}}}}class M{constructor(n=!1){this.admin=n;const e=c(".utils .search").first(),t=c(".search-panel").first();!e||!t||(this.openBtn=e,this.panel=t,this.text=c(t).find(".text"),this.result=c(t).find(".result"),this.closeBtn=c(t).find(".close"),this.debouncedKeyUp=b(this.find,800),this.text[p]("keyup",this.debouncedKeyUp.bind(this)),this.openBtn[p]("click",this.togglePanel.bind(this)),this.closeBtn[p]("click",this.togglePanel.bind(this)))}togglePanel(){window.ym==!0&&YM("click_search"),this.panel.classList.toggle("show"),this.result.innerHTML="",this.text.value=""}async find({target:n}){this.result.innerHTML="";const e=n.value;if(!e)return!1;const t=await g("/search",{text:e});t?.arr?.found&&(this.result.style.display="initial",t?.arr?.found.map(i=>{this.result.append(this.createLi(i))}))}createLi(n){const e=d("li"),t=d("a");t.href=this.admin?`/adminsc/product/edit/${n.id}`:`/product/${n.slug}`,n.deleted_at&&t.classList.add("deleted"),e.appendChild(t);const i=d("div","name",n.name),u=d("div","art",n.art),o=d("img");return o.src=n.mainImage,t.append(u),t.append(i),t.append(o),e.append(t),e}}export{x as D,M as S,w as _,p as a,O as b,k as c,q as d,T as e,j as g,L as i,_ as q};
//# sourceMappingURL=search-Btw97w8w.js.map
