(()=>{"use strict";new class{constructor(e){this.$accordeon=document.querySelector(e),this.$accordeon&&(this.elementOld=null,this.element=null,this.content=null,this.icon=null,this.openClass="accordeon-item_open",this.contentClass=".accordeon-item-content",this.iconSelectror=".accordeon-trigger",this.$accordeon.addEventListener("click",this.toggleAccordion.bind(this)))}toggleAccordion({target:e}){this.element=e.closest(".accordeon-item"),this.element&&(e.closest(".accordeon-item-content")||(this.content=this.element.querySelector(this.contentClass),this.icon=this.element.querySelector(this.iconSelectror),null!=this.elementOld&&this.close(),this.elementOld!==this.element?this.open():this.elementOld=null))}open(){this.element.classList.add(this.openClass),this.content.style.maxHeight=this.content.scrollHeight+"px";let e=this.$accordeon.querySelector(".rotate");e&&e.classList.remove("rotate"),this.elementOld=this.element,this.icon.classList.add("rotate")}close(){this.elementOld.classList.remove(this.openClass),this.elementOld.querySelector(this.contentClass).style.maxHeight="0px",this.icon.classList.remove("rotate")}}(".accordeon")})();
//# sourceMappingURL=bot.js.map