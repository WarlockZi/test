import"./admin-C5dptWuZ.js";import{$ as o,p as s}from"./common-BmjU9IJD.js";import{S as r}from"./SelectNew-CPsXQT8S.js";import{q as l,a as c}from"./constants-D_Ps4z6O.js";import{Q as n,a as p}from"./QuillFactory-B6r5pkQO.js";import"./search-DgdaroTd.js";import"./MyQuill-uS4Hutk7.js";class h{constructor(e){this.el=e,this.$addBtn=this.el[l](".add-property"),this.$addBtn&&this.$addBtn[c]("click",this.newRow.bind(this))}async handleClick({target:e}){e.classList.contains("del")?this.deleteRow(e):e.classList.contains("edit")&&this.editProperty(e)}async editProperty(e){let t=e.closest(".row").querySelector("[select-new]").dataset.value;location.href=`/adminsc/property/edit/${t}`}async deleteRow(e){let t=e.closest(".row"),d=+o(t).find("[select-new]").dataset.value,a=this.dto();a.morphed.new_id=0,a.morphed.old_id=d,(await s("/adminsc/category/changeProperty",a))?.ok&&t.remove()}async propertyChange(e){{let t=this.dto(e);await s("/adminsc/category/changeProperty",t)}}dto(e={}){return{category_id:this.el.closest('[data-model="category"]').dataset.id,morphed:{old_id:+e?.detail?.prev?.value,new_id:+e?.detail?.next?.value}}}newRow(){let e=this.rowsWrap.querySelector(".none .row").cloneNode(!0);new r(o(e).find("[custom-select]")),this.rowsWrap.append(e)}}class P{constructor(e){this.el=e,this.id=e.dataset.id,this.setCategoryId(),this.setProperties(),n.create("#seo-article",p.ADMIN_CATEGORY_SEO_ARTICLE)}setCategoryId(){const e=o("[data-field='category_id']").first();new r(e)}setProperties(){new h(this.el.querySelector('[data-relation="properties"]'))}dto(e){return{id:this.id,relation:"ownProperties",fields:{seo_article:e}}}attachCategory({detail:e}){const t={id:this.id,relation:e.target.dataset.relationmodel,fields:{category_id:+e.next.value}};s("/adminsc/category/updateOrCreate",t)}}export{P as default};
//# sourceMappingURL=Category-DzUl2tDA.js.map
