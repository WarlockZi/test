import{$ as a,a as c,p as e,D as r}from"./search-DLuFAGfO.js";class l{constructor(){const s=a("[data-compare]").first();if(!s)return!1;s[c]("click",this.handleClick.bind(this))}handleClick({target:s}){s.classList.contains("compare")&&this.remove(s)}async remove(s){const o=s.closest(".column");(await e("/compare/del",this.productDTO(s)))?.arr?.discompared&&o.remove()}productDTO(s){const o=new r(s);return o.fields={product_id:s.closest("[data-1sid]").dataset["1sid"]},o}}export{l as default};
//# sourceMappingURL=Compare-D7pqZCkw.js.map
