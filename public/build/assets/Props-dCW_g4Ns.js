import"./Product-Cv_VUOka.js";import{$ as i,p as r}from"./common-DVK5bmCY.js";import{S as s}from"./Promotion-ChOnCgrY.js";/* empty css                */import"./constants-Clh-pk9Y.js";import"./quill-CEce6B16.js";import"./quill.snow-DpC92mTv.js";class m{constructor(t){this.$product=t,this.properties=i(t).find(".values"),this.values=this.properties.querySelectorAll(".value"),this.properties.addEventListener("customSelect.changed",this.selectChanged.bind(this)),this.values.forEach(e=>{new s(e)})}dto(){return{product_id:this.$product.dataset.id,morphed:{old_id:0,new_id:0}}}async selectChanged(t){let e=this.dto();e.morphed.old_id=t.detail.prev.value,e.morphed.new_id=t.detail.next.value,await r("/adminsc/product/changeVal",e)}}export{m as default};
