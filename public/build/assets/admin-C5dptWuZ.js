const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/Tables-frXP9l8I.js","assets/common-BmjU9IJD.js","assets/Table-D-Nfb5o9.js","assets/constants-D_Ps4z6O.js","assets/SelectNew-CPsXQT8S.js","assets/search-DgdaroTd.js","assets/search-CWOthOO5.css","assets/Table-D1uFYMdJ.css","assets/index-BBIwMTmS.js","assets/cookie-CmLS3Uuq.js","assets/cookie-D27E5iiV.css","assets/index-ByH27O8_.css","assets/chartjs-D-JIgSlQ.js","assets/chartjs-Dap-k2NF.css","assets/ProductFilter-DYJs2X6Q.js","assets/MyQuill-uS4Hutk7.js","assets/MyQuill-B2DiOfU9.css","assets/Promotion-DLPwRdLq.js","assets/Promotion--2U3bzhI.css","assets/modal-Bix5cJPH.js","assets/modal-CsdT2GQ5.css","assets/card_panel-D8dmWsyw.js","assets/card_panel-UF59AJVy.css","assets/Product-DMWnbxJI.js","assets/QuillFactory-B6r5pkQO.js","assets/Product-Cx1xAnsF.css","assets/order-DXTBnzKX.js","assets/order-a0agzArA.css","assets/catalog-item-D9PCVcdH.js","assets/catalog-item-DYLOAFwQ.css","assets/Category-DzUl2tDA.js"])))=>i.map(i=>d[i]);
import{$ as a,p as _,_ as n}from"./common-BmjU9IJD.js";import{a as f,q as r}from"./constants-D_Ps4z6O.js";import{S as p}from"./search-DgdaroTd.js";import{M as h}from"./MyQuill-uS4Hutk7.js";class g{constructor(t){this.$sync=t,this.$log_content=a(t).find("#log_content"),this.$sync.onclick=this.handleClick.bind(this)}async handleClick({target:t}){if(t.classList.contains("button")){let i=await _(`/adminsc/sync/${t.id}`);i?.arr?.success&&(this.$log_content.innerText=i.arr?.content)}}}let m=a(".sync").first();m&&new g(m);function L(){const o=a(".admin-panel").first();document.addEventListener("scroll",t.bind(o),{passive:!0});function t(){o&&(window.scrollY>40?o.classList.add("fixed"):o.classList.remove("fixed"))}}class v{constructor(){const t=window.location.pathname;/\/adminsc\/settings/.test(t)||/\/adminsc\/right\/list/.test(t)||/\/adminsc\/post\/list/.test(t)||/\/adminsc\/todo\/list/.test(t)?a("[settings]").addClass("current"):/\/auth\/profile/.test(t)||(/\/adminsc\/crm/.test(t)?a("[crm]").addClass("current"):/\/adminsc\/planning/.test(t)?a("[plan]").addClass("current"):/\/adminsc\/category/.test(t)||/\/adminsc\/product/.test(t)?a("[catalog]").addClass("current"):/\/test/.test(t)||/\/opentest/.test(t)||/\/adminsc\/opentest/.test(t)||/\/adminsc\/test/.test(t)?a("[test]").addClass("current"):a("[href='/adminsc']").addClass("current"))}}class y{constructor(){this.setTabs(),this.setPages(),this.setQuils()}setTabs(){const t=a(".tab");t[0].classList.add("active"),[].forEach.call(t,i=>{i.addEventListener("click",c=>{const d=c.target.dataset.id;a(".page.active").first().classList.remove("active"),a(`.page[data-id='${d}']`).first().classList.add("active"),a(".tab.active").first().classList.remove("active"),c.target.classList.add("active")})})}setPages(){a(".page")[0].classList.add("active")}setQuils(){const t=a(".quill[data-id]");t[0].classList.add("active"),[].forEach.call(t,i=>{this.id=i.dataset.id,new h(`.quill[data-id='${this.id}']`,!0,!0,!0,"snow",this.dto.bind(this))})}dto(t){return{id:this.id,model:"pages",fields:{content:t}}}}class b{constructor(t){if(!t)return!1;this.sidebar=t,this.sidebar[f]("click",this.handleClick.bind(this)),this.burger=document[r](".burger"),this.burger[f]("click",this.handleClick.bind(this))}handleClick({target:t}){t===this.burger?this.sidebar.classList.toggle("show"):this.openUl(t)}openUl(t){const i=t.closest("li");i&&(i?.classList?.contains("open")||this.closeUls(),i.classList.toggle("open"),this.rotateArrow(i))}closeUls(){const t=a(this.sidebar).find(".open");t&&(t[r](".rotate").classList.toggle("rotate"),t.classList.toggle("open"))}rotateArrow(t){const i=a(t).find(".arrow");i&&i.classList.toggle("rotate")}}a(document).ready(async function(){if(document.body.classList.remove("preload"),!window.location.pathname.includes("adminsc"))return!1;if(a("[custom-table]").first()){const{default:s}=await n(async()=>{const{default:e}=await import("./Tables-frXP9l8I.js");return{default:e}},__vite__mapDeps([0,1,2,3,4,5,6,7]));new s}new p(!0),new v,L();const i=a(".sidebar").first();if(new b(i),window.location.pathname==="/adminsc/pages")new y;else if(window.location.pathname!=="/adminsc/user"){if(!window.location.pathname.startsWith("/adminsc/user/edit")){if(window.location.href.includes("/test")){const{default:s}=await n(async()=>{const{default:e}=await import("./index-BBIwMTmS.js").then(w=>w.i);return{default:e}},__vite__mapDeps([8,1,9,10,11]))}else if(window.location.pathname==="/adminsc"){const{default:s}=await n(async()=>{const{default:e}=await import("./chartjs-D-JIgSlQ.js");return{default:e}},__vite__mapDeps([12,13]))}else if(window.location.pathname==="/adminsc/report/filter"){const{default:s}=await n(async()=>{const{default:e}=await import("./ProductFilter-DYJs2X6Q.js");return{default:e}},__vite__mapDeps([14,3,1,4,5,6,15,16]));new s(a(".products-filter").first())}}}if(a(".promotion-edit").first()){const{default:s}=await n(async()=>{const{default:e}=await import("./Promotion-DLPwRdLq.js");return{default:e}},__vite__mapDeps([17,1,4,5,3,6,18]));new s}if(document[r](".modal")){const{default:s}=await n(async()=>{const{default:e}=await import("./modal-Bix5cJPH.js");return{default:e}},__vite__mapDeps([19,1,3,20]));new s}if(document[r](".card-panel")){const{default:s}=await n(async()=>{const{default:e}=await import("./card_panel-D8dmWsyw.js");return{default:e}},__vite__mapDeps([21,1,22]));new s}if(document[r](".item-wrap[data-model='product']")){const{default:s}=await n(async()=>{const{default:e}=await import("./Product-DMWnbxJI.js");return{default:e}},__vite__mapDeps([23,1,4,5,3,6,24,15,16,25]));new s}if(document[r](".order-edit")){const{default:s}=await n(async()=>{const{default:e}=await import("./order-DXTBnzKX.js");return{default:e}},__vite__mapDeps([26,4,5,1,3,6,27]));new s}const l=document[r](".item-wrap");if(l){const{default:s}=await n(async()=>{const{default:e}=await import("./catalog-item-D9PCVcdH.js");return{default:e}},__vite__mapDeps([28,1,3,5,6,4,29]));new s(l)}const u=document[r](".item-wrap[data-model='category']");if(u){const{default:s}=await n(async()=>{const{default:e}=await import("./Category-DzUl2tDA.js");return{default:e}},__vite__mapDeps([30,1,4,5,3,6,24,15,16]));new s(u)}});
//# sourceMappingURL=admin-C5dptWuZ.js.map
