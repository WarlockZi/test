const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/card_panel-D-5OPUCx.js","assets/search-BrCwmJVC.js","assets/search-GVlGTbvD.css","assets/card_panel-UF59AJVy.css"])))=>i.map(i=>d[i]);
import{q as i,a as l,_ as r,p as s,D as o,k as c}from"./search-BrCwmJVC.js";import{s as d}from"./shippableUnitsTable-DsaSKX1N.js";import{M as n}from"./MyQuill-C__4ZTnu.js";class m{constructor(){if(this.category=document[i](".category"),!this.category)return!1;this.setCardPanel().then(),this.mapShippableTables(),new n("#seo_article"),this.category[l]("click",this.handleClick.bind(this))}async setCardPanel(){if(document[i](".card-panel")){const{default:e}=await r(async()=>{const{default:t}=await import("./card_panel-D-5OPUCx.js");return{default:t}},__vite__mapDeps([0,1,2,3]));this.cardPanel=new e}}handleClick({target:a}){a.classList.contains("blue-button")&&a.closest("[shipable-table]"),a.hasAttribute("data-like")?this.handleLike(a):a.hasAttribute("data-compare")?this.handleCompare(a):a.classList.contains("short-link")&&this.cardPanel.shortLink(a)}async handleCompare(a){a.dataset.compare?(a.dataset.compare=!0,(await s("/compare/updateOrCreate",this.productDTO(a)))?.arr?.compared&&a.classList.toggle("green")):(a.dataset.compare=!1,(await s("/compare/del",this.productDTO(a)))?.arr?.discompared&&a.classList.toggle("green"))}async handleLike(a){a.dataset.like?(a.dataset.like=!0,(await s("/like/updateOrCreate",this.productDTO(a)))?.arr?.liked&&a.classList.toggle("red")):(a.dataset.like=!1,(await s("/like/del",this.productDTO(a)))?.arr?.disliked&&a.classList.toggle("red"))}productDTO(a){const e=new o(a);return e.fields={product_id:a.closest("[data-1sid]").dataset["1sid"]},e}mapShippableTables(){[...this.category[c](".shippable-table")].forEach(a=>{new d(a)})}}export{m as default};
//# sourceMappingURL=category-C-yScu0f.js.map
