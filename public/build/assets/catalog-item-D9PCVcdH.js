import{k as u,f,$ as a,p as l}from"./common-BmjU9IJD.js";import{a as s}from"./constants-D_Ps4z6O.js";import{D as c}from"./search-DgdaroTd.js";import{S as r}from"./SelectNew-CPsXQT8S.js";class b{constructor(t){this.date=t,this.date[s]("change",this.onChange.bind(this))}onChange({target:t}){const{yyyy:e,mm:i,dd:h}=u(t.value),d=`${e}-${i}-${h}`;t.setAttribute("data-value",d);const o=new CustomEvent("date.changed",{bubbles:!0,cancelable:!0,detail:{value:d}});t.dispatchEvent(o)}}class p{constructor(t){this.id=t.id,this.checkbox=t,t[s]("change",this.changed.bind(this))}async changed({target:t}){t.dataset.pivotValue=+t.checked,this.checkbox.dispatchEvent(new CustomEvent("checkbox.changed",{bubbles:!0,detail:t.checked}))}}class m{constructor(t,e){if(t){if(this.target=t,this.id=t?.closest(".item-wrap")?.dataset?.id,this.relation=t?.dataset?.relation??t?.closest("[data-relation]")?.dataset?.relation??!1,this.pivot=t?.dataset?.pivot??t?.parentNode?.dataset?.pivot??!1,this.attach=!!this.target?.closest("[custom-table]")?.dataset?.relationtype,this.fields&&(this.fields={[t?.dataset?.field]:t?.dataset?.value??t?.checked??t?.innerText}),this.relation){const i=this.relation;if(this.relation={},this.relation.name=i,this.relation.id=t?.dataset?.value??t?.dataset?.id??0??t?.closest("[data-relation]")?.dataset?.relation??0,this.attach&&!this.pivot)this.relation.attach=this.target?.dataset?.id??this.target?.dataset.value,this.relation.detach=e??null;else if(this.pivot)delete this.attach,this.relation.pivot={},this.relation.pivot[t?.dataset?.pivot]=t?.dataset?.value??t?.checked??t?.innerText;else{this.relation.fields={};const h=t?.dataset?.field??t?.dataset.pivot;this.relation.fields[h]=t?.dataset?.value??t?.checked??t?.innerText}}this.fields||delete this.fields,this.relation||delete this.relation,delete this.attach,delete this.pivot,delete this.target}}}class y{constructor(t){if(!t)return!1;this.model=t.dataset.model,this.id=+t.dataset.id,this.setCheckboxes(),this.setSelects(),this.setDates(),t[s]("click",this.handleClick.bind(this)),t[s]("keyup",f(this.handleKeyup.bind(this))),t[s]("date.changed",this.handleDateChange.bind(this)),t[s]("customSelect.changed",this.handleSelectChange.bind(this)),this.model&&t[s]("checkbox.changed",this.handleChexboxChange.bind(this))}setCheckboxes(){const t=a("[my-checkbox]");[].forEach.call(t,function(e){new p(e)})}setDates(){const t=a("[custom-date]");[].forEach.call(t,function(e){new b(e)})}setSelects(){const t=a("[select-new]:has(option)");[].forEach.call(t,function(e){e.parentNode.hasAttribute("hidden")||new r(e)})}handleChexboxChange({target:t}){t.closest("[custom-table]")||this.update(t)}async handleSelectChange({target:t}){t.closest("[custom-table]")||this.update(t)}async handleDateChange({target:t}){this.update(t)}async handleKeyup({target:t}){if(t.closest(".custom-table")||!t.hasAttribute("contenteditable")||!t.dataset.field)return!1;let e={};t.dataset.relation?e=new m(t):e=new c(this.id,t);const i=await l(`/adminsc/${this.model}/updateOrCreate`,e);i&&t.dispatchEvent(new CustomEvent("catalogItem.changed",{bubbles:!0,detail:{res:i}}))}async handleClick({target:t}){t.classList.contains("tab")&&this.handleTabClick(t)}handleTabClick(t){a("[data-tab].show").first().classList.toggle("show"),a(`[data-tab='${t.dataset.tabId}']`).first().classList.toggle("show"),a(".tab.active").first().classList.toggle("active"),t.classList.toggle("active")}async update(t){if(t.closest("[custom-table]"))return;const e=new c(this.id,t);await l(`/adminsc/${this.model}/updateorcreate`,e)}}export{y as default};
//# sourceMappingURL=catalog-item-D9PCVcdH.js.map
