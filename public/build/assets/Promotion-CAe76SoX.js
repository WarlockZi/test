import{$ as t,post as a}from"./common-CWUZwUnI.js";import{S as s}from"./SelectNew-DQsOGtuz.js";import"./search-Btw97w8w.js";class l{constructor(){this.$promotion=t(".promotion-edit").first(),this.$promotion&&(this.updateUrl="/adminsc/promotion/updateOrCreate",this.id=t(this.$promotion).find("[data-field='id']").innerText,this.$count=t("[data-field='count']").first(),this.$unit=t("[select-new].unit").first(),new s(this.$unit),t('[data-field="unit"]').first().addEventListener("customSelect.changed",this.unitChanged.bind(this)),this.$newPrice=t('[data-field="new_price"]').first(),this.$activeTill=t("[data-field='active-till']").first(),this.$activeTill.addEventListener("change",this.activetillChanged.bind(this)))}unitChanged(e){let i=this.dto(this);i.unit_id=e.detail.next.value,a(this.updateUrl,i)}async activetillChanged({target:e}){let i=this.dto(this);i.active_till=e.value,await a(this.updateUrl,i)}dto(e){return{id:this.id}}}export{l as default};
//# sourceMappingURL=Promotion-CAe76SoX.js.map
