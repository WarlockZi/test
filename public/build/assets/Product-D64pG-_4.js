const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/Fields-CQyhy_Jf.js","assets/SelectNew-DQsOGtuz.js","assets/search-Btw97w8w.js","assets/common-CWUZwUnI.js","assets/search-CWOthOO5.css","assets/Props-BmaBxEr8.js","assets/admin-DFVIS8Rt.js","assets/MyQuill-CqTUtJle.js","assets/MyQuill-B2DiOfU9.css","assets/admin-DXYdymVZ.css","assets/QuillFactory-B5PcKREQ.js","assets/card_panel-DYamzA-q.js","assets/card_panel-UF59AJVy.css"])))=>i.map(i=>d[i]);
import{q as r,_ as s}from"./search-Btw97w8w.js";import"./admin-DFVIS8Rt.js";import{$ as i,objAndFiles2FormData as l,post as m}from"./common-CWUZwUnI.js";import{S as p}from"./SelectNew-DQsOGtuz.js";import{Q as n,a as c}from"./QuillFactory-B5PcKREQ.js";import"./MyQuill-CqTUtJle.js";class y{constructor(){const t=document[r](".item-wrap[data-model='product']");if(!t)return!1;this.product=t,this.model="product",this.id=i(this.product).find("[data-field='id']").innerText,this.setProps().then(),this.setDragNDrop().then(),this.setCardPanel().then(),n.create(".txt",c.ADMIN_PRODUCT_DESCRIPTION),n.create("#seo-article",c.ADMIN_PRODUCT_SEO_ARTICLE),this.setUnitsCustomSelects()}setUnitsCustomSelects(){const t=i(".units [custom-select]");[].forEach.call(t,a=>{a.dataset.id&&new p(a)})}async setDragNDrop(){const t=document[r]("[dnd]");if(t){const{default:a}=await s(async()=>{const{default:e}=await import("./dnd-BIsc27kd.js");return{default:e}},[]);await new a(t,this.addMainImage)}}async setFields(){const{default:t}=await s(async()=>{const{default:a}=await import("./Fields-CQyhy_Jf.js");return{default:a}},__vite__mapDeps([0,1,2,3,4]));new t(this.product)}async setProps(){const{default:t}=await s(async()=>{const{default:a}=await import("./Props-BmaBxEr8.js");return{default:a}},__vite__mapDeps([5,3,1,2,4,6,7,8,9,10]));new t(this.product)}async setCardPanel(){if(document[r](".cardPanel")){const{default:a}=await s(async()=>{const{default:e}=await import("./card_panel-DYamzA-q.js");return{default:e}},__vite__mapDeps([11,3,12]));new a}}async addMainImage(t,a){const e={productId:a.closest(".item-wrap").dataset.id},u=l(e,t[0]),o=(await m("/adminsc/product/saveMainImage",u))?.arr[0];if(o){const d=a.closest(".dnd-container").querySelector("img");d.removeAttribute("src"),d.setAttribute("src",o)}}}export{y as default};
//# sourceMappingURL=Product-D64pG-_4.js.map
