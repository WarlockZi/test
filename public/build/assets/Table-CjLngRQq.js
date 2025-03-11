import{$ as n,debounce as y,post as d}from"./common-CWUZwUnI.js";import{d as c,a as h,q as b}from"./search-Btw97w8w.js";import{S as w}from"./SelectNew-DQsOGtuz.js";class r{constructor(t,e){if(t){if(this.target=t,this.id=t?.closest(".item-wrap")?.dataset?.id??t?.dataset?.id??t?.parentNode?.dataset?.id,this.fields=t?.dataset?.field??!1,this.relation=t?.dataset?.relation??t?.closest("[data-relation]")?.dataset?.relation??!1,this.pivot=t?.dataset?.pivot??t?.parentNode?.dataset?.pivot??!1,this.attach=!!this.target?.closest("[custom-table]")?.dataset?.relationtype,this.fields&&(this.fields={[t?.dataset?.field]:t?.dataset?.value??t?.checked??t?.innerText}),this.relation){const s=this.relation;if(this.relation={},this.relation.name=s,this.relation.id=t?.dataset?.value??t?.dataset?.id??0??t?.closest("[data-relation]")?.dataset?.relation??0,this.attach&&!this.pivot)this.relation.attach=this.target?.dataset?.id??this.target?.dataset.value,this.relation.detach=e??null;else if(this.pivot)delete this.attach,this.relation.pivot={},this.relation.pivot[t?.dataset?.pivot]=t?.dataset?.value??t?.checked??t?.innerText;else{this.relation.field={};const i=t?.dataset?.field??t?.dataset.pivot;this.relation.field[i]=t?.dataset?.value??t?.checked??t?.innerText}}this.fields||delete this.fields,this.relation||delete this.relation,delete this.attach,delete this.pivot,delete this.target}}}class k{constructor(t){this.table=t,this.model=t.dataset.model??t.closest("[data-model]")?.dataset.model,this.modelId=t.dataset.id??t.closest("[data-model]")?.dataset.id,this.relation=t.dataset.relation??null,this.relationType=t.dataset.relationtype??null,this.headers=n(".head"),this.inputs=n("[data-search]"),this.hidden=this.table[c]("[hidden]"),this.delUrl=`/adminsc/${this.model}/del`,this.updateOrCreateUrl=`/adminsc/${this.model}/updateOrCreate`,this.table[h]("click",this.handleClick.bind(this),!0),this.table[h]("keyup",y(this.handleKeyup.bind(this)).bind(this)),this.table[h]("paste",this.handlePaste.bind(this)),this.table[h]("customSelect.changed",this.selectChange.bind(this)),this.relation||this.table[h]("checkbox.changed",this.checkboxChange.bind(this)),this.setCheckboxes(),this.setSelects(),this.setSortables()}setDelUrl(t){this.delUrl=t}async checkboxChange(t){const e=new r(t.target);await d(this.updateOrCreateUrl,e)}async selectChange({detail:t}){const e=t.target,s=new r(e,t?.prev?.value);if((await d(`/adminsc/${this.model}/updateorcreate`,s))?.arr?.detach){const l=this.table[c](`[data-id='${t.prev.value}']`);for(let a of l)a.dataset.id=t.next.value}else{const l=this.table[c]("[data-id='0']:not([hidden])");for(let a of l)a.dataset.id=t.next.value}}async update(t,e){const s=new r(e);await d(`/adminsc/${this.model}/updateorcreate`,s)}async handleClick(t){const e=t.target;if(e.className==="add-model")this.copyEmptyRow();else if(e.classList.contains("edit"))this.edit(e);else if(e.classList.contains("del")&&!e.classList.contains("head"))this.modelDel(e);else if(e.classList.contains("head")||e.classList.contains("icon")){const s=e.closest(".head");if(s.hasAttribute("data-sort")){const i=[].findIndex.call(this.sortables,(l,a,o)=>l===s);this.sortColumn(i)}}}edit(t){if(t.classList.contains("head"))return!1;const e=this.relation?this.relationModel:this.model,s=this.relation?t.dataset.id:this.modelId??t.dataset.id;window.location=`/adminsc/${e}/edit/${s}`}getIds(){const t=n(this.table)[0].querySelectorAll("[data-id]");return[].filter.call(t,function(e){return e.dataset.id!=="0"})}handlePaste(t){t.target.innerText=t.clipboardData.getData("text/plain"),this.handleInput(t.target),t.target.innerText=""}async handleKeyup({target:t}){if(t.hasAttribute("data-search"))this.search(t);else if(t.hasAttribute("contenteditable")){const e=await d(this.updateOrCreateUrl,new r(t));e?.arr?.id&&this.newRow(e?.arr.id)}}async modelDel(t){if(!confirm("Удалить?"))return;const e=new r(t),s=await d(this.delUrl,e);s?.arr?.id&&this.delRow(s?.arr?.id)}async updateOrcreate(t){const e=await d(this.updateOrCreateUrl,new r(t));e?.arr?.success?this.copyEmptyRow(t):this.newRow(e?.arr.id)}copyEmptyRow(){[].forEach.call(this.hidden,t=>{const e=t.cloneNode(!0);e.removeAttribute("hidden"),this.addSelectInNewRow(e),this.table[c](".custom-table")[0].append(e)})}newRow(t){[].forEach.call(this.hidden,function(e){const s=e.cloneNode(!0);s.removeAttribute("hidden"),this.addSelectInNewRow(s),n(this.table).find(".custom-table").appendChild(s),["id"].includes(s.dataset.field)?s.innerText=t:["del","edit","save"].includes(s.className)||s.hasChildNodes("select")||(s.innerText=""),s.dataset.id=t}.bind(this))}addSelectInNewRow(t){if(t[b]("[select-new]")){const e=t[b]("[select-new]");this.removeUsedSelectOptions(e),new w(e)}}removeUsedSelectOptions(t){const e=this.table[c]("[data-attach]");[].forEach.call(e,s=>{[].forEach.call(t.options,i=>{i.value===s.dataset.id&&i.remove()})})}search(t,e){const s=this.fillRows();[].forEach.call(s,a=>{[].forEach.call(a,o=>o.style.display="flex")}),[].forEach.call(this.inputs,a=>{a!==t&&(a.value="")});const i=t.closest(".head"),l=[].findIndex.call(this.headers,a=>a===i);[].forEach.call(s,function(a){const o=a[l].innerText,f=new RegExp(`${t.value}`,"gi");o.match(f)||[].forEach.call(a,u=>{u.style.display="none"})})}fillRows(){const t=[],e=this.getIds();for(let s=0;s<e.length;s++){let i=e[s].dataset.id,l=n(this.table)[0].querySelectorAll(`[data-id='${i}']`);t.push(l)}return t}sortColumn(t){const e=this.fillRows(),s=this.directions[t]||"asc",i=s==="asc"?1:-1,l=Array.from(e);l.sort(function(a,o){const f=a[t].innerHTML,u=o[t].innerHTML,p=this.transform(t,f),m=this.transform(t,u);switch(!0){case p>m:return 1*i;case p<m:return-1*i;case p===m:return 0}}.bind(this)),[].forEach.call(e,function(a){[].forEach.call(a,o=>{o.remove()})}),this.directions[t]=s==="asc"?"desc":"asc",l.forEach(function(a){a=Array.from(a),a.reverse(),[].forEach.call(a,o=>{this.headers[this.headers.length-1].after(o)})}.bind(this))}transform(t,e){return this.sortables[t]?this.sortables[t].getAttribute("data-type")==="number"?parseFloat(e):e:void 0}delRow(t){const e=n(`[data-id='${t}']`);[].forEach.call(e,function(s){s.remove()})}setSortables(){this.sortables=n("[data-sort]"),this.directions=Array.from(this.sortables).map(function(t){return""})}setSelects(){const t=n("[select-new]:has(option)");[].forEach.call(t,e=>{e.parentNode.hasAttribute("hidden")||new w(e)})}setCheckboxes(){const t=this.table[c]("[my-checkbox]");[].forEach.call(t,e=>{e[h]("change",this.checkboxChange.bind(this))})}}export{k as T};
//# sourceMappingURL=Table-CjLngRQq.js.map
