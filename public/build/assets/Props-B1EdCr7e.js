import"./Product-DHSSXafO.js";import{$ as s,p as i}from"./constants-mwD5SO1c.js";import{S as d}from"./Promotion-c7-OSdTF.js";/* empty css                */class h{constructor(e){this.$product=e,this.properties=s(e).find(".values"),this.values=this.properties.querySelectorAll(".value"),this.properties.addEventListener("customSelect.changed",this.selectChanged.bind(this)),this.values.forEach(t=>{new d(t)})}dto(){return{product_id:this.$product.dataset.id,morphed:{old_id:0,new_id:0}}}async selectChanged(e){let t=this.dto();t.morphed.old_id=e.detail.prev.value,t.morphed.new_id=e.detail.next.value,await i("/adminsc/product/changeVal",t)}}export{h as default};
