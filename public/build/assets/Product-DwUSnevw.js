import{$ as r,a as n}from"./search-CM1Tatb6.js";import l from"./card_panel-8E-qgJzq.js";import{s as d}from"./shippableUnitsTable-BAQcYjip.js";import{M as a}from"./MyQuill-DcSx1sFp.js";const p=()=>{let i=r(".zoom").first();i&&(i.onmousemove=function(t){let s=0,o=0;var e=t.currentTarget;t.offsetX?s=t.offsetX:s=t.touches[0].pageX,t.offsetY?o=t.offsetY:o=t.touches[0].pageY;let f=s/e.offsetWidth*100,c=o/e.offsetHeight*100;e.style.backgroundPosition=f+"% "+c+"%"})};class k{constructor(){if(!r(".product-card").first())return!1;this.products=r(".product-wrap").first(),this.products&&this.products[n]("click",this.handleClick.bind(this));const s=r(".shippable-table").first();new d(s);const o=r(".short-link").first();o&&o.addEventListener("click",function({target:e}){new l().shortLink(e)}),p(),new a("#seo-article"),new a("#detail-text")}}export{k as default};
//# sourceMappingURL=Product-DwUSnevw.js.map
