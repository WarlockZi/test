<<<<<<< HEAD:public/build/assets/shippableUnitsTable-Cna3Yiy9.js
import{p as u}from"./common-BmjU9IJD.js";import{a as l,q as s,b as a}from"./constants-D_Ps4z6O.js";class p{constructor(t){if(!t)return!1;this.table=t,this.table[l]("click",this.handleClick.bind(this)),this.blueButton=this.table[s](".blue-button")??null,this.greenButtonWrap=this.table[s](".green-button-wrap")??null,this.price=+this.table.dataset.price,this.sid=this.table.dataset["1sid"],this.total=this.table[s]("[data-total]"),this.updateOrCreateUrl=this.table[s]("[data-total]"),this.setFormatter(),this.showButtons(),this.renderSums()}showButtons(){if(!this.blueButton||!this.greenButtonWrap)return!1;this.getTotalCount()?(this.blueButton.style.display="none",this.greenButtonWrap.style.display="flex"):(this.blueButton.style.display="flex",this.greenButtonWrap.style.display="none")}handleClick({target:t}){const e=t??this.table;if(e.classList.contains("blue-button"))this.showGreenButton(e);else if(e.classList.contains("green-button"))window.location.href="/cart";else if(e.classList.contains("plus")){const i=e.closest(".unit-row");this.increment(i)}else if(e.classList.contains("minus")){const i=e.closest(".unit-row");this.decrement(i)}}increment(t){t[s]("input").value++,t.dataset.rowSum=""+t[s]("input").value,this.handleChange(t)}decrement(t){const e=t[s]("input");+e.value<2?e.value="0":(e.value--,t.dataset.rowSum=e.value),this.handleChange(t)}getTotalCount(){return[...this.table[a]("input")].reduce((t,e)=>t+ +e.value,0)}handleChange(t){const e=this.getTotalCount(t);this.renderSums(),e===0?(this.showBlueButton(),this.toServer(this.dto(t))):this.toServer(this.dto(t))}renderSums(){let t=[...this.table[a](".unit-row")].reduce((e,i,h)=>{const n=this.rowDto(i);let r=+this.price*+n.multiplier*+n.count;return n.sub_sum&&(n.sub_sum.innerText=this.formatter.format(r)),e+r},0);this.total&&(this.total.innerText=this.formatter.format(t))}showBlueButton(){if(!this.blueButton)return!1;this.getTotalCount()||(this.greenButtonWrap.style.display="none",this.greenButtonWrap[s]("input").value="0",this.blueButton.style.display="flex",this.deleteOrderItems(this.tableDTO(this.table)))}showGreenButton(){if(!this.greenButtonWrap)return!1;window.YM("tovar_v_korzine"),this.greenButtonWrap.style.display="flex";const t=+this.greenButtonWrap[s]("input").value;this.greenButtonWrap[s]("input").value=t||1,this.renderSums(),this.blueButton.style.display="none",this.toServer(this.dto(this.greenButtonWrap[s]("[unit-row]")))}deleteOrderItems(t){u("/cart/delete",t)}async toServer(t){await u("/cart/updateOrCreate",t)}setFormatter(){this.formatter=new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2})}rowDto(t){return{count:t[s]("input").value,multiplier:t.dataset.multiplier,sub_sum:t[s](".sub-sum"),sess_id:localStorage.getItem("SESSION")}}tableDTO(t){return{unit_ids:this.unitIds(t),product_id:this.sid}}unitIds(t){return[...t[a]("[unit-row]")].map(e=>e.dataset.unitid)}dto(t){return{count:t[s]("input").value,unit_id:t.dataset.unitid,product_id:this.sid,loc_storage_cart_id:localStorage.getItem("loc_storage_cart_id")}}}export{p as s};
//# sourceMappingURL=shippableUnitsTable-Cna3Yiy9.js.map
=======
import{post as u}from"./common-CWUZwUnI.js";import{a as l,q as s,d as a}from"./search-Btw97w8w.js";class p{constructor(t){if(!t)return!1;this.table=t,this.table[l]("click",this.handleClick.bind(this)),this.blueButton=this.table[s](".blue-button")??null,this.greenButtonWrap=this.table[s](".green-button-wrap")??null,this.price=+this.table.dataset.price,this.sid=this.table.dataset["1sid"],this.total=this.table[s]("[data-total]"),this.updateOrCreateUrl=this.table[s]("[data-total]"),this.setFormatter(),this.showButtons(),this.renderSums()}showButtons(){if(!this.blueButton||!this.greenButtonWrap)return!1;this.getTotalCount()?(this.blueButton.style.display="none",this.greenButtonWrap.style.display="flex"):(this.blueButton.style.display="flex",this.greenButtonWrap.style.display="none")}handleClick({target:t}){const e=t??this.table;if(e.classList.contains("blue-button"))this.showGreenButton(e);else if(e.classList.contains("green-button"))window.location.href="/cart";else if(e.classList.contains("plus")){const i=e.closest(".unit-row");this.increment(i)}else if(e.classList.contains("minus")){const i=e.closest(".unit-row");this.decrement(i)}}increment(t){t[s]("input").value++,t.dataset.rowSum=""+t[s]("input").value,this.handleChange(t)}decrement(t){const e=t[s]("input");+e.value<2?e.value="0":(e.value--,t.dataset.rowSum=e.value),this.handleChange(t)}getTotalCount(){return[...this.table[a]("input")].reduce((t,e)=>t+ +e.value,0)}handleChange(t){const e=this.getTotalCount(t);this.renderSums(),e===0?(this.showBlueButton(),this.toServer(this.dto(t))):this.toServer(this.dto(t))}renderSums(){let t=[...this.table[a](".unit-row")].reduce((e,i,h)=>{const n=this.rowDto(i);let r=+this.price*+n.multiplier*+n.count;return n.sub_sum&&(n.sub_sum.innerText=this.formatter.format(r)),e+r},0);this.total&&(this.total.innerText=this.formatter.format(t))}showBlueButton(){if(!this.blueButton)return!1;this.getTotalCount()||(this.greenButtonWrap.style.display="none",this.greenButtonWrap[s]("input").value="0",this.blueButton.style.display="flex",this.deleteOrderItems(this.tableDTO(this.table)))}showGreenButton(){if(!this.greenButtonWrap)return!1;window.YM("tovar_v_korzine"),this.greenButtonWrap.style.display="flex";const t=+this.greenButtonWrap[s]("input").value;this.greenButtonWrap[s]("input").value=t||1,this.renderSums(),this.blueButton.style.display="none",this.toServer(this.dto(this.greenButtonWrap[s]("[unit-row]")))}deleteOrderItems(t){u("/cart/delete",t)}async toServer(t){await u("/cart/updateOrCreate",t)}setFormatter(){this.formatter=new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2})}rowDto(t){return{count:t[s]("input").value,multiplier:t.dataset.multiplier,sub_sum:t[s](".sub-sum"),sess_id:localStorage.getItem("SESSION")}}tableDTO(t){return{unit_ids:this.unitIds(t),product_id:this.sid}}unitIds(t){return[...t[a]("[unit-row]")].map(e=>e.dataset.unitid)}dto(t){return{count:t[s]("input").value,unit_id:t.dataset.unitid,product_id:this.sid,loc_storage_cart_id:localStorage.getItem("loc_storage_cart_id")}}}export{p as s};
//# sourceMappingURL=shippableUnitsTable-CFUtE5th.js.map
>>>>>>> 34ae65b937a2b63dfa5b35d77ee96d0c5a192494:public/build/assets/shippableUnitsTable-CFUtE5th.js
