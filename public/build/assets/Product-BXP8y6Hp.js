import{$ as e}from"./common-DnUtA5kF.js";import n from"./card_panel-B2NB1kGR.js";import{s as l}from"./shippableUnitsTable-BYLgyXEL.js";import{M as a}from"./MyQuill-BnALqy0A.js";import{a as p}from"./constants-D_Ps4z6O.js";import"./search-BDRlSmDO.js";const d=()=>{let i=e(".zoom").first();i&&(i.onmousemove=function(t){let s=0,o=0;var r=t.currentTarget;t.offsetX?s=t.offsetX:s=t.touches[0].pageX,t.offsetY?o=t.offsetY:o=t.touches[0].pageY;let f=s/r.offsetWidth*100,c=o/r.offsetHeight*100;r.style.backgroundPosition=f+"% "+c+"%"})};class w{constructor(){if(!e(".product-card").first())return!1;this.products=e(".product-wrap").first(),this.products&&this.products[p]("click",this.handleClick.bind(this));const s=e(".shippable-table").first();new l(s);const o=e(".short-link").first();o&&o.addEventListener("click",function({target:r}){new n().shortLink(r)}),d(),new a("#seo-article"),new a("#detail-text")}}export{w as default};
//# sourceMappingURL=Product-BXP8y6Hp.js.map
