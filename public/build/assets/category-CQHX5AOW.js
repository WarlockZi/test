const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/card_panel-D8dmWsyw.js","assets/common-BmjU9IJD.js","assets/card_panel-UF59AJVy.css"])))=>i.map(i=>d[i]);
import{_ as l,p as s}from"./common-BmjU9IJD.js";import{q as i,a as r,b as o}from"./constants-D_Ps4z6O.js";import{s as c}from"./shippableUnitsTable-Cna3Yiy9.js";import{M as d}from"./MyQuill-uS4Hutk7.js";import{D as n}from"./search-DgdaroTd.js";class k{constructor(){if(this.category=document[i](".category"),!this.category)return!1;this.setCardPanel().then(),this.mapShippableTables(),new d("#seo_article"),this.category[r]("click",this.handleClick.bind(this))}async setCardPanel(){if(document[i](".card-panel")){const{default:e}=await l(async()=>{const{default:t}=await import("./card_panel-D8dmWsyw.js");return{default:t}},__vite__mapDeps([0,1,2]));this.cardPanel=new e}}handleClick({target:a}){a.classList.contains("blue-button")&&a.closest("[shipable-table]"),a.hasAttribute("data-like")?this.handleLike(a):a.hasAttribute("data-compare")?this.handleCompare(a):a.classList.contains("short-link")&&this.cardPanel.shortLink(a)}async handleCompare(a){a.dataset.compare?(a.dataset.compare=!0,(await s("/compare/updateOrCreate",this.productDTO(a)))?.arr?.compared&&a.classList.toggle("green")):(a.dataset.compare=!1,(await s("/compare/del",this.productDTO(a)))?.arr?.discompared&&a.classList.toggle("green"))}async handleLike(a){a.dataset.like?(a.dataset.like=!0,(await s("/like/updateOrCreate",this.productDTO(a)))?.arr?.liked&&a.classList.toggle("red")):(a.dataset.like=!1,(await s("/like/del",this.productDTO(a)))?.arr?.disliked&&a.classList.toggle("red"))}productDTO(a){const e=new n(a);return e.fields={product_id:a.closest("[data-1sid]").dataset["1sid"]},e}mapShippableTables(){[...this.category[o](".shippable-table")].forEach(a=>{new c(a)})}}export{k as default};
//# sourceMappingURL=category-CQHX5AOW.js.map
