const __vite__fileDeps=["assets/test-do-C1NZ0zJg.js","assets/common-DVK5bmCY.js","assets/test-do-B63tKhVy.css","assets/test-edit-DRP3pyw-.js","assets/test-edit-CXQ2oW1T.css"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{$ as s,_ as g}from"./common-DVK5bmCY.js";class v{constructor(t){this.pClass=t.pClass??"",this.pActiveClass=t.pActiveClass??"",this.pageClass=t.pageClass??"",this.pageActiveClass=t.pageActiveClass??"",this.prevBttnId=t.prevBttnId??null,this.nextBttnId=t.nextBttnId??null,this.paginations=s(this.pClass),this.activePClass=`${this.pClass}.${this.pActiveClass}`,this.activePageClass=`.${this.pageClass}.${this.pageActiveClass}`,this.paginations.length&&(this.navInit(),s(this.pClass).on("click",this.handleClick.bind(this)),this.prevBttnId&&(s(this.prevBttnId).on("click",this.handleNextPrev.bind(this)),s(this.nextBttnId).on("click",this.handleNextPrev.bind(this))))}navInit(){[].map.call(this.paginations,t=>{t.classList.remove(this.pActiveClass)}),this.paginations[0].classList.add(this.pActiveClass)}handleNextPrev({target:t}){let i=s(this.activePageClass)[0],a=s(this.activePClass)[0],e=this.paginations.indexOf(a);t===this.prevBttnId?d.call(this):t===this.nextBttnId&&p.call(this);function d(){if(e<1)return!1;let l=this.paginations[e-1];this.togglePage(l,i).bind(this),this.toggleNav(l,a)}function p(){if(e>this.paginations.length-2)return!1;let l=this.paginations[e+1];this.togglePage(l,i).bind(this),this.toggleNav(l,a)}}toggleNav(t,i){i.classList.toggle(this.pActiveClass),t.classList.toggle(this.pActiveClass)}togglePage(t,i){let a=t.dataset.pagination;s(`.${this.pageClass}[data-id='${a}']`)[0].classList.toggle(this.pageActiveClass),i.classList.toggle(this.pageActiveClass)}handleClick({target:t}){if(!t.dataset.pagination||t.classList.contains(this.pActiveClass))return;let i=s(this.activePClass)[0];i.classList.remove(this.pActiveClass),t.classList.add(this.pActiveClass);let a=i.dataset.pagination;s(`.${this.pageClass}[data-id="${a}"]`).removeClass(this.pageActiveClass);let e=t.dataset.pagination;s(`.${this.pageClass}[data-id="${e}"]`).addClass(this.pageActiveClass)}}function C(){return new v({pClass:"[data-pagination]",pActiveClass:"active",pageClass:"question",pageActiveClass:"show",prevBttnId:"#prev",nextBttnId:"#next"})}new C;const c=s(".test-do").first();if(c){const{default:n}=g(()=>import("./test-do-C1NZ0zJg.js"),__vite__mapDeps([0,1,2]));new n(c)}const r=s(".test-edit").first();if(r){const{default:n}=g(()=>import("./test-edit-DRP3pyw-.js"),__vite__mapDeps([3,1,4]));new n(n)}const h=s(".o-test-do").first();h&&new h(h);const o=s(".o-test-edit").first();o&&new o(o);const P=Object.freeze(Object.defineProperty({__proto__:null},Symbol.toStringTag,{value:"Module"}));export{P as i,C as p};
