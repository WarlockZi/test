const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/Fields-Bwr_2rZB.js","assets/search-uOMQXYvZ.js","assets/search-CgsZ06fR.css","assets/Props-C8PvSHsM.js","assets/admin-RX4gO75X.js","assets/MyQuill-DcsoDn4c.js","assets/MyQuill-GClCj9AP.css","assets/admin-CUjxrtZ4.css","assets/QuillFactory-y2-kM0j2.js","assets/card_panel-DXQJKK1o.js","assets/card_panel-UF59AJVy.css"])))=>i.map(i=>d[i]);
import{q as r,$ as n,S as l,_ as s,t as m,p}from"./search-uOMQXYvZ.js";import"./admin-RX4gO75X.js";import{Q as i,a as c}from"./QuillFactory-y2-kM0j2.js";import"./MyQuill-DcsoDn4c.js";class I{constructor(){const t=document[r](".item-wrap[data-model='product']");if(!t)return!1;this.product=t,this.model="product",this.id=n(this.product).find("[data-field='id']").innerText,this.setProps().then(),this.setDragNDrop().then(),this.setCardPanel().then(),i.create(".txt",c.ADMIN_PRODUCT_DESCRIPTION),i.create("#seo-article",c.ADMIN_PRODUCT_SEO_ARTICLE),this.setUnitsCustomSelects()}setUnitsCustomSelects(){const t=n(".units [custom-select]");[].forEach.call(t,a=>{a.dataset.id&&new l(a)})}async setDragNDrop(){const t=document[r]("[dnd]");if(t){const{default:a}=await s(async()=>{const{default:e}=await import("./dnd-BIsc27kd.js");return{default:e}},[]);await new a(t,this.addMainImage)}}async setFields(){const{default:t}=await s(async()=>{const{default:a}=await import("./Fields-Bwr_2rZB.js");return{default:a}},__vite__mapDeps([0,1,2]));new t(this.product)}async setProps(){const{default:t}=await s(async()=>{const{default:a}=await import("./Props-C8PvSHsM.js");return{default:a}},__vite__mapDeps([3,1,2,4,5,6,7,8]));new t(this.product)}async setCardPanel(){if(document[r](".cardPanel")){const{default:a}=await s(async()=>{const{default:e}=await import("./card_panel-DXQJKK1o.js");return{default:e}},__vite__mapDeps([9,1,2,10]));new a}}async addMainImage(t,a){const e={productId:a.closest(".item-wrap").dataset.id},u=m(e,t[0]),o=(await p("/adminsc/product/saveMainImage",u))?.arr[0];if(o){const d=a.closest(".dnd-container").querySelector("img");d.removeAttribute("src"),d.setAttribute("src",o)}}}export{I as default};
//# sourceMappingURL=Product-CveTwxjm.js.map
