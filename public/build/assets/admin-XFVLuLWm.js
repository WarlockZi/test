const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/card_panel-CN0WjdZI.js","assets/constants-ufk865tC.js","assets/card_panel-ebMfmDJg.css","assets/AdminSidebar-Bmoea4om.js","assets/AdminSidebar-CnNA9LiH.css","assets/Product-_c13npvh.js","assets/Promotion-DdMHf4I5.js","assets/Promotion-B7Spb30Y.css","assets/MyQuill-C0Uqs4nx.js","assets/MyQuill-GClCj9AP.css","assets/search-Dnb8tly4.js","assets/Product-CMsERH2c.css","assets/catalog-item-DBhGUWZn.js","assets/catalog-item-BsxDdyI6.css","assets/order-BrwHXzxx.js","assets/order-8XHTiaOZ.css","assets/modal-CEvgv6So.js","assets/modal-WKCBC1Wf.css","assets/Category-Ch9lhC1W.js","assets/chartjs-DS8EdONb.js","assets/chartjs-nYS6-ch8.css"])))=>i.map(i=>d[i]);
import{$ as a,a as h,f as E,p as u,d as C,q as f,_ as r}from"./constants-ufk865tC.js";import{S as g,P as x}from"./Promotion-DdMHf4I5.js";import{M as A}from"./MyQuill-C0Uqs4nx.js";import L from"./search-Dnb8tly4.js";const y=a("[custom-date]");if(y){let c=function({target:t}){const{yyyy:e,mm:s,dd:i}=E(t.value),l=`${e}-${s}-${i}`;t.setAttribute("data-value",l);const d=new CustomEvent("date.changed",{bubbles:!0,cancelable:!0,detail:{value:l}});t.dispatchEvent(d)};for(let t of y)t[h]("change",c)}class T{constructor(t){this.$sync=t,this.$log_content=a(t).find("#log_content"),this.$sync.onclick=this.handleClick.bind(this)}async handleClick({target:t}){if(t.classList.contains("button")){let e=await u(`/adminsc/sync/${t.id}`);e?.arr?.success&&(this.$log_content.innerText=e.arr?.content)}}}let _=a(".sync").first();_&&new T(_);function I(c){/\/adminsc\/settings/.test(c)||/\/adminsc\/right\/list/.test(c)||/\/adminsc\/post\/list/.test(c)||/\/adminsc\/todo\/list/.test(c)?a("[settings]").addClass("current"):/\/auth\/profile/.test(c)||(/\/adminsc\/crm/.test(c)?a("[crm]").addClass("current"):/\/adminsc\/planning/.test(c)?a("[plan]").addClass("current"):/\/adminsc\/category/.test(c)||/\/adminsc\/product/.test(c)?a("[catalog]").addClass("current"):/\/test/.test(c)||/\/opentest/.test(c)||/\/adminsc\/opentest/.test(c)||/\/adminsc\/test/.test(c)?a("[test]").addClass("current"):a("[href='/adminsc']").addClass("current"))}class b{constructor(t=0,e=null){this.id=t??0,this.fields={[e?.dataset?.field]:e?.dataset?.value??e.innerText??e.checked};const s=e?.dataset?.field,i=s?{[s]:e?.dataset?.value??e.innerText??e.checked}:{};this.relation={name:e?.dataset?.relation??"",id:e?.dataset?.value??0,fields:i,pivot:{field:e?.dataset?.pivotField,value:e?.dataset?.pivotValue}}}}class k{constructor(t){this.table=t,this.model=t.dataset.model??t.closest("[data-model]")?.dataset.model,this.modelId=t.dataset.id??t.closest("[data-model]")?.dataset.id,this.relation=t.dataset.relation??null,this.relationModel=t.dataset.relationmodel??null,this.updateOrCreateUrl=`/adminsc/${this.model}/updateOrCreate`,this.headers=a(".head"),this.inputs=a("[data-search]"),this.hidden=a("[hidden]"),this.table[h]("click",this.handleClick.bind(this)),this.table[h]("keyup",C(this.handleKeyup.bind(this)).bind(this)),this.table[h]("paste",this.handlePaste.bind(this)),this.relation||(this.table[h]("customSelect.changed",this.selectChange.bind(this)),this.table[h]("checkbox.changed",this.checkboxChange.bind(this)),this.setSelects(),this.setCheckboxes())}async checkboxChange({target:t,detail:e}){const s=new b(this.modelId,t);await u(this.updateOrCreateUrl,s)}async selectChange(t){const s=t.target.parentNode?.dataset?.id;this.update(s,t.target)}async update(t,e){const s=new b(t,e);await u(`/adminsc/${this.model}/updateorcreate`,s)}async handleClick(t){const e=t.target;if(e.className==="add-model")this.updateOrcreate(e);else if(e.classList.contains("edit"))this.edit(e);else if(e.classList.contains("del")&&!e.classList.contains("head"))this.modelDel(e);else if(e.type!=="checkbox"){if(e.classList.contains("head")||e.classList.contains("icon")){const s=e.closest(".head");if(s.hasAttribute("data-sort")){const i=[].findIndex.call(this.sortables,(l,d,n)=>l===s);this.sortColumn(i)}}}}edit(t){if(t.classList.contains("head"))return!1;const e=this.relation?this.relationModel:this.model,s=this.relation?t.dataset.id:this.modelId??t.dataset.id;window.location=`/adminsc/${e}/edit/${s}`}getIds(){const t=a(this.table)[0].querySelectorAll("[data-id]");return[].filter.call(t,function(e){return e.dataset.id!=="0"})}handlePaste(t){t.target.innerText=t.clipboardData.getData("text/plain"),this.handleInput(t.target),t.target.innerText=""}handleKeyUp(t){t.cancelBubble=!0;const e=t.target;if(e.hasAttribute("contenteditable"))this.debouncedInput(e);else if(e.hasAttribute("data-search")){const s=e.closest(".head"),i=[].findIndex.call(this.headers,(l,d,n)=>l===s);this.search(e,i)}}async handleKeyup({target:t}){if(t.hasAttribute("data-search"))this.search(t);else if(t.hasAttribute("contenteditable")){const e=await u(this.updateOrCreateUrl,this.DTO(t));e?.arr?.id&&this.newRow(e?.arr.id)}}async modelDel(t){if(!confirm("Удалить?"))return;const e=t.dataset.id;await u(`/adminsc/${this.model}/delete`,{id:e})&&this.delRow(e)}async updateOrcreate(t){const e=await u(this.updateOrCreateUrl,this.DTO(t));e.arr.id&&this.newRow(e?.arr.id)}newRow(t){[].forEach.call(this.hidden,function(e){const s=e.cloneNode(!0);s.removeAttribute("hidden"),a(this.table).find(".custom-table").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=t:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=t}.bind(this))}search(t,e){const s=this.fillRows();[].forEach.call(s,d=>{[].forEach.call(d,n=>n.style.display="flex")}),[].forEach.call(this.inputs,d=>{d!==t&&(d.value="")});const i=t.closest(".head"),l=[].findIndex.call(this.headers,d=>d===i);[].forEach.call(s,function(d){const n=d[l].innerText,o=new RegExp(`${t.value}`,"gi");n.match(o)||[].forEach.call(d,m=>{m.style.display="none"})})}fillRows(){const t=[],e=this.getIds();for(let s=0;s<e.length;s++){let i=e[s].dataset.id,l=a(this.table)[0].querySelectorAll(`[data-id='${i}']`);t.push(l)}return t}sortColumn(t){const e=this.fillRows(),s=this.directions[t]||"asc",i=s==="asc"?1:-1,l=Array.from(e);l.sort(function(d,n){const o=d[t].innerHTML,m=n[t].innerHTML,p=this.transform(t,o),w=this.transform(t,m);switch(!0){case p>w:return 1*i;case p<w:return-1*i;case p===w:return 0}}.bind(this)),[].forEach.call(e,function(d){[].forEach.call(d,n=>{n.remove()})}),this.directions[t]=s==="asc"?"desc":"asc",l.forEach(function(d){d=Array.from(d),d.reverse(),[].forEach.call(d,n=>{this.headers[this.headers.length-1].after(n)})}.bind(this))}transform(t,e){return this.sortables[t]?this.sortables[t].getAttribute("data-type")==="number"?parseFloat(e):e:void 0}delRow(t){const e=a(`[data-id='${t}']`);[].forEach.call(e,function(s){s.remove()})}setSortables(){this.sortables=a("[data-sort]"),this.directions=Array.from(this.sortables).map(function(t){return""})}setSelects(){const t=a("[custom-select]");[].forEach.call(t,e=>{new g(e)})}setCheckboxes(){const t=a("[my-checkbox]");[].forEach.call(t,e=>{e[h]("change",this.checkboxChange.bind(this))})}}const v=a("[custom-table]");v&&[].forEach.call(v,function(c){new k(c)});class O{constructor(){this.setTabs(),this.setPages(),this.setQuils()}setTabs(){const t=a(".tab");t[0].classList.add("active"),[].forEach.call(t,e=>{e.addEventListener("click",s=>{const i=s.target.dataset.id;a(".page.active").first().classList.remove("active"),a(`.page[data-id='${i}']`).first().classList.add("active"),a(".tab.active").first().classList.remove("active"),s.target.classList.add("active")})})}setPages(){a(".page")[0].classList.add("active")}setQuils(){const t=a(".quill[data-id]");t[0].classList.add("active"),[].forEach.call(t,e=>{this.id=e.dataset.id,new A(`.quill[data-id='${this.id}']`,!0,!0,!0,"snow",this.dto.bind(this))})}dto(t){return{id:this.id,model:"pages",fields:{content:t}}}}class P{constructor(){a("[data-model='user']")[0][h]("customSelect.changed",this.selectChange.bind(this)),this.setSelects()}setSelects(){const t=a("[custom-select]");[].forEach.call(t,e=>{new g(e)})}selectChange(t){const e=t.detail.next.value,s=t.detail.target.parentNode.dataset.id,i=new b;i.id=s,i.relation.name=t.detail.target?.dataset?.relation,i.relation.fields={role_id:e},u("/adminsc/user/changeRole",i)}}class ${constructor(){if(!a('[data-model="user"]')[0])return!1;this.setSelects()}setSelects(){const t=a(" [custom-select]");[].forEach.call(t,e=>{new g(e)})}setRights(){let t=rights().replace(/,$/,""),e=a("[data-field='rights']")[0];e.dataset.value=t}rights(){let t=a(".right:checked"),e="";return[].map.call(t,s=>{let i=s.previousElementSibling.innerText+",";e+=i},e),e}confirm(){const t=a("#conf option");for(let e of t)if(e.selected)return e.value;return"0"}}a(document).ready(async function(){if(window.location.pathname==="/adminsc/pages"?new O:window.location.pathname==="/adminsc/user"?new P:window.location.pathname.startsWith("/adminsc/user/edit")&&new $,document[f](".card-panel")){const{default:n}=await r(async()=>{const{default:o}=await import("./card_panel-CN0WjdZI.js");return{default:o}},__vite__mapDeps([0,1,2]));new n}if(!window.location.pathname.includes("adminsc"))return!1;const e=a(".sidebar").first();if(e){const{default:n}=await r(async()=>{const{default:o}=await import("./AdminSidebar-Bmoea4om.js");return{default:o}},__vite__mapDeps([3,1,4]));new n(e)}if(document[f](".item-wrap[data-model='product']")){const{default:n}=await r(async()=>{const{default:o}=await import("./Product-_c13npvh.js");return{default:o}},__vite__mapDeps([5,1,6,7,8,9,10,11]));new n}const i=document[f](".item-wrap");if(i){const{default:n}=await r(async()=>{const{default:o}=await import("./catalog-item-DBhGUWZn.js");return{default:o}},__vite__mapDeps([12,1,6,7,8,9,10,13]));new n(i)}if(document[f](".order-edit")){const{default:n}=await r(async()=>{const{default:o}=await import("./order-BrwHXzxx.js");return{default:o}},__vite__mapDeps([14,6,1,7,15]));new n}if(document[f](".modal")){const{default:n}=await r(async()=>{const{default:o}=await import("./modal-CEvgv6So.js");return{default:o}},__vite__mapDeps([16,1,17]));new n}const l=document[f](".item-wrap[data-model='category']");if(l){const{default:n}=await r(async()=>{const{default:o}=await import("./Category-Ch9lhC1W.js");return{default:o}},__vite__mapDeps([18,1,6,7,8,9,10]));new n(l)}new x,new L(!0),I(window.location.pathname),document.getElementById("income")&&await r(async()=>{const{default:n}=await import("./chartjs-DS8EdONb.js");return{default:n}},__vite__mapDeps([19,20]))});export{b as D};
//# sourceMappingURL=admin-XFVLuLWm.js.map
