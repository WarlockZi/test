import{$ as o,m as d,a as e,q as a,b as h}from"./search-CxgNiI2j.js";class f{constructor(s){this.modal=o("[data-modal='default']").first(),!(!s?.triggers||!s?.boxes||!this.modal)&&(this.triggers=s.triggers,this.boxes=s.boxes,this.overlay=o(this.modal).find(".overlay"),this.wrap=o(this.modal).find(".wrap"),this.content=o(this.modal).find(".content"),this.box=o(this.modal).find(".box"),this.closeEl=o(this.modal).find(".modal-close"),this.triggers.forEach(t=>{d(t)&&d(t)[e]("click",this.show.bind(this))}),this.overlay[e]("click",this.close.bind(this)),this.modal[e]("modal.switch",this.switch.bind(this)))}switch({target:s}){const t=s.closest(".box");t[e]("transitionend",this.removeClasses,{once:!0}),t.classList.add("translate-left");const i=s.dataset.target;this.wrap[a](`[id='${i}']`).classList.add("transform-in")}removeClasses({target:s}){s.classList.remove("transform-in"),s.classList.remove("translate-left")}show(){this.renderBoxes(),this.modal.classList.remove("invisible"),this.overlay.classList.add("blur"),this.wrap[a](".box:nth-child(2)").classList.add("transform-in")}close({target:s}){if(!s.classList.contains("modal-close")&&!s.classList.contains("overlay"))return;const t=this.wrap[a](".transform-in");t[e]("transitionend",this.transitionHandler.bind(this)),t?.removeEventListener("transitionend",this.transitionHandler,{once:!0}),t?.classList.remove("transform-in"),this.overlay.classList.remove("blur")}transitionHandler(){this.modal.classList.add("invisible"),this.wrap[h](".box[id]").forEach(s=>s.remove())}renderBoxes(){for(let s in this.boxes){const t=this.boxes[s],i=this.box.cloneNode(!0);i[e]("click",this.close.bind(this)),i.id=s,i[a](".title").innerText=t[0][0];for(let n in t){const r=t[n];for(let l in r)l>0&&i[a](".content").appendChild(r[l])}this.wrap.appendChild(i)}}}export{f as default};
//# sourceMappingURL=modal-DP9eYFRu.js.map
