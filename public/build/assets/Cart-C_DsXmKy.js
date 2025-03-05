import{$ as C,p as o,l as u,e as y}from"./common-BEiZe_HE.js";import{a as p,q as r,b as a,i as d}from"./modal-2CIG3n3z.js";import{s as T}from"./shippableUnitsTable-DnzpQBFh.js";class E{constructor(){this.container=C(".user-content .cart .content").first(),this.container&&(this.container[p]("click",this.handleClick.bind(this)),this.container[p]("keyup",this.handleKeyUp.bind(this)),this.orderId=this.container[r]("[data-order-id]").dataset.orderId,this.total=this.container[r](".total span"),this.$cartEmptyText=this.container[r](".empty-cart"),this.$cartCount=this.container[r](".cart .count"),this.rows=this.container[a](".row"),this.mapTables(),this.renderSums())}async submitCart(){const t=this.orderId;o("/cart/submit",{orderId:t}).ok}rowUnits(t){const s={};return[...t[a]("[unit-row]")].map(i=>{const e=i.dataset.unitid,n=+i[r]("input").value;n&&(s[e]=n)}),s}cartRowDTO(t){const s=t.closest(".row");return{product_id:s.dataset.productId,units:this.rowUnits(s)}}renderSums(){const t=[...this.container[a]("[shippable-table]")].reduce((s,i)=>{const e=+i.dataset.price,n=[...i[a]("[unit-row]")].reduce(function(w,c){const f=+c.dataset.multiplier,b=+c[r]("input").value,h=f*e*b,l=c[r](".subSum");return l&&(l[d]=u.format(h)),w+h}.bind(e),0),m=i.closest(".row")[r](".sub-sum");return m[d]=u.format(n),s+n},0);this.total[d]=u.format(t)}mapTables(){[...this.container[a](".shippable-table")].forEach(t=>{new T(t)})}async dropCart(){const t=y();(await o("/cart/drop",{cartToken:t}))?.arr?.ok&&this.showEmptyCart()}async handleClick({target:t}){t.classList.contains("del")?(await this.deleteCartRow(t),this.renderSums()):t.classList.contains("plus")||t.classList.contains("minus")?this.rowTotalCount(t.closest(".row"))?this.renderSums():this.renderSums():t.id==="cartSubmit"&&(YM("cart_submitted"),this.submitCart())}async handleKeyUp({target:t}){if(t.classList.contains("input")&&t.tagName==="INPUT"){this.renderSums();const s=+t.value;this.updateOrCreate(t,s)}}rowTotalCount(t){return[...t[a]("input")].reduce((s,i)=>s+ +i.value,0)}updateOrCreate(t,s){const i=t.closest("[shippable-table]").dataset["1sid"],e=t.closest("[unit-row]").dataset.unitid;o("/cart/updateOrCreate",{product_id:i,unit_id:e,count:s})}async deleteCartRow(t){(await o("/cart/deleteRow",this.cartRowDTO(t)))?.arr?.ok&&(t.closest(".row").remove(),this.rows.length<1&&this.showEmptyCart(),this.renderSums())}showEmptyCart(){this.container.innerHTML="",this.$cartEmptyText.classList.remove("none"),this.$cartCount.classList.add("none")}}export{E as default};
//# sourceMappingURL=Cart-C_DsXmKy.js.map
