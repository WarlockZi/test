const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["./TestDo-DIR6CFVI.js","./search-DV8UsOr4.js","./search-CWOthOO5.css","./TestDo-D6IyUqVr.css","./test-edit-CuhrlD5e.js","./admin-DGH2t94a.js","./MyQuill-gEQ7mOZi.js","./MyQuill-B2DiOfU9.css","./admin-DXYdymVZ.css","./test-edit-BaL4Q1vr.css"])))=>i.map(i=>d[i]);
import{$ as s,n as v,m as r,_ as g}from"./search-DV8UsOr4.js";import"./admin-DGH2t94a.js";class C{constructor(t){this.pClass=t.pClass??"",this.pActiveClass=t.pActiveClass??"",this.pageClass=t.pageClass??"",this.pageActiveClass=t.pageActiveClass??"",this.prevBttnId=t.prevBttnId??null,this.nextBttnId=t.nextBttnId??null,this.paginations=s(this.pClass),this.activePClass=`${this.pClass}.${this.pActiveClass}`,this.activePageClass=`.${this.pageClass}.${this.pageActiveClass}`,this.paginations.length&&(this.navInit(),s(this.pClass).on("click",this.handleClick.bind(this)),this.prevBttnId&&(s(this.prevBttnId).on("click",this.handleNextPrev.bind(this)),s(this.nextBttnId).on("click",this.handleNextPrev.bind(this))))}navInit(){[].map.call(this.paginations,t=>{t.classList.remove(this.pActiveClass)}),this.paginations[0].classList.add(this.pActiveClass)}handleNextPrev({target:t}){let i=s(this.activePageClass)[0],e=s(this.activePClass)[0],n=this.paginations.indexOf(e);t===this.prevBttnId?d.call(this):t===this.nextBttnId&&p.call(this);function d(){if(n<1)return!1;let l=this.paginations[n-1];this.togglePage(l,i).bind(this),this.toggleNav(l,e)}function p(){if(n>this.paginations.length-2)return!1;let l=this.paginations[n+1];this.togglePage(l,i).bind(this),this.toggleNav(l,e)}}toggleNav(t,i){i.classList.toggle(this.pActiveClass),t.classList.toggle(this.pActiveClass)}togglePage(t,i){let e=t.dataset.pagination;s(`.${this.pageClass}[data-id='${e}']`)[0].classList.toggle(this.pageActiveClass),i.classList.toggle(this.pageActiveClass)}handleClick({target:t}){if(!t.dataset.pagination||t.classList.contains(this.pActiveClass))return;let i=s(this.activePClass)[0];i.classList.remove(this.pActiveClass),t.classList.add(this.pActiveClass);let e=i.dataset.pagination;s(`.${this.pageClass}[data-id="${e}"]`).removeClass(this.pageActiveClass);let n=t.dataset.pagination;s(`.${this.pageClass}[data-id="${n}"]`).addClass(this.pageActiveClass)}}function f(){return new C({pClass:"[data-pagination]",pActiveClass:"active",pageClass:"question",pageActiveClass:"show",prevBttnId:"#prev",nextBttnId:"#next"})}u("cn");s("#cn-accept-chatLocalStorage").on("click",P);function u(a){v(a)?s("#chatLocalStorage-notice").css("bottom","-100%"):s("#chatLocalStorage-notice").css("bottom","0")}function P(){r("cn",1,3),s("#chatLocalStorage-notice").css("bottom","-100%")}new f;const h=s(".test-do").first();if(h){const{default:a}=await g(async()=>{const{default:t}=await import("./TestDo-DIR6CFVI.js");return{default:t}},__vite__mapDeps([0,1,2,3]),import.meta.url);new a(h)}const m=s(".test-edit").first();if(m){const{default:a}=g(()=>import("./test-edit-CuhrlD5e.js"),__vite__mapDeps([4,5,1,2,6,7,8,9]),import.meta.url);new a(a)}const o=s(".o-test-do").first();o&&new o(o);const c=s(".o-test-edit").first();c&&new c(c);const I=Object.freeze(Object.defineProperty({__proto__:null},Symbol.toStringTag,{value:"Module"}));export{I as i,f as p};
//# sourceMappingURL=index-B0zPbto0.js.map
