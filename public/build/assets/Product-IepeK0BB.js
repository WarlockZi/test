import{$ as r}from"./common-DXPqd3_f.js";import{Q as u}from"./quill.snow-l_t7-mhn.js";import p from"./card_panel-DdwV7i6k.js";import{s as m}from"./shippableUnitsTable-C6DtefqB.js";import"./constants-Clh-pk9Y.js";const h=()=>{let i=r(".zoom").first();i&&(i.onmousemove=function(o){let n=0,e=0;var s=o.currentTarget;o.offsetX?n=o.offsetX:n=o.touches[0].pageX,o.offsetY?e=o.offsetY:e=o.touches[0].pageY;let l=n/s.offsetWidth*100,f=e/s.offsetHeight*100;s.style.backgroundPosition=l+"% "+f+"%"})},g=()=>{const i=".detail-text",o=r(i)[0];o&&e();function n(){const t=window.location.pathname.split("/").includes("adminsc");return{debug:"warn",modules:t?{toolbar:[["bold","italic","underline","blockquote"],[{align:"justify"},{align:"center"},{align:"right"}]]}:{toolbar:!1},placeholder:"Нет информации...",readOnly:!t,theme:"snow"}}function e(){const t=new u(i,n());t.getContents(),l(t),t.on(u.events.TEXT_CHANGE,s.bind(t))}function s(t){const a=this.getContents(),c=JSON.stringify(a);this.update(c)}function l(t,a){const c=o.innerText;if(f(c)){const d=JSON.parse(c);t.setContents(d)}}function f(t){try{JSON.parse(t)}catch{return!1}return!0}};class y{constructor(){if(!r(".product-card").first())return!1;const n=r(".shippable-table").first();new m(n);const e=r(".short-link").first();e&&e.addEventListener("click",function({target:s}){new p().shortLink(s)}),h(),g()}}export{y as default};
