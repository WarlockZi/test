const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["./TestDo-DgkUX2-x.js","./common-DnUtA5kF.js","./constants-D_Ps4z6O.js","./TestDo-D6IyUqVr.css","./test-edit-B1erBc0p.js","./admin-Bz99aEHZ.js","./search-BDRlSmDO.js","./search-CWOthOO5.css","./MyQuill-BnALqy0A.js","./MyQuill-B2DiOfU9.css","./admin-PQOkcFhE.css","./cookie-BBwOsGpm.js","./cookie-D27E5iiV.css","./test-edit-BaL4Q1vr.css"])))=>i.map(i=>d[i]);
import{$ as s,_ as d}from"./common-DnUtA5kF.js";import"./admin-Bz99aEHZ.js";import"./cookie-BBwOsGpm.js";class v{constructor(t){this.pClass=t.pClass??"",this.pActiveClass=t.pActiveClass??"",this.pageClass=t.pageClass??"",this.pageActiveClass=t.pageActiveClass??"",this.prevBttnId=t.prevBttnId??null,this.nextBttnId=t.nextBttnId??null,this.paginations=s(this.pClass),this.activePClass=`${this.pClass}.${this.pActiveClass}`,this.activePageClass=`.${this.pageClass}.${this.pageActiveClass}`,this.paginations.length&&(this.navInit(),s(this.pClass).on("click",this.handleClick.bind(this)),this.prevBttnId&&(s(this.prevBttnId).on("click",this.handleNextPrev.bind(this)),s(this.nextBttnId).on("click",this.handleNextPrev.bind(this))))}navInit(){[].map.call(this.paginations,t=>{t.classList.remove(this.pActiveClass)}),this.paginations[0].classList.add(this.pActiveClass)}handleNextPrev({target:t}){let i=s(this.activePageClass)[0],a=s(this.activePClass)[0],e=this.paginations.indexOf(a);t===this.prevBttnId?g.call(this):t===this.nextBttnId&&p.call(this);function g(){if(e<1)return!1;let l=this.paginations[e-1];this.togglePage(l,i).bind(this),this.toggleNav(l,a)}function p(){if(e>this.paginations.length-2)return!1;let l=this.paginations[e+1];this.togglePage(l,i).bind(this),this.toggleNav(l,a)}}toggleNav(t,i){i.classList.toggle(this.pActiveClass),t.classList.toggle(this.pActiveClass)}togglePage(t,i){let a=t.dataset.pagination;s(`.${this.pageClass}[data-id='${a}']`)[0].classList.toggle(this.pageActiveClass),i.classList.toggle(this.pageActiveClass)}handleClick({target:t}){if(!t.dataset.pagination||t.classList.contains(this.pActiveClass))return;let i=s(this.activePClass)[0];i.classList.remove(this.pActiveClass),t.classList.add(this.pActiveClass);let a=i.dataset.pagination;s(`.${this.pageClass}[data-id="${a}"]`).removeClass(this.pageActiveClass);let e=t.dataset.pagination;s(`.${this.pageClass}[data-id="${e}"]`).addClass(this.pageActiveClass)}}function C(){return new v({pClass:"[data-pagination]",pActiveClass:"active",pageClass:"question",pageActiveClass:"show",prevBttnId:"#prev",nextBttnId:"#next"})}new C;const c=s(".test-do").first();if(c){const{default:n}=await d(async()=>{const{default:t}=await import("./TestDo-DgkUX2-x.js");return{default:t}},__vite__mapDeps([0,1,2,3]),import.meta.url);new n(c)}const r=s(".test-edit").first();if(r){const{default:n}=d(()=>import("./test-edit-B1erBc0p.js"),__vite__mapDeps([4,5,1,2,6,7,8,9,10,11,12,13]),import.meta.url);new n(n)}const o=s(".o-test-do").first();o&&new o(o);const h=s(".o-test-edit").first();h&&new h(h);const _=Object.freeze(Object.defineProperty({__proto__:null},Symbol.toStringTag,{value:"Module"}));export{_ as i,C as p};
//# sourceMappingURL=index-CSXUca2H.js.map
