const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/Fields-YS04vj1Q.js","assets/search-CVjB7PCw.js","assets/search-DbjMfPSM.css","assets/Props-Br-Xw0VR.js","assets/admin-D63VHOeb.js","assets/MyQuill-CBa984Yn.js","assets/MyQuill-GClCj9AP.css","assets/Promotion-B1Sllz7y.js","assets/Promotion-B5qbfc0J.css","assets/admin-BZKAMzlF.css","assets/card_panel-DyIOGTsg.js","assets/card_panel-CUIwBKKV.css"])))=>i.map(i=>d[i]);
import{$ as r,a as p,d as _,p as h,I as f,D,b as n,S as P,_ as i,o as w}from"./search-CVjB7PCw.js";import"./admin-D63VHOeb.js";import{Q as m}from"./MyQuill-CBa984Yn.js";import"./Promotion-B1Sllz7y.js";const d={ADMIN_PRODUCT_DESCRIPTION:"description",ADMIN_PRODUCT_SEO_ARTICLE:"seo_article"};class I{constructor(t,e){const s=r(t).first();s&&(this.el=s,this.autosave=e?.autosave||!0,this.editable=e?.editable||!0,this.theme=e?.theme||"snow",this.placeholder=e?.theme||"Начните писать...",this.options=this.setOptions(),this.quill=new m(t,this.options),this.dto=this.setDTO(),this.setContent(),this.autosave&&this.el[p]("keyup",_(this.save.bind(this))))}async save(){this.dto.relation.fields[this.el?.dataset?.field]=JSON.stringify(this.quill.getContents()),await h(`/adminsc/${this.dto.model}/updateOrCreate`,this.dto)}setContent(){f(this.el.innerText)?this.quill.setContents(JSON.parse(this.el.innerText+`
`)):this.quill.setText(this.el.innerText)}setDTO(){const t=this.el.closest("[data-model]"),e=t?.dataset.model,s=t.dataset.id,a=new D(s);return a.model=e,a.relation.name=this.el.dataset.relation,a}setToolbar(){return[["bold","italic","underline","strike"],["blockquote"],[{list:"ordered"},{list:"bullet"}],[{script:"sub"},{script:"super"}],[{indent:"-1"},{indent:"+1"}],[{size:["small",!1,"large","huge"]}],[{color:[]},{background:[]}],[{font:[]}],[{align:[]}],["clean"]]}setOptions(){return{theme:this.theme,placeholder:this.placeholder,modules:{toolbar:this.setToolbar()}}}}class T extends I{constructor(t,e){super(t,e)}}class u{constructor(){this.quill=new m;debugger}static create(t,e,s){if(e===d.ADMIN_PRODUCT_DESCRIPTION)return new T(t,s)}}class g{constructor(){const t=document[n](".item-wrap[data-model='product']");if(!t)return!1;this.product=t,this.model="product",this.id=r(this.product).find("[data-field='id']").innerText,this.setProps().then(),this.setDragNDrop().then(),this.setCardPanel().then(),u.create(".txt",d.ADMIN_PRODUCT_DESCRIPTION),u.create("#seo_article",d.ADMIN_PRODUCT_SEO_ARTICLE),this.setUnitsCustomSelects()}setUnitsCustomSelects(){const t=r(".units [custom-select]");[].forEach.call(t,e=>{new P(e)})}async setDragNDrop(){const t=document[n]("[dnd]");if(t){const{default:e}=await i(async()=>{const{default:s}=await import("./dnd-BIsc27kd.js");return{default:s}},[]);await new e(t,this.addMainImage)}}async setFields(){const{default:t}=await i(async()=>{const{default:e}=await import("./Fields-YS04vj1Q.js");return{default:e}},__vite__mapDeps([0,1,2]));new t(this.product)}async setProps(){const{default:t}=await i(async()=>{const{default:e}=await import("./Props-Br-Xw0VR.js");return{default:e}},__vite__mapDeps([3,1,2,4,5,6,7,8,9]));new t(this.product)}async setCardPanel(){if(document[n](".cardPanel")){const{default:e}=await i(async()=>{const{default:s}=await import("./card_panel-DyIOGTsg.js");return{default:s}},__vite__mapDeps([10,1,2,11]));new e}}async addMainImage(t,e){const s={productId:e.closest(".item-wrap").dataset.id},a=w(s,t[0]),l=(await h("/adminsc/product/saveMainImage",a))?.arr[0];if(l){const c=e.closest(".dnd-container").querySelector("img");c.removeAttribute("src"),c.setAttribute("src",l)}}}export{g as default};
//# sourceMappingURL=Product-HS_dZ1ty.js.map
