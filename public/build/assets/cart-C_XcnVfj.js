import{c as l,h as v,$ as L,i as y,j as k,p as g,k as S,l as I}from"./common-Boy4RmlM.js";import C from"./modal-Cmk2ACTR.js";import{a as T,q as o,b as w,i as x}from"./constants-Clh-pk9Y.js";import{s as W}from"./shippableUnitsTable-CxJT_S2e.js";class ${constructor(){let t={get_cookie:function(s){let i=document.cookie.match("(^|;) ?"+s+"=([^;]*)(;|$)");return i?unescape(i[2]):null},delete_cookie:function(s){let i=new Date;i.setTime(i.getTime()-1),document.cookie=s+="=; expires="+i.toGMTString()},set_cookie:function(s,i,r,c,p,n,d,m){let a=s+"="+escape(i);if(r){let u=new Date(r,c,p);a+="; expires="+u.toGMTString()}n&&(a+="; path="+escape(n)),d&&(a+="; domain="+escape(d)),m&&(a+="; secure"),document.cookie=a}},e={get:(s,i)=>i in s?s[i]:t.get_cookie(i),set:(s,i,r)=>r?t.set_cookie(i,r):t.delete_cookie(i)};this.cookie=new Proxy(t,e)}}let E=class{constructor(){this.title="Заголовок",this.content=[],this.fields=[],this.footer=[],this.submitText=""}};class U extends E{constructor(){super(),this.title="Заказ принят в обработку",this.content.push(new l().tag("div").attr("class","text").text("Какое-то сообщение").get()),this.footer.push(new l().tag("div").attr("id","submit").attr("class","button").text("ok").get())}}class M{constructor(t){const{_type:e,_onKeyUp:s,_onInput:i,_className:r,_hidden:c,_required:p,_name:n,_autocomplete:d,_pattern:m,_badgeWidth:a,_id:u,_placeholder:q,_errorEl:f}=t;if(this.container=new l().tag("div").attr("class","input-container").get(),this.input=document.createElement("input"),s&&this.input.addEventListener("keyup",s.bind(this)),i&&this.input.addEventListener("input",i.bind(this)),e&&(this.input.type=e,e==="password"&&this.showPass()),this.input.placeholder=" ",r&&this.input.classList.add(r),c&&(this.input.hidden=c),p&&(this.input.required=p),d&&(this.input.autocomplete=d),n&&(this.input.name=n),m&&(this.input.pattern=m),this.input.id=u,this.labelBadge=new l().tag("div").attr("class","badge").get(),this.labelBadge.style.width=a,this.label=new l().tag("label").text(q).get(),this.label.htmlFor=u,this.container.append(this.input),this.container.append(this.labelBadge),this.container.append(this.label),f){if(this.errorEl=new l().tag("div"),f.startsWith("#")){const _=f.replace("#","");this.errorEl=this.errorEl.attr("id",_)}else if(f.startsWith(".")){const _=f.replace(".","");this.errorEl=this.errorEl.attr("class",_)}this.errorEl=this.errorEl.get(),this.container.append(this.errorEl)}return this.container}showPass(){const t=new l().tag("span").attr("class","password-control").get();t.addEventListener("click",function({target:e}){e.parentNode.querySelector("input").type=e.parentNode.querySelector("input").type==="password"?"text":"password",e.classList.toggle("view")}),this.container.append(t)}}class b{constructor(){this._type="text",this._required=!1,this._autocomplete=!1}id(t){return this._id=t,this}type(t){return this._type=t,this}hidden(){return this._hidden=!0,this}required(){return this._required=!0,this}name(t){return this._name=t,this}autocomplete(){return this._autocomplete=!0,this}placeholder(t){return this._placeholder=t,this}class(t){return this._class=t,this}pattern(t){let e=new RegExp(t);return this._pattern=e.source,this}badgeWidth(t){return this._badgeWidth=t,this}errorEl(t){return this._errorEl=t,this}onKeyUp(t){return this._onKeyUp=t,this}onInput(t){return this._onInput=t,this}get(){return new M(this)}}class N extends E{constructor(){super(),this.title="Вход",this.fields.push(new b().id("email").required().name("email").type("text").onInput(this.onInputEmail.bind(this)).errorEl("#emailError").badgeWidth("55px").placeholder("email").get()),this.fields.push(new b().id("password").required().name("password").type("password").badgeWidth("65px").placeholder("пароль").get()),this.submitText="Войти"}onInputEmail({target:t}){const e=t.value,s=v(e);this.fields.email.querySelector("#emailError").innerText=s.length?s[0]:"",this.fields.email.querySelector("input").style.outline=s.length?"solid 1px #dc2f55":"solid 1px #2fdcdb",this.fields.email.querySelector("label").style.color=s.length?"#dc2f55":"#2fdcdb"}}class P extends E{constructor(){super(),this.title="Данные для связи",this.fields.push(new b().id("name").badgeWidth("150px").required().placeholder("как к Вам обращаться").pattern("[а-яА-Я]{1,}").get()),this.fields.push(new b().id("company").badgeWidth("175px").required().placeholder("название Вашей компании").pattern("[a-zA-Zа-яА-я\\s()]{3,}").get()),this.fields.push(new b().id("phone").badgeWidth("130px").required().placeholder("сотовый для связи").pattern("[0-9-+_()]{6,17}").get()),this.submitText="отправить данные",this.footer.push(new l().tag("div").attr("class","button").text("Отправляя данные, вы соглашаетесь на обработку персональных данных").get())}}class z{constructor(){this.container=L(".user-content .cart .content").first(),this.container&&(this.container[T]("click",this.handleClick.bind(this)),this.container[T]("keyup",this.handleKeyUp.bind(this)),this.total=this.container[o](".total span"),this.$cartEmptyText=this.container[o](".empty-cart"),this.$cartCount=this.container[o](".cart .count"),this.rows=this.container[w](".row"),this.url="/cart",this.mapTables(),this.renderSums(),this.cookie=new $,this.setModals())}renderSums(){const t=[...this.container[w]("[shippable-table]")].reduce((e,s)=>{const i=+s.dataset.price,r=[...s[w]("[unit-row]")].reduce(function(p,n){const d=+n.dataset.multiplier,m=+n[o]("input").value,a=d*i*m,u=n[o](".subSum");return u&&(u[x]=y.format(a)),p+a}.bind(i),0),c=s.closest(".row")[o](".sub-sum");return c[x]=y.format(r),e+r},0);this.total[x]=y.format(t)}mapTables(){[...this.container[w](".shippable-table")].forEach(t=>{new W(t)})}async dropCart(){const t=k();(await g("/cart/drop",{cartToken:t}))?.arr?.ok&&this.showEmptyCart()}rowUnitIds(t){return[...t[w]("[unit-row]")].map(e=>e.dataset.unitid)}cartRowDTO(t){const e=t.closest(".row");return{sess:k(),product_id:e.dataset.productId,unit_ids:this.rowUnitIds(e)}}async handleClick({target:t}){t.classList.contains("del")?(await this.deleteCartRow(t),this.renderSums()):(t.classList.contains("plus")||t.classList.contains("minus"))&&(this.rowTotalCount(t.closest(".row"))?(this.renderSums(),this.changeCount(t)):this.renderSums())}changeCount(t){}async handleKeyUp({target:t}){if(t.classList.contains("input")&&t.tagName==="INPUT"){this.renderSums();const e=+t.value;this.updateOrCreate(t,e)}}rowTotalCount(t){return[...t[w]("input")].reduce((e,s)=>e+ +s.value,0)}updateOrCreate(t,e){const s=t.closest("[shippable-table]").dataset["1sid"],i=t.closest("[unit-row]").dataset.unitid;g(`${this.url}/updateOrCreate`,{product_id:s,unit_id:i,count:e})}async deleteCartRow(t){(await g(`${this.url}/deleteRow`,this.cartRowDTO(t)))?.arr?.ok&&(t.closest(".row").remove(),this.rows.length<1&&this.showEmptyCart(),this.renderSums())}showEmptyCart(){this.container.innerHTML="",this.$cartEmptyText.classList.remove("none"),this.$cartCount.classList.add("none")}setModals(){const t=document[o]("#cartLead"),e=document[o](".guest-menu"),s=document[o]("#cartSuccess");t&&new C({button:t,data:new P,callback:this.modalLeadCallback.bind(this)}),e&&new C({button:e,data:new N,callback:this.modalLoginCallback.bind(this)}),s&&new C({button:s,data:new U,callback:this.modalcartSuccessCallback.bind(this)})}async modalcartSuccessCallback(t,e){e.close()}async modalLoginCallback(t,e){const s=S(t.email.value),i=S(t.password.value),r=k(),c=await g("/cart/login",{email:s,password:i,sess:r});e.close(),c&&location.reload()}counterCallback(){I("cartDeadline"),this.dropCart().then()}}export{z as default};
