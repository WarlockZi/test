const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/modal-DP9eYFRu.js","assets/search-CxgNiI2j.js","assets/search-DbjMfPSM.css","assets/modal-C3RKveoJ.css","assets/index-DxkyIi5q.js","assets/index-DYGhe8tp.css","assets/chartjs-DS8EdONb.js","assets/chartjs-nYS6-ch8.css","assets/card_panel-CtaG7sq2.js","assets/card_panel-CUIwBKKV.css","assets/Product-DVLcwbji.js","assets/MyQuill-CLgBwkg2.js","assets/MyQuill-GClCj9AP.css","assets/Promotion-CXtqK2P4.js","assets/Promotion-B5qbfc0J.css","assets/Product-CMsERH2c.css","assets/catalog-item-kuc8dzxh.js","assets/catalog-item-BA_Z-7lk.css","assets/order-B2GIHyZL.js","assets/order-D0STG4cX.css","assets/Category-BT2tVH8a.js"])))=>i.map(i=>d[i]);
import{$ as a,p as u,q as d,a as o,b as f,S as y,d as E,D as m,c as v,_ as h}from"./search-CxgNiI2j.js";import{M as L}from"./MyQuill-CLgBwkg2.js";import k from"./Promotion-CXtqK2P4.js";class T{constructor(t){this.$sync=t,this.$log_content=a(t).find("#log_content"),this.$sync.onclick=this.handleClick.bind(this)}async handleClick({target:t}){if(t.classList.contains("button")){let e=await u(`/adminsc/sync/${t.id}`);e?.arr?.success&&(this.$log_content.innerText=e.arr?.content)}}}let _=a(".sync").first();_&&new T(_);class A{constructor(t){t&&(this.wrap=t,this.panel=t[d](".list-filter"),this.url="/adminsc/report/filter",this.wrap[o]("click",this.handleClick.bind(this)),this.setSelects())}setSelects(){const t=this.wrap[f]("[select-new]");[].map.call(t,e=>{new y(e)})}async handleClick(t){if(t.target.classList.contains("filter-button")){t.preventDefault();const s=this.getClickedFilters(),c=await u(this.url,s);this.renderDataFromResponce(c)}}getClickedFilters(){const t={},e=this.wrap[f]("[select-new]");[].map.call(e,c=>(t[c.getAttribute("name")]=c.dataset.value,null));const s=this.panel[f]("[type='checkbox']:checked");return[].forEach.call(s,c=>{t[c.name]="on"}),t}renderDataFromResponce(t){a(".used-filters").first().innerHTML=t?.arr?.filterString,a(".list-filter").first().innerHTML=t?.arr?.filterPanel;const e=a("[custom-table]").first();e.innerHTML=t?.arr?.productsTable,this.setSelects()}}class x{constructor(t){this.table=t,this.model=t.dataset.model??t.closest("[data-model]")?.dataset.model,this.modelId=t.dataset.id??t.closest("[data-model]")?.dataset.id,this.relation=t.dataset.relation??null,this.relationModel=t.dataset.relationmodel??null,this.updateOrCreateUrl=`/adminsc/${this.model}/updateOrCreate`,this.headers=a(".head"),this.inputs=a("[data-search]"),this.hidden=this.table[f]("[hidden]"),this.table[o]("click",this.handleClick.bind(this)),this.table[o]("keyup",E(this.handleKeyup.bind(this)).bind(this)),this.table[o]("paste",this.handlePaste.bind(this)),this.table[o]("customSelect.changed",this.selectChange.bind(this)),this.relation||(this.table[o]("customSelect.changed",this.selectChange.bind(this)),this.table[o]("checkbox.changed",this.checkboxChange.bind(this)),this.setCheckboxes()),this.setSelects(),this.setSortables()}async checkboxChange({target:t,detail:e}){const s=new m(this.modelId,t);await u(this.updateOrCreateUrl,s)}async selectChange(t){const s=t.target.parentNode?.dataset?.id;this.update(s,t.target)}async update(t,e){const s=new m(t,e);await u(`/adminsc/${this.model}/updateorcreate`,s)}async handleClick(t){const e=t.target;if(e.className==="add-model")this.updateOrcreate(e);else if(e.classList.contains("edit"))this.edit(e);else if(e.classList.contains("del")&&!e.classList.contains("head"))this.modelDel(e);else if(e.type!=="checkbox")if(e.classList.contains("head")||e.classList.contains("icon")){const s=e.closest(".head");if(s.hasAttribute("data-sort")){const c=[].findIndex.call(this.sortables,(n,i,r)=>n===s);this.sortColumn(c)}}else e.closest("[select-new]")&&e.closest("[select-new]")}edit(t){if(t.classList.contains("head"))return!1;const e=this.relation?this.relationModel:this.model,s=this.relation?t.dataset.id:this.modelId??t.dataset.id;window.location=`/adminsc/${e}/edit/${s}`}getIds(){const t=a(this.table)[0].querySelectorAll("[data-id]");return[].filter.call(t,function(e){return e.dataset.id!=="0"})}handlePaste(t){t.target.innerText=t.clipboardData.getData("text/plain"),this.handleInput(t.target),t.target.innerText=""}async handleKeyup({target:t}){if(t.hasAttribute("data-search"))this.search(t);else if(t.hasAttribute("contenteditable")){const e=await u(this.updateOrCreateUrl,new m(t.dataset.id,t));e?.arr?.id&&this.newRow(e?.arr.id)}}async modelDel(t){if(!confirm("Удалить?"))return;const e=t.dataset.id;await u(`/adminsc/${this.model}/delete`,{id:e})&&this.delRow(e)}async updateOrcreate(t){const e=await u(this.updateOrCreateUrl,new m(this.modelId,t));e.arr?.success?this.copyEmptyRow(t):this.newRow(e?.arr.id)}copyEmptyRow(){[].forEach.call(this.hidden,t=>{const e=t.cloneNode(!0);e.removeAttribute("hidden"),this.table[f](".custom-table")[0].append(e)})}newRow(t){[].forEach.call(this.hidden,function(e){const s=e.cloneNode(!0);s.removeAttribute("hidden"),a(this.table).find(".custom-table").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=t:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=t}.bind(this))}search(t,e){const s=this.fillRows();[].forEach.call(s,i=>{[].forEach.call(i,r=>r.style.display="flex")}),[].forEach.call(this.inputs,i=>{i!==t&&(i.value="")});const c=t.closest(".head"),n=[].findIndex.call(this.headers,i=>i===c);[].forEach.call(s,function(i){const r=i[n].innerText,p=new RegExp(`${t.value}`,"gi");r.match(p)||[].forEach.call(i,w=>{w.style.display="none"})})}fillRows(){const t=[],e=this.getIds();for(let s=0;s<e.length;s++){let c=e[s].dataset.id,n=a(this.table)[0].querySelectorAll(`[data-id='${c}']`);t.push(n)}return t}sortColumn(t){const e=this.fillRows(),s=this.directions[t]||"asc",c=s==="asc"?1:-1,n=Array.from(e);n.sort(function(i,r){const p=i[t].innerHTML,w=r[t].innerHTML,b=this.transform(t,p),g=this.transform(t,w);switch(!0){case b>g:return 1*c;case b<g:return-1*c;case b===g:return 0}}.bind(this)),[].forEach.call(e,function(i){[].forEach.call(i,r=>{r.remove()})}),this.directions[t]=s==="asc"?"desc":"asc",n.forEach(function(i){i=Array.from(i),i.reverse(),[].forEach.call(i,r=>{this.headers[this.headers.length-1].after(r)})}.bind(this))}transform(t,e){return this.sortables[t]?this.sortables[t].getAttribute("data-type")==="number"?parseFloat(e):e:void 0}delRow(t){const e=a(`[data-id='${t}']`);[].forEach.call(e,function(s){s.remove()})}setSortables(){this.sortables=a("[data-sort]"),this.directions=Array.from(this.sortables).map(function(t){return""})}setSelects(){const t=a("[select-new]:has(option)");[].forEach.call(t,e=>{new y(e)})}setCheckboxes(){const t=a("[my-checkbox]");[].forEach.call(t,e=>{e[o]("change",this.checkboxChange.bind(this))})}}const C=a("[custom-table]");C&&[].forEach.call(C,function(l){new x(l)});function P(){const l=a(".admin-panel").first();document.addEventListener("scroll",t.bind(l),{passive:!0});function t(){l&&(window.scrollY>40?l.classList.add("fixed"):l.classList.remove("fixed"))}}class I{constructor(){const t=window.location.pathname;/\/adminsc\/settings/.test(t)||/\/adminsc\/right\/list/.test(t)||/\/adminsc\/post\/list/.test(t)||/\/adminsc\/todo\/list/.test(t)?a("[settings]").addClass("current"):/\/auth\/profile/.test(t)||(/\/adminsc\/crm/.test(t)?a("[crm]").addClass("current"):/\/adminsc\/planning/.test(t)?a("[plan]").addClass("current"):/\/adminsc\/category/.test(t)||/\/adminsc\/product/.test(t)?a("[catalog]").addClass("current"):/\/test/.test(t)||/\/opentest/.test(t)||/\/adminsc\/opentest/.test(t)||/\/adminsc\/test/.test(t)?a("[test]").addClass("current"):a("[href='/adminsc']").addClass("current"))}}class S{constructor(){this.setTabs(),this.setPages(),this.setQuils()}setTabs(){const t=a(".tab");t[0].classList.add("active"),[].forEach.call(t,e=>{e.addEventListener("click",s=>{const c=s.target.dataset.id;a(".page.active").first().classList.remove("active"),a(`.page[data-id='${c}']`).first().classList.add("active"),a(".tab.active").first().classList.remove("active"),s.target.classList.add("active")})})}setPages(){a(".page")[0].classList.add("active")}setQuils(){const t=a(".quill[data-id]");t[0].classList.add("active"),[].forEach.call(t,e=>{this.id=e.dataset.id,new L(`.quill[data-id='${this.id}']`,!0,!0,!0,"snow",this.dto.bind(this))})}dto(t){return{id:this.id,model:"pages",fields:{content:t}}}}class R{constructor(){if(!a('[data-model="user"]')[0])return!1;this.setSelects()}setSelects(){const t=a("[select-new]:has(option)");[].forEach.call(t,e=>{new y(e)})}setRights(){let t=rights().replace(/,$/,""),e=a("[data-field='rights']")[0];e.dataset.value=t}rights(){let t=a(".right:checked"),e="";return[].map.call(t,s=>{let c=s.previousElementSibling.innerText+",";e+=c},e),e}confirm(){const t=a("#conf option");for(let e of t)if(e.selected)return e.value;return"0"}}class O{constructor(t){if(!t)return!1;this.sidebar=t,this.sidebar[o]("click",this.handleClick.bind(this)),this.burger=document[d](".burger"),this.burger[o]("click",this.handleClick.bind(this))}handleClick({target:t}){t===this.burger?this.sidebar.classList.toggle("show"):this.openUl(t)}openUl(t){const e=t.closest("li");e&&(e?.classList?.contains("open")||this.closeUls(),e.classList.toggle("open"),this.rotateArrow(e))}closeUls(){const t=a(this.sidebar).find(".open");t&&(t[d](".rotate").classList.toggle("rotate"),t.classList.toggle("open"))}rotateArrow(t){const e=a(t).find(".arrow");e&&e.classList.toggle("rotate")}}a(document).ready(async function(){if(document.body.classList.remove("preload"),!window.location.pathname.includes("adminsc"))return!1;if(new v(!0),new I,P(),new O(a(".sidebar").first()),new k,document[d](".modal")){const{default:n}=await h(async()=>{const{default:i}=await import("./modal-DP9eYFRu.js");return{default:i}},__vite__mapDeps([0,1,2,3]));new n}if(window.location.pathname==="/adminsc/pages"?new S:window.location.pathname==="/adminsc/user"||(window.location.pathname.startsWith("/adminsc/user/edit")?new R:window.location.href.includes("/test")?await h(async()=>{const{default:n}=await import("./index-DxkyIi5q.js").then(i=>i.i);return{default:n}},__vite__mapDeps([4,1,2,5])):window.location.pathname==="/adminsc"?await h(async()=>{const{default:n}=await import("./chartjs-DS8EdONb.js");return{default:n}},__vite__mapDeps([6,7])):window.location.pathname==="/adminsc/report/filter"&&new A(a(".products-filter").first())),document[d](".card-panel")){const{default:n}=await h(async()=>{const{default:i}=await import("./card_panel-CtaG7sq2.js");return{default:i}},__vite__mapDeps([8,1,2,9]));new n}if(document[d](".item-wrap[data-model='product']")){const{default:n}=await h(async()=>{const{default:i}=await import("./Product-DVLcwbji.js");return{default:i}},__vite__mapDeps([10,1,2,11,12,13,14,15]));new n}const s=document[d](".item-wrap");if(s){const{default:n}=await h(async()=>{const{default:i}=await import("./catalog-item-kuc8dzxh.js");return{default:i}},__vite__mapDeps([16,1,2,17]));new n(s)}if(document[d](".order-edit")){const{default:n}=await h(async()=>{const{default:i}=await import("./order-B2GIHyZL.js");return{default:i}},__vite__mapDeps([18,1,2,19]));new n}const c=document[d](".item-wrap[data-model='category']");if(c){const{default:n}=await h(async()=>{const{default:i}=await import("./Category-BT2tVH8a.js");return{default:i}},__vite__mapDeps([20,1,2,11,12,13,14]));new n(c)}});
//# sourceMappingURL=admin-BLv8D_5X.js.map
