import{$ as r,l as s}from"./common-DVK5bmCY.js";class o{constructor(){if(this.el=r("[data-shortLink]").first(),this.el)return!1}shortLink(a){navigator.permissions.query({name:"clipboard-write"}).then(async t=>{(t.state==="granted"||t.state==="prompt")&&await navigator.clipboard.writeText(a.dataset.shortlink).then(()=>{s.show("Ссылка скопирована")})})}}export{o as default};
