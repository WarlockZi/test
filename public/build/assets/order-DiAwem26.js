import{S as i}from"./SelectNew-DllE7yTy.js";import{$ as r,p as s}from"./search-BrCwmJVC.js";class n{constructor(){this.$order=r(".order-edit").first(),this.$order&&(this.billId=r(this.$order).find("#order-id"),this.$manager=r("[select-new]").first(),new i(this.$manager),this.$order.addEventListener("customSelect.changed",this.changeUser.bind(this)),this.$bill=r(".bill").first())}changeUser({detail:t}){debugger;let e=this.dto(this,t);s("/adminsc/order/updateOrCreate",e)}dto(t,e){return{id:t.id,prev:e?.prev,next:e?.next}}}export{n as default};
//# sourceMappingURL=order-DiAwem26.js.map
