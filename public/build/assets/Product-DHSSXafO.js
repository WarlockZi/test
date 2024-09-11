const __vite__fileDeps=["assets/Fields-BZXBFLT9.js","assets/Promotion-c7-OSdTF.js","assets/constants-mwD5SO1c.js","assets/Promotion-DnuCazsS.css","assets/Props-B1EdCr7e.js","assets/product-DQYvEQKo.css","assets/card_panel-BDLLHdw7.js","assets/card_panel-COc34v_C.css"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{$ as n,e as d,g as w,i as f,p as c,q as u,_ as r,o as v}from"./constants-mwD5SO1c.js";/* empty css                */import{S as p}from"./Promotion-c7-OSdTF.js";class _{constructor(t){this.$table=n(t).first(),this.$table&&(this.product1sId=n("[data-field='1s_id']").first().innerText,this.$addUnit=n(".add-unit").first(),this.$rows=n(".rows").first(),this.$emtyRow=n(this.$rows).find(".none"),this.$addUnit.onclick=this.createRow.bind(this),this.$rows.onchange=this.handleChange.bind(this),this.$rows.onkeyup=this.handleKeyUp.bind(this),this.$rows.onclick=this.clickRow.bind(this),this.$rows.addEventListener("customSelect.changed",this.unitChanged.bind(this)),setTimeout(this.deleteSelected.bind(this),800))}initSelects(){this.$rows.querySelectorAll("[custom-select]").forEach(t=>{new p(t)})}deleteSelected(){let t=this.$rows.querySelectorAll(".selected");t=Array.from(t).map(e=>{if(+e.dataset.value)return e.dataset.value}),this.$table.querySelectorAll("[custom-select]").forEach(function(e){e.querySelectorAll("li").forEach(function(s){t.includes(s.dataset.value)&&s.remove()})})}createSelect(t){const e=new d().tag("select").attr("new-select").className("name").get();return[...t[w]("li")].map(s=>{const a=new d().tag("option").attr("value",s.dataset.value).text(s[f]).get();e.append(a)}),e}createRow(){const t=this.$baseUnit.selectedOptions[0].innerText,e=new d().tag("div").attr("class","row").get(),s=this.createSelect(this.$emtyRow),a=new d().attr("type","number").tag("input").attr("value",10).className("multiplier").get(),i=new d().tag("div").attr("class","base-unit").text(t).get(),l=new d().tag("div").className("shippable").get(),o=new d().tag("input").attr("type","checkbox").get(),m=new d().tag("div").attr("class","del").text("X").get();e.append(s),e.append(a),e.append(i),l.append(o),e.append(l),e.append(m),new p(s),this.$rows.append(e)}async unitChanged(t){let e=this.dto(t.target.closest(".row"));e.morphed.new_id=t.detail.next.value,e.morphed.old_id=t.detail.prev.value,t.detail.next.value&&this.deleteSelectedUnitFromSelects(t.detail.next.value),t.detail.prev.value&&this.addDeletedUnitToSelects(t.detail.prev),await c("/adminsc/product/changeUnit",e)}deleteSelectedUnitFromSelects(t){this.$table.querySelectorAll("[custom-select]").forEach(function(e){e.querySelectorAll("li").forEach(function(a){a.dataset.value===t&&a.remove()})})}addDeletedUnitToSelects(){this.$table.querySelectorAll("[custom-select]").forEach(function(t){t.querySelectorAll("li").forEach(function(s){s.dataset.value===value&&s.remove()})})}async clickRow({target:t}){var e;if(t.classList.contains("del")){let s=t.closest(".row"),a=this.dto(s),i=await c("/adminsc/product/deleteUnit",a);(e=i==null?void 0:i.arr)!=null&&e.ok&&s.remove()}}handleKeyUp(t){let e=+t.target.value;/\d+/.test(e)&&this.update(t,this)}async handleChange({target:t}){if(t.type==="checkbox"&&t.hasAttribute("data-isbase")){const e=+t.checked,a={product_1s_id:this.product1sId,base_is_shippable:e};await c("/adminsc/product/changeBaseIsShippable",a)}else this.update(t,this)}async update(t,e){let s=t.closest(".row");if(!+n(s).find("[select-new]").dataset.value)return!1;let i=e.dto(s);i.morphed.new_id=i.morphed.old_id,await c("/adminsc/product/changeUnit",i)}dto(t){let e={product_id:this.product1sId,multiplier:+n(t).find(".multiplier").value,is_shippable:n(t).find(".shippable input").checked?1:null},s={new_id:0,old_id:+this.getUnitId(t),detach:0};return{baseUnitId:this.getBaseUnitId(),pivot:e,morphed:s}}getBaseUnitId(){return+this.$baseUnit.options[this.$baseUnit.selectedIndex].value}getUnitId(t){return t.querySelector("[select-new]").dataset.value??0}}let g=n(".units").first();g&&new _(".units");class U{constructor(){const t=document[u](".item-wrap[data-model='product']");if(!t)return!1;this.product=t,this.setProps().then(),this.setFields().then(),this.setDragNDrop().then(),this.setCardPanel().then()}async setDragNDrop(){const t=document[u]("[dnd]");if(t){const{default:e}=await r(()=>import("./dnd-BIsc27kd.js"),[]);await new e(t,this.addMainImage)}}async setFields(){const{default:t}=await r(()=>import("./Fields-BZXBFLT9.js"),__vite__mapDeps([0,1,2,3]));new t(this.product)}async setProps(){const{default:t}=await r(()=>import("./Props-B1EdCr7e.js"),__vite__mapDeps([4,2,1,3,5]));new t(this.product)}async setCardPanel(){if(document[u](".cardPanel")){const{default:e}=await r(()=>import("./card_panel-BDLLHdw7.js"),__vite__mapDeps([6,2,7]));new e}}async addMainImage(t,e){const s={productId:e.closest(".item-wrap").dataset.id},a=v(s,t[0]),i=await c("/adminsc/product/saveMainImage",a),l=i==null?void 0:i.arr[0];if(l){const o=e.closest(".dnd-container").querySelector("img");o.removeAttribute("src"),o.setAttribute("src",l)}}}export{U as default};
