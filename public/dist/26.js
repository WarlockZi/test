"use strict";(self.webpackChunkmy_webpack_project=self.webpackChunkmy_webpack_project||[]).push([[26],{26:(t,e,i)=>{i.d(e,{default:()=>c});var a=i(448),s=(i(211),i(69));(0,a.$)(".units").first()&&new class{constructor(t){this.$table=(0,a.$)(t).first(),this.$table&&(this.product1sId=(0,a.$)("[data-field='1s_id']").first().innerText,this.$baseUnit=(0,a.$)("[data-field='base_unit'] [data-field='base_unit']").first(),this.$addUnit=(0,a.$)(".add-unit").first(),this.$rows=(0,a.$)(".rows").first(),this.$selector=(0,a.$)(this.$rows).find("[select-new]"),this.$addUnit.onclick=this.createRow.bind(this),this.$rows.onchange=this.handleChange.bind(this),this.$rows.onkeyup=this.handleKeyUp.bind(this),this.$rows.onclick=this.clickRow.bind(this),this.$rows.addEventListener("customSelect.changed",this.unitChanged.bind(this)),this.initSelects(),setTimeout(this.deleteSelected.bind(this),800))}initSelects(){this.$rows.querySelectorAll("[select-new]").forEach((t=>{new s.A(t)}))}deleteSelected(){let t=this.$rows.querySelectorAll(".selected");t=Array.from(t).map((t=>{if(+t.dataset.value)return t.dataset.value})),this.$table.querySelectorAll("[custom-select]").forEach((function(e){e.querySelectorAll("li").forEach((function(e){t.includes(e.dataset.value)&&e.remove()}))}))}createRow(){let t=this.$baseUnit.selectedOptions[0].innerText,e=(new a.n).tag("div").attr("class","row").get(),i=this.$selector.cloneNode(!0),d=(new a.n).attr("type","number").tag("input").attr("value",10).get(),n=(new a.n).tag("div").attr("class","base-unit").text(t).get(),l=(new a.n).tag("div").className("min-unit").get(),r=(new a.n).tag("input").attr("type","checkbox").get(),c=(new a.n).tag("div").attr("class","del").text("X").get();e.append(i),e.append(d),e.append(n),l.append(r),e.append(l),e.append(c),new s.A(i),this.$rows.append(e),this.deleteSelected()}async unitChanged(t){let e=this.dto(t.target.closest(".row"));e.morphed.new_id=t.detail.next.value,e.morphed.old_id=t.detail.prev.value,t.detail.next.value&&this.deleteSelectedUnitFromSelects(t.detail.next.value),t.detail.prev.value&&this.addDeletedUnitToSelects(t.detail.prev),await(0,a.bE)("/adminsc/product/changeUnit",e)}deleteSelectedUnitFromSelects(t){this.$table.querySelectorAll("[custom-select]").forEach((function(e){e.querySelectorAll("li").forEach((function(e){e.dataset.value===t&&e.remove()}))}))}addDeletedUnitToSelects(){this.$table.querySelectorAll("[custom-select]").forEach((function(t){t.querySelectorAll("li").forEach((function(t){t.dataset.value===value&&t.remove()}))}))}async clickRow(t){let{target:e}=t;if(e.classList.contains("del")){var i;let t=e.closest(".row"),s=this.dto(t);s.morphed.detach=1;let d=await(0,a.bE)("/adminsc/product/changeunit",s);null!=d&&null!==(i=d.arr)&&void 0!==i&&i.ok&&t.remove()}}handleKeyUp(t){let e=+t.target.value;/\d+/.test(e)&&this.update(t,this)}handleChange(t){this.update(t,this)}async update(t,e){let i=t.target.closest(".row");if(!+(0,a.$)(i).find("[select-new]").dataset.value)return!1;let s=e.dto(i);s.morphed.new_id=s.morphed.old_id,await(0,a.bE)("/adminsc/product/changeUnit",s)}dto(t){let e={product_id:this.product1sId,multiplier:+(0,a.$)(t).find("input[type='number']").value??0,main:(0,a.$)(t).find("input[type='checkbox']").checked?1:null},i={new_id:0,old_id:+this.getUnitId(t),detach:0};return{baseUnitId:this.getBaseUnitId(),pivot:e,morphed:i}}getBaseUnitId(){return+this.$baseUnit.options[this.$baseUnit.selectedIndex].value}getUnitId(t){return t.querySelector("[select-new]").dataset.value??0}}(".units");class d{constructor(t){this.$product=t,this.$values=(0,a.$)(t).find(".values"),this.values=this.$values.querySelectorAll(".value"),this.$values.addEventListener("customSelect.changed",this.selectChanged.bind(this)),this.values.forEach((t=>{new s.A(t)}))}dto(){return{product_id:this.$product.dataset.id,morphed:{old_id:0,new_id:0}}}async selectChanged(t){let e=this.dto();e.morphed.old_id=t.detail.prev.value,e.morphed.new_id=t.detail.next.value,await(0,a.bE)("/adminsc/product/changeVal",e)}}const n="querySelector";class l{constructor(t){this.$product=t,this.$fields=(0,a.$)(".item_content").first(),this.$category_id=(0,a.$)('[data-field="category_id"]').first(),this.$promotions=(0,a.$)('[data-field="promotions"]').first(),this.$base_unit=(0,a.$)('[data-field="base_unit"]').first(),this.$manufacturer_id=(0,a.$)('[data-field="manufacturer_id"]').first(),this.$printName=(0,a.$)("[data-field='print_name']").first(),this.$printName.addEventListener("catalogItem.changed",this.changePrintName.bind(this)),this.$productUrl=(0,a.$)("[data-field='slug']").first(),this.setup()}setup(){this.$fields.addEventListener("customSelect.changed",this.changeFields.bind(this)),new s.A(this.$category_id),new s.A(this.$promotions),new s.A(this.$base_unit),new s.A(this.$manufacturer_id)}changePrintName(t){if(t.detail){var e,i,a;let s=this.$productUrl.querySelector("a"),d=null===(e=t.detail)||void 0===e||null===(i=e.res)||void 0===i||null===(a=i.arr)||void 0===a?void 0:a.model.slug;s.setAttribute("href",`/product/${d}`),s.text=d}}async checkBoxChanged(t){let{target:e}=t,i=this.dto(this);i[e.dataset.field]=+e.checked,await(0,a.bE)("/adminsc/product/updateOrCreate",i)}async changeFields(t){let e=t.detail.target.dataset.field;if(!e)return;let i=this.dto(t);i[e]=t.detail.next.value,await(0,a.bE)("/adminsc/product/updateOrCreate",i)}dto(t){return{id:this.$product.dataset.id}}}var r=i(529);function c(){const t=document[n](".item-wrap\n  [data-model='product']");if(!t)return!1;new d(t),new l(t),new r.A((0,a.$)(".add-file")[0],o)}async function o(t,e){const i={productId:e.closest(".item-wrap").dataset.id};let s=(0,a.yF)(i,t[0]),d=await(0,a.bE)("/adminsc/product/attachMainImage",s),n=null==d?void 0:d.arr[0];if(n){let t=e.closest(".dnd-container").querySelector("img");t.removeAttribute("src"),t.setAttribute("src",n)}}}}]);
//# sourceMappingURL=26.js.map