import"./Product-DVLcwbji.js";import{$ as i,S as s,p as d}from"./search-CxgNiI2j.js";import"./admin-BLv8D_5X.js";import"./MyQuill-CLgBwkg2.js";import"./Promotion-CXtqK2P4.js";class c{constructor(e){this.$product=e,this.properties=i(e).find(".values"),this.values=this.properties.querySelectorAll(".value"),this.properties.addEventListener("customSelect.changed",this.selectChanged.bind(this)),this.values.forEach(t=>{new s(t)})}dto(){return{product_id:this.$product.dataset.id,morphed:{old_id:0,new_id:0}}}async selectChanged(e){let t=this.dto();t.morphed.old_id=e.detail.prev.value,t.morphed.new_id=e.detail.next.value,await d("/adminsc/product/changeVal",t)}}export{c as default};
//# sourceMappingURL=Props-DI9JAMx7.js.map
