import{Q as a}from"./MyQuill-gEQ7mOZi.js";import{$ as o,a as r,l as d,p as h,I as c,D as u}from"./search-DV8UsOr4.js";const m={ADMIN_PRODUCT_DESCRIPTION:"description",ADMIN_PRODUCT_SEO_ARTICLE:"seo-article",ADMIN_CATEGORY_SEO_ARTICLE:"seo-article"};class n{constructor(t,e){const s=o(t).first();s&&(this.el=s,this.autosave=e?.autosave||!0,this.editable=e?.editable||!0,this.theme=e?.theme||"snow",this.placeholder=e?.theme||"Начните писать...",this.options=this.setOptions(),this.quill=new a(t,this.options),this.dto=this.setDTO(),this.setContent(),this.autosave&&this.el[r]("keyup",d(this.save.bind(this))))}async save(){this.dto.relation.fields[this.el?.dataset?.field]=JSON.stringify(this.quill.getContents()),await h(`/adminsc/${this.dto.model}/updateOrCreate`,this.dto)}setContent(){c(this.el.innerText)?this.quill.setContents(JSON.parse(this.el.innerText+`
`)):this.quill.setText(this.el.innerText)}setDTO(){const t=this.el.closest("[data-model]"),e=t?.dataset.model,s=t.dataset.id,l=new u(s);return l.model=e,l.relation.name=this.el.dataset.relation,l}setToolbar(){return[[{header:[2,3,4,!1]}],["bold","italic","underline","strike"],[{list:"ordered"},{list:"bullet"}],[{script:"sub"},{script:"super"}],[{indent:"-1"},{indent:"+1"}],[{size:["small",!1,"large","huge"]}],[{color:[]},{background:[]}],[{font:[]}],[{align:[]}],["clean"]]}setOptions(){return{theme:this.theme,placeholder:this.placeholder,modules:{toolbar:this.setToolbar()}}}}class p extends n{constructor(t,e){super(t,e)}}class T extends n{constructor(t,e){super(t,e)}}class D{constructor(){this.quill=new a;debugger}static create(t,e,s){return e===m.ADMIN_PRODUCT_DESCRIPTION?new p(t,s):new T(t,s)}}export{D as Q,m as a};
//# sourceMappingURL=QuillFactory-D71DNIk_.js.map
