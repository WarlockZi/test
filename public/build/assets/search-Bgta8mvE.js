import{$ as i,d as c,p as h,b as n}from"./common-DVK5bmCY.js";import{a as l}from"./constants-Clh-pk9Y.js";class f{constructor(e=!1){this.admin=e;const s=i(".utils .search").first(),t=i(".search-panel").first();!s||!t||(this.openBtn=s,this.panel=t,this.text=i(t).find(".text"),this.result=i(t).find(".result"),this.closeBtn=i(t).find(".close"),this.debouncedKeyUp=c(this.find,800),this.text[l]("keyup",this.debouncedKeyUp.bind(this)),this.openBtn[l]("click",this.togglePanel.bind(this)),this.closeBtn[l]("click",this.togglePanel.bind(this)))}togglePanel(){this.panel.classList.toggle("show"),this.result.innerHTML="",this.text.value=""}async find({target:e}){this.result.innerHTML="";const s=e.value;if(!s)return!1;const t=await h("/search",{text:s});t?.arr?.found&&(this.result.style.display="initial",t?.arr?.found.map(a=>{this.result.append(this.createLi(a))}))}createLi(e){const s=n("li"),t=n("a");t.href=this.admin?`/adminsc/product/edit/${e.id}`:`/product/${e.slug}`,e.deleted_at&&t.classList.add("deleted"),s.appendChild(t);const a=n("div","name",e.name),r=n("div","art",e.art),d=n("img");return d.src=e.mainImage,t.append(r),t.append(a),t.append(d),s.append(t),s}}export{f as default};
