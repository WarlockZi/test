import"./admin-BLv8D_5X.js";import{q as l,a as n,$ as a,p as r,S as o}from"./search-CxgNiI2j.js";import{M as c}from"./MyQuill-CLgBwkg2.js";import"./Promotion-CXtqK2P4.js";class h{constructor(e){this.el=e,this.$addBtn=this.el[l](".add-property"),this.$addBtn&&this.$addBtn[n]("click",this.newRow.bind(this))}async handleClick({target:e}){e.classList.contains("del")?this.deleteRow(e):e.classList.contains("edit")&&this.editProperty(e)}async editProperty(e){let t=e.closest(".row").querySelector("[select-new]").dataset.value;location.href=`/adminsc/property/edit/${t}`}async deleteRow(e){let t=e.closest(".row"),d=+a(t).find("[select-new]").dataset.value,s=this.dto();s.morphed.new_id=0,s.morphed.old_id=d,(await r("/adminsc/category/changeProperty",s))?.ok&&t.remove()}async propertyChange(e){{let t=this.dto(e);await r("/adminsc/category/changeProperty",t)}}dto(e={}){return{category_id:this.el.closest('[data-model="category"]').dataset.id,morphed:{old_id:+e?.detail?.prev?.value,new_id:+e?.detail?.next?.value}}}newRow(){let e=this.rowsWrap.querySelector(".none .row").cloneNode(!0);new o(a(e).find("[custom-select]")),this.rowsWrap.append(e)}}class g{constructor(e){this.el=e,this.id=e.dataset.id,this.setCategoryId(),this.setProperties(),new c("#seo_article",!0,!0,!0,"snow",this.dto())}setCategoryId(){const e=a("[data-field='category_id']").first();new o(e).sel.addEventListener("customSelect.changed",this.attachCategory.bind(this))}setProperties(){new h(this.el.querySelector('[data-relation="properties"]'))}dto(e){return{id:this.id,relation:"ownProperties",fields:{seo_article:e}}}attachCategory({detail:e}){const t={id:this.id,relation:e.target.dataset.relationmodel,fields:{category_id:+e.next.value}};r("/adminsc/category/updateOrCreate",t)}}export{g as default};
//# sourceMappingURL=Category-BT2tVH8a.js.map
