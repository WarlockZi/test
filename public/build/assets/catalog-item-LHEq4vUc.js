import{a as s,t as u,d as b,$ as a,S as r,D as h,p as d}from"./search-DF5JQ23V.js";class f{constructor(e){this.date=e,this.date[s]("change",this.onChange.bind(this))}onChange({target:e}){const{yyyy:t,mm:n,dd:l}=u(e.value),i=`${t}-${n}-${l}`;e.setAttribute("data-value",i);const o=new CustomEvent("date.changed",{bubbles:!0,cancelable:!0,detail:{value:i}});e.dispatchEvent(o)}}class C{constructor(e){this.id=e.id,this.checkbox=e,e[s]("change",this.changed.bind(this))}async changed({target:e}){e.dataset.pivotValue=+e.checked,this.checkbox.dispatchEvent(new CustomEvent("checkbox.changed",{bubbles:!0,detail:e.checked}))}}class p{constructor(e){if(!e)return!1;this.model=e.dataset.model,this.id=+e.dataset.id,this.setCheckboxes(),this.setSelects(),this.setDates(),e[s]("click",this.handleClick.bind(this)),e[s]("keyup",b(this.handleKeyup.bind(this))),e[s]("date.changed",this.handleDateChange.bind(this)),e[s]("customSelect.changed",this.handleSelectChange.bind(this)),this.model&&e[s]("checkbox.changed",this.handleChexboxChange.bind(this))}setCheckboxes(){const e=a("[my-checkbox]");[].forEach.call(e,function(t){new C(t)})}setDates(){const e=a("[custom-date]");[].forEach.call(e,function(t){new f(t)})}setSelects(){const e=a("[select-new]:has(option)");[].forEach.call(e,function(t){t.parentNode.hasAttribute("hidden")||new r(t)})}handleChexboxChange({target:e}){e.closest("[custom-table]")||this.update(e)}async handleSelectChange({target:e}){e.closest("[custom-table]")||this.update(e)}async handleDateChange({target:e}){this.update(e)}async handleKeyup({target:e}){if(e.closest(".custom-table")||!e.hasAttribute("contenteditable")||!e.dataset.field)return!1;const t=new h(this.id,e),n=await d(`/adminsc/${this.model}/updateOrCreate`,t);n&&e.dispatchEvent(new CustomEvent("catalogItem.changed",{bubbles:!0,detail:{res:n}}))}async handleClick({target:e}){e.classList.contains("tab")&&this.handleTabClick(e)}handleTabClick(e){a("[data-tab].show").first().classList.toggle("show"),a(`[data-tab='${e.dataset.tabId}']`).first().classList.toggle("show"),a(".tab.active").first().classList.toggle("active"),e.classList.toggle("active")}async update(e){if(e.closest("[custom-table]"))return;const t=new h(this.id,e);await d(`/adminsc/${this.model}/updateorcreate`,t)}}export{p as default};
//# sourceMappingURL=catalog-item-LHEq4vUc.js.map
