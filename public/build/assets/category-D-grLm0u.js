const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/card_panel-C-Rr069H.js","assets/common-BklKRznI.js","assets/card_panel-ebMfmDJg.css"])))=>i.map(i=>d[i]);
import{_ as l}from"./common-BklKRznI.js";import{q as e,a as i,b as r}from"./constants-D_Ps4z6O.js";import{s as o}from"./shippableUnitsTable-C2hiT_PB.js";import{M as n}from"./MyQuill-DwpxTJjx.js";class f{constructor(){if(this.category=document[e](".category"),!this.category)return!1;this.setCardPanel(),this.mapShippableTables(),new n("#seo_article"),this.category[i]("click",this.handleClick.bind(this))}async setCardPanel(){if(document[e](".card-panel")){const{default:s}=await l(async()=>{const{default:t}=await import("./card_panel-C-Rr069H.js");return{default:t}},__vite__mapDeps([0,1,2]));this.cardPanel=new s}}handleClick({target:a}){a.classList.contains("blue-button")?a.closest("[shipable-table]"):a.classList.contains("short-link")&&this.cardPanel.shortLink(a)}mapShippableTables(){[...this.category[r](".shippable-table")].forEach(a=>{new o(a)})}}export{f as default};
