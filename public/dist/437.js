"use strict";(self.webpackChunkmy_webpack_project=self.webpackChunkmy_webpack_project||[]).push([[437],{2437:(e,t,s)=>{s.d(t,{default:()=>a});var l=s(6584),i=s(4069);class a{constructor(){this.$promotion=(0,l.$)(".promotion-edit").first(),this.$promotion&&(this.id=(0,l.$)(this.$promotion).find("[data-field='id']").innerText,this.$activeTill=(0,l.$)("[data-field='active-till']").first(),this.$activeTill.onchange=this.activetillChanged.bind(this),this.$unit=(0,l.$)("[select-new].unit").first(),new i.A(this.$unit),(0,l.$)('[data-field="unit"]').first().addEventListener("customSelect.changed",this.unitChanged.bind(this)))}unitChanged(e){let t=this.dto(this);t.unit_id=e.detail.next.value,(0,l.bE)("/adminsc/promotion/updateOrCreate",t)}activetillChanged({target:e}){let t=this.dto(this);t.active_till=e.value,(0,l.bE)("/adminsc/promotion/updateOrCreate",t)}dto(e){return{id:e.id}}}},4069:(e,t,s)=>{s.d(t,{A:()=>i});var l=s(6584);class i{constructor(e){var t;if(e)return this.options=(t=e.querySelectorAll("option"),[...t].map((e=>({value:e.value,label:e.label,selected:e.selected,element:e})))),this.sel=(new l.n).tag("div").className(e?.className).field(e.dataset.field).attr("select-new","").attr("data-value",this?.selectedOption?.value??"").attr("tabindex","0").get(),e.after(this.sel),this.label=document.createElement("span"),this.sel.append(this.label),this.space=(new l.n).tag("div").attr("class","space").text(this?.selectedOption?.label).get(),this.label.append(this.space),this.arrow=(new l.n).tag("div").attr("class","arrow").get(),this.label.append(this.arrow),this.ul=(new l.n).tag("ul").attr("class","options").get(),this.options.forEach((e=>{!function(e,t){const s=(new l.n).tag("li").text(e.label).attr("data-value",e.value).get();e.selected&&s.classList.add("selected"),s.onclick=({target:s})=>{t.selectValue(e.value),t.ul.classList.remove("show")},t.ul.append(s)}(e,this)})),this.sel.append(this.ul),this.label.onclick=()=>this.ul.classList.toggle("show"),this.sel.onblur=()=>this.ul.classList.remove("show"),this.sel.onkeydown=this.keyDownhandler.bind(this),e.remove(),this}onchange(e){this.callback=e}keyDownhandler(e){let t,s="";if("Space"===e.code)select.ul.classList.toggle("show");else if("ArrowUp"===e.code){const e=select.options[select.selectedOptionIndex-1];e&&select.selectValue(e.value)}else if("ArrowDown"===e.code){const e=select.options[select.selectedOptionIndex+1];e&&select.selectValue(e.value)}else if("Enter"===e.code||"Escape"===e.code)select.ul.classList.remove("show");else{clearTimeout(t),s+=e.key,t=setTimeout((()=>{s=""}),500);const l=this.options.find((e=>e.label.toLowerCase().includes(s)));l&&this.sel.selectValue(l.value)}}get selectedOption(){return this.options.find((e=>e.selected))}get selectedOptionIndex(){return this.options.indexOf(this.selectedOption)}selectValue(e){const t=this.options.find((t=>t.value===e)),s=this.selectedOption;s.selected=!1,t.selected=!0,this.space.innerText=t.label,this.sel.dataset.value=t.value,s.element.classList.remove("selected"),t.element.classList.add("selected"),t.element.scrollIntoView({block:"nearest"}),this.sel.dispatchEvent(new CustomEvent("customSelect.changed",{bubbles:!0,detail:{next:t,prev:s,target:this.sel}}))}}}}]);
//# sourceMappingURL=437.js.map