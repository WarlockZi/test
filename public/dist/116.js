"use strict";(self.webpackChunkmy_webpack_project=self.webpackChunkmy_webpack_project||[]).push([[116],{7116:(t,e,i)=>{i.d(e,{default:()=>d});var a=i(4069),s=i(6584);class d{constructor(t){this.$product=t,this.$fields=(0,s.$)(".item_content").first(),this.$category_id=(0,s.$)('[data-field="category_id"]').first(),this.$promotions=(0,s.$)('[data-field="promotions"]').first(),this.$base_unit=(0,s.$)('[data-field="base_unit"]').first(),this.$manufacturer_id=(0,s.$)('[data-field="manufacturer_id"]').first(),this.$printName=(0,s.$)("[data-field='print_name']").first(),this.$printName.addEventListener("catalogItem.changed",this.changePrintName.bind(this)),this.$productUrl=(0,s.$)("[data-field='slug']").first(),this.setup()}setup(){this.$fields.addEventListener("customSelect.changed",this.changeFields.bind(this)),new a.A(this.$category_id),new a.A(this.$promotions),new a.A(this.$base_unit),new a.A(this.$manufacturer_id)}changePrintName(t){if(t.detail){let e=this.$productUrl.querySelector("a"),i=t.detail?.res?.arr?.model.slug;e.setAttribute("href",`/product/${i}`),e.text=i}}async checkBoxChanged({target:t}){let e=this.dto(this);e[t.dataset.field]=+t.checked,await(0,s.bE)("/adminsc/product/updateOrCreate",e)}async changeFields(t){let e=t.detail.target.dataset.field;if(!e)return;let i=this.dto(t);i[e]=t.detail.next.value,await(0,s.bE)("/adminsc/product/updateOrCreate",i)}dto(t){return{id:this.$product.dataset.id}}}}}]);
//# sourceMappingURL=116.js.map