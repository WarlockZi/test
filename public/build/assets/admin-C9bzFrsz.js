const __vite__fileDeps=["assets/index-DUZ2fCTA.js","assets/common-RiEdO0HM.js","assets/index-Du3s5jNk.css","assets/AdminSidebar-TkHm2mCZ.js","assets/constants-Clh-pk9Y.js","assets/AdminSidebar-Cg7ldI_K.css","assets/Product-C-B9gKuB.js","assets/Promotion-C8IvO5Ej.js","assets/Promotion-C-yV3o17.css","assets/quill-BehQYXAG.js","assets/quill.snow-DpC92mTv.js","assets/quill-BS3afWzt.css","assets/Product-g_McCRne.css","assets/product-BjfEtDHX.css","assets/catalog-item-DTjpK1zu.js","assets/search-B8zO6gn1.js","assets/order-8xhIPPov.js","assets/order-B2jhaEIF.css","assets/modal-DdcVNKq5.js","assets/modal-aJpmGEvw.css","assets/Category-DDc0bJka.js","assets/Category-BpqyPztA.css","assets/chartjs-D8I9db7I.js","assets/chartjs-BPcd8uUI.css"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{$ as n,f as y,p as r,d as E,_ as c}from"./common-RiEdO0HM.js";import{q as h}from"./constants-Clh-pk9Y.js";import v from"./search-B8zO6gn1.js";import{P as g}from"./Promotion-C8IvO5Ej.js";import"./quill.snow-DpC92mTv.js";let f=n("[custom-date]");if(f)for(let o of f)o.onchange=function({target:t}){let{yyyy:e,mm:s,dd:i}=y(t.value),d=`${e}-${s}-${i}`;t.value,t.setAttribute("data-value",d)};class I{constructor(t){this.$sync=t,this.$log_content=n(t).find("#log_content"),this.$sync.onclick=this.handleClick.bind(this)}async handleClick({target:t}){if(t.classList.contains("button")){let e=await r(`/adminsc/sync/${t.id}`);e?.arr?.success&&(this.$log_content.innerText=e.arr?.content)}}}let p=n(".sync").first();p&&new I(p);function A(o){/\/adminsc\/settings/.test(o)||/\/adminsc\/right\/list/.test(o)||/\/adminsc\/post\/list/.test(o)||/\/adminsc\/todo\/list/.test(o)?n("[settings]").addClass("current"):/\/auth\/profile/.test(o)||(/\/adminsc\/crm/.test(o)?n("[crm]").addClass("current"):/\/adminsc\/planning/.test(o)?n("[plan]").addClass("current"):/\/adminsc\/category/.test(o)||/\/adminsc\/product/.test(o)?n("[catalog]").addClass("current"):/\/test/.test(o)||/\/opentest/.test(o)||/\/adminsc\/opentest/.test(o)||/\/adminsc\/test/.test(o)?n("[test]").addClass("current"):n("[href='/adminsc']").addClass("current"))}class T{constructor(t){this.table=t,this.model=t.dataset.model??t.closest("[data-model]")?.dataset.model,this.modelId=t.dataset.id??t.closest("[data-model]")?.dataset.id,this.relation=t.dataset.relation??null,this.relationModel=t.dataset.relationmodel??null,this.url=`/adminsc/${this.model}/updateOrCreate`,this.headers=n(".head"),this.inputs=n(".head input"),this.hidden=n("[hidden]"),this.editable=n("[contenteditable]"),this.sortables=n("[data-sort]"),this.ids=this.getIds(),this.rows=this.fillRows(),this.WSSelects=n("[custom-select]"),[].forEach.call(this.WSSelects,e=>{e.onchange=this.customSelectChange}),this.table.addEventListener("click",this.handleClick.bind(this)),this.table.addEventListener("keyup",this.handleKeyUp.bind(this)),this.table.addEventListener("paste",this.handlePaste.bind(this)),this.debouncedInput=E(this.handleInput),this.directions=Array.from(this.sortables).map(function(e){return""})}async handleClick(t){const e=t.target;if(e.className==="add-model")this.createModel(e);else if(e.className===".del:not(.head)"||e.closest(".del:not(.head)"))this.modelDel(e.closest(".del:not(.head)"));else if(e.className==="edit:not(.head)"||e.closest(".edit:not(.head)"))t.preventDefault(),this.edit(e);else if(e.type==="checkbox"){const s=e.dataset.func,i=e.checked,d=e.dataset["1sid"],l={base_is_shippable:i,product_1s_id:d};await r(`/adminsc/${this.model}/${s}`,l)}else if(e.classList.contains("head")||e.classList.contains("icon")){const s=e.closest(".head");if(s.hasAttribute("data-sort")){const i=[].findIndex.call(sortables,(d,l,a)=>d===s);this.sortColumn(i)}}}edit(t){const e=this.relation?this.relationModel:this.model,s=this.relation?t.dataset.id:this.modelId??t.dataset.id;window.location=`/adminsc/${e}/edit/${s}`}async customSelectChange({target:t}){if(!t.closest("[data-model]"))return!1;const s=t.options.selectedIndex,i=t.options[s].value,d={[this.field]:i,id:this.modelId};await r(this.url,d)}getIds(){let t=n(this.table)[0].querySelectorAll("[data-id]");return[].filter.call(t,function(e){return e.dataset.id!=="0"})}handlePaste(t){t.target.innerText=t.clipboardData.getData("text/plain"),this.handleInput(t.target),t.target.innerText=""}handleKeyUp(t){let e=t.target;if(t.cancelBubble=!0,e.hasAttribute("contenteditable"))this.debouncedInput(e);else if(e.closest(".head")){const s=e.closest(".head"),i=[].findIndex.call(this.headers,(d,l,a)=>d===s);this.search(i,e)}}async handleInput(t){const e=this.createModel(t),s=await r(this.url,e);s.arr.id&&this.newRow(s?.arr.id).bind(this)}async modelDel(t){if(!confirm("Удалить?"))return;let e=t.dataset.id;await r(`/adminsc/${this.model}/delete`,{id:e})&&delView(e)}createModel(t){return{model:this.model,id:this.modelId,relation:this.relation,fields:this.relationDTO(t)}}relationDTO(t){return this.relation?{id:t.dataset.id,[t.dataset.field]:t.innerText}:null}newRow(t){[].forEach.call(this.hidden,function(e){const s=e.cloneNode(!0);s.removeAttribute("hidden"),n(this.table).find(".custom-table").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=t:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=t}.bind(this))}showAllRows(){[].forEach.call(this.rows,t=>{[].forEach.call(t,e=>{e.style.display="flex"})})}search(t,e){this.showAllRows();const s=e.value;[].forEach.call(this.inputs,i=>{i!==e&&(i.value="")}),[].forEach.call(this.rows,function(i){const d=i[t].innerText,l=new RegExp(`${s}`,"gi");d.match(l)||[].forEach.call(i,a=>{a.style.display="none"})})}fillRows(){let t=[];for(let e=0;e<this.ids.length;e++){let s=this.ids[e].dataset.id,i=n(this.table)[0].querySelectorAll(`[data-id='${s}']`);t.push(i)}return t}sortColumn(t){const e=this.fillRows(),s=this.directions[t]||"asc",i=s==="asc"?1:-1,d=Array.from(e);d.sort(function(l,a){const _=l[t].innerHTML,b=a[t].innerHTML,u=this.transform(t,_),m=this.transform(t,b);switch(!0){case u>m:return 1*i;case u<m:return-1*i;case u===m:return 0}}),[].forEach.call(e,function(l){[].forEach.call(l,a=>{a.remove()})}),this.directions[t]=s==="asc"?"desc":"asc",d.forEach(function(l){l=Array.from(l),l.reverse(),[].forEach.call(l,a=>{this.headers[this.headers.length-1].after(a)})})}transform(t,e){return this.sortables[t]?this.sortables[t].getAttribute("data-type")==="number"?parseFloat(e):e:void 0}save(t){return r(this.url,t.model)}makeServerModel(t){const e=this.model;return{model:{id:t.dataset.id,[t.dataset.field]:t.innerText},modelName:e}}delView(t){const e=n(`[data-id='${t}']`);[].forEach.call(e,function(s){s.remove()})}}const w=n("[custom-table]");w&&[].forEach.call(w,function(o){new T(o)});document.addEventListener("scroll",o=>{const t=document.querySelector(".admin-panel");if(!t)return!1;window.scrollY>30&&(t.classList.add("fixed"),setTimeout(()=>{t.style.top="0"},1)),window.scrollY<20&&t.classList.remove("fixed")},{passive:!0});n(document).ready(async function(){if(!window.location.pathname.includes("adminsc"))return!1;window.location.href.includes("/test")&&await c(()=>import("./index-DUZ2fCTA.js").then(a=>a.i),__vite__mapDeps([0,1,2]));const e=n(".admin-sidebar").first();if(e){const{default:a}=await c(()=>import("./AdminSidebar-TkHm2mCZ.js"),__vite__mapDeps([3,1,4,5]));new a(e)}if(document[h](".item-wrap[data-model='product']")){const{default:a}=await c(()=>import("./Product-C-B9gKuB.js"),__vite__mapDeps([6,1,7,8,4,9,10,11,12,13]));new a}const i=document[h](".item-wrap");if(i){const{default:a}=await c(()=>import("./catalog-item-DTjpK1zu.js"),__vite__mapDeps([14,1,4,15,7,8,10,11]));new a(i)}if(document[h](".order-edit")){const{default:a}=await c(()=>import("./order-8xhIPPov.js"),__vite__mapDeps([16,7,1,8,17]));new a}if(document[h](".modal-wrapper")){const{default:a}=await c(()=>import("./modal-DdcVNKq5.js"),__vite__mapDeps([18,1,19]));new a}const d=document[h](".item-wrap[data-model='category']");if(d){const{default:a}=await c(()=>import("./Category-DDc0bJka.js"),__vite__mapDeps([20,1,7,8,4,21,13]));new a(d)}new g,new v(!0),A(window.location.pathname),document.getElementById("income")&&await c(()=>import("./chartjs-D8I9db7I.js"),__vite__mapDeps([22,23]))});
