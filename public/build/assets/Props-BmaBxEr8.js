import"./Product-D64pG-_4.js";import{$ as i,post as r}from"./common-CWUZwUnI.js";import{S as s}from"./SelectNew-DQsOGtuz.js";import"./search-Btw97w8w.js";import"./admin-DFVIS8Rt.js";import"./MyQuill-CqTUtJle.js";import"./QuillFactory-B5PcKREQ.js";class m{constructor(t){this.$product=t,this.properties=i(t).find(".values"),this.values=this.properties.querySelectorAll(".value"),this.properties.addEventListener("customSelect.changed",this.selectChanged.bind(this)),this.values.forEach(e=>{new s(e)})}dto(){return{product_id:this.$product.dataset.id,morphed:{old_id:0,new_id:0}}}async selectChanged(t){let e=this.dto();e.morphed.old_id=t.detail.prev.value,e.morphed.new_id=t.detail.next.value,await r("/adminsc/product/changeVal",e)}}export{m as default};
//# sourceMappingURL=Props-BmaBxEr8.js.map
