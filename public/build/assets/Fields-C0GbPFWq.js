import{S as s}from"./Promotion-EaeVMJ_S.js";import{$ as i,p as d}from"./common-DVK5bmCY.js";class l{constructor(t){this.$product=t,this.$fields=i(".item_content").first(),this.$promotions=i('[data-field="active_promotions"]').first(),this.$category_id=i('[data-field="category_id"]').first(),this.$base_unit=i('[data-field="base_unit"]').first(),this.$manufacturer_id=i('[data-field="manufacturer"]').first(),this.$printName=i("[data-field='print_name']").first(),this.$printName.addEventListener("catalogItem.changed",this.changePrintName.bind(this)),this.$productUrl=i("[data-field='slug']").first(),this.setup()}setup(){this.$fields.addEventListener("customSelect.changed",this.changeFields.bind(this)),new s(this.$category_id),new s(this.$promotions),new s(this.$base_unit),new s(this.$manufacturer_id)}changePrintName(t){if(t.detail){let e=this.$productUrl.querySelector("a"),a=t.detail?.res?.arr?.model.slug;e.setAttribute("href",`/product/${a}`),e.text=a}}async checkBoxChanged({target:t}){let e=this.dto(this);e[t.dataset.field]=+t.checked,await d("/adminsc/product/updateOrCreate",e)}async changeFields(t){let e=t.detail.target.dataset.field;if(!e)return;let a=this.dto(t);a[e]=t.detail.next.value,await d("/adminsc/product/updateOrCreate",a)}dto(t){return{id:this.$product.dataset.id}}}export{l as default};
