import{$ as r}from"./DTO-lmhuUwG7.js";import c from"./card_panel-BhfBxIdz.js";import{s as l}from"./shippableUnitsTable-D2wTgiP3.js";import{M as n}from"./MyQuill-DkoxMI24.js";const p=()=>{let f=r(".zoom").first();f&&(f.onmousemove=function(t){let e=0,o=0;var s=t.currentTarget;t.offsetX?e=t.offsetX:e=t.touches[0].pageX,t.offsetY?o=t.offsetY:o=t.touches[0].pageY;let i=e/s.offsetWidth*100,a=o/s.offsetHeight*100;s.style.backgroundPosition=i+"% "+a+"%"})};class b{constructor(){if(!r(".product-card").first())return!1;const e=r(".shippable-table").first();new l(e);const o=r(".short-link").first();o&&o.addEventListener("click",function({target:s}){new c().shortLink(s)}),p(),new n("#seo-article"),new n("#detail-text")}}export{b as default};
//# sourceMappingURL=Product-DwWUS344.js.map
