/* empty css                */import{$ as i,p as d}from"./constants-D6t7YzCi.js";import{S as l}from"./Promotion-08ArJgoL.js";import{m as c}from"./admin-BbB-bfei.js";import"./preload-helper-DaGCtZ-7.js";import"./search-DQiu1Dxx.js";import"./quill.snow-BxDoWBhC.js";class h{constructor(e){this.$el=e,this.$rows=this.$el.querySelector(".rows"),this.rows=this.$el.querySelectorAll(".rows>.row"),this.$addBtn=this.$el.querySelector(".add-property"),this.setup()}setup(){this.$addBtn&&(this.$addBtn.onclick=this.newRow.bind(this)),this.rows.forEach(e=>{e.classList.contains("none")||new l(i(e).find("[custom-select]"))}),this.$rows.addEventListener("customSelect.changed",this.propertyChange.bind(this)),this.$rows.addEventListener("click",this.handleClick.bind(this))}async handleClick({target:e}){e.classList.contains("del")?this.deleteRow(e):e.classList.contains("edit")&&this.editProperty(e)}async editProperty(e){let t=e.closest(".row").querySelector("[select-new]").dataset.value;location.href=`/adminsc/property/edit/${t}`}async deleteRow(e){let t=e.closest(".row"),r=+i(t).find("[select-new]").dataset.value,s=this.dto();s.morphed.new_id=0,s.morphed.old_id=r;let o=await d("/adminsc/category/changeProperty",s);o!=null&&o.ok&&t.remove()}async propertyChange(e){{let t=this.dto(e);await d("/adminsc/category/changeProperty",t)}}dto(e={}){var t,a,r,s;return{category_id:this.$el.closest('[data-model="category"]').dataset.id,morphed:{old_id:+((a=(t=e==null?void 0:e.detail)==null?void 0:t.prev)==null?void 0:a.value),new_id:+((s=(r=e==null?void 0:e.detail)==null?void 0:r.next)==null?void 0:s.value)}}}newRow(){let e=this.$rows.querySelector(".none .row").cloneNode(!0);new l(i(e).find("[custom-select]")),this.$rows.append(e)}}class f{constructor(e){this.$el=e,this.id=e.dataset.id,this.$properties_table=this.$el.querySelector(".properties"),this.$parent_category=i("[data-field='category_id']").first(),this.$mainImage=this.$el.querySelector(".mainImage"),this.setup(),this.dto=this.dto()}setup(){this.$properties_table&&new h(this.$properties_table),this.$parent_category&&new l(this.$parent_category).sel.addEventListener("customSelect.changed",this.attachCategory.bind(this)),i("[data-dnd]").forEach(t=>{t.parentNode.dataset.morphModel&&new c(t,$category)})}dto(){return{id:this.$el.dataset.id}}attachCategory({detail:e}){debugger;let t={id:this.id,category_id:+e.next.value};d("/adminsc/category/updateOrCreate",t)}}export{f as default};
