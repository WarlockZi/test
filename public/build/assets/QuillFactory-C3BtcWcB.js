import{Q as o}from"./MyQuill-BnALqy0A.js";import{$ as a,f as n,p as d,I as h}from"./common-DnUtA5kF.js";import{D as c}from"./search-BDRlSmDO.js";import{a as u}from"./constants-D_Ps4z6O.js";const m={ADMIN_PRODUCT_DESCRIPTION:"description",ADMIN_PRODUCT_SEO_ARTICLE:"seo-article",ADMIN_CATEGORY_SEO_ARTICLE:"seo-article"};class r{constructor(t,e){const s=a(t).first();s&&(this.el=s,this.autosave=e?.autosave||!0,this.editable=e?.editable||!0,this.theme=e?.theme||"snow",this.placeholder=e?.theme||"Начните писать...",this.options=this.setOptions(),this.quill=new o(t,this.options),this.dto=this.setDTO(),this.setContent(),this.autosave&&this.el[u]("keyup",n(this.save.bind(this))))}async save(){this.dto.relation.fields[this.el?.dataset?.field]=JSON.stringify(this.quill.getContents()),await d(`/adminsc/${this.dto.model}/updateOrCreate`,this.dto)}setContent(){h(this.el.innerText)?this.quill.setContents(JSON.parse(this.el.innerText+`
`)):this.quill.setText(this.el.innerText)}setDTO(){const t=this.el.closest("[data-model]"),e=t?.dataset.model,s=t.dataset.id,l=new c(s);return l.model=e,l.relation.name=this.el.dataset.relation,l}setToolbar(){return[[{header:[2,3,4,!1]}],["bold","italic","underline","strike"],[{list:"ordered"},{list:"bullet"}],[{script:"sub"},{script:"super"}],[{indent:"-1"},{indent:"+1"}],[{size:["small",!1,"large","huge"]}],[{color:[]},{background:[]}],[{font:[]}],[{align:[]}],["clean"]]}setOptions(){return{theme:this.theme,placeholder:this.placeholder,modules:{toolbar:this.setToolbar()}}}}class p extends r{constructor(t,e){super(t,e)}}class T extends r{constructor(t,e){super(t,e)}}class b{constructor(){this.quill=new o;debugger}static create(t,e,s){return e===m.ADMIN_PRODUCT_DESCRIPTION?new p(t,s):new T(t,s)}}export{b as Q,m as a};
//# sourceMappingURL=QuillFactory-C3BtcWcB.js.map
