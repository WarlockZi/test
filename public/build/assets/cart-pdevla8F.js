import{c as C,$ as T,e as _,h as L,i as f,p as b,j as S}from"./common-RiEdO0HM.js";import g from"./modal-DdcVNKq5.js";import{a as x,q as c,b as m,i as k}from"./constants-Clh-pk9Y.js";import{s as v}from"./shippableUnitsTable-B_ReVYQK.js";class E{constructor(){let t={get_cookie:function(s){let i=document.cookie.match("(^|;) ?"+s+"=([^;]*)(;|$)");return i?unescape(i[2]):null},delete_cookie:function(s){let i=new Date;i.setTime(i.getTime()-1),document.cookie=s+="=; expires="+i.toGMTString()},set_cookie:function(s,i,a,n,l,o,u,p){let r=s+"="+escape(i);if(a){let h=new Date(a,n,l);r+="; expires="+h.toGMTString()}o&&(r+="; path="+escape(o)),u&&(r+="; domain="+escape(u)),p&&(r+="; secure"),document.cookie=r}},e={get:(s,i)=>i in s?s[i]:t.get_cookie(i),set:(s,i,a)=>a?t.set_cookie(i,a):t.delete_cookie(i)};this.cookie=new Proxy(t,e)}}let y=class{constructor(){this.title="Заголовок",this.submitText="OK",this.footer=[],this.content=[],this.fields=[]}};class q extends y{constructor(){super(),this.title="Заказ принят в обработку",this.submitText="Успешно"}setFooter(){this.footer.push(new C().tag("div").attr("id","submit").attr("class","button").text("ok").get())}setContent(){this.content.push(new C().tag("div").attr("class","text").text("Какое-то сообщение").get())}}class F{constructor(t){const{_type:e,_className:s,_hidden:i,_required:a,_name:n,_autocomplete:l,_pattern:o,_badgeWidth:u,_id:p,_placeholder:r,_errorEl:h}=t;return this.container=document.createElement("div"),this.container.classList.add("input-container"),this.input=document.createElement("input"),e&&(this.input.type=e),this.input.placeholder=" ",s&&this.input.classList.add(s),i&&(this.input.hidden=i),a&&(this.input.required=a),l&&(this.input.autocomplete=l),n&&(this.input.name=n),o&&(this.input.pattern=o),this.input.id=p,this.labelBadge=document.createElement("div"),this.labelBadge.classList.add("badge"),this.labelBadge.style.width=u,this.label=document.createElement("label"),this.label.innerText=r,this.label.htmlFor=p,this.container.append(this.input),this.container.append(this.labelBadge),this.container.append(this.label),h&&this.container.append(h),this.container}}class w{constructor(t){this._type="text",this._required=!1,this._badgeWidth="50px",this._id="name",this._placeholder="email",this._autocomplete=!1}id(t){return this._id=t,this}type(t){return this._type=t,this}hidden(){return this._hidden=!0,this}required(){return this._required=!0,this}name(t){return this._name=t,this}autocomplete(){return this._autocomplete=!0,this}placeholder(t){return this._placeholder=t,this}class(t){return this._class=t,this}pattern(t){let e=new RegExp(t);return this._pattern=e.source,this}badgeWidth(t){return this._badgeWidth=t,this}errorEl(t){return this._errorEl=t,this}get(){return new F(this)}}class W extends y{constructor(){super(),this.title="Вход",this.submitText="Войти",this.setFields()}setFields(){let t=new w().id("email").required().name("email").badgeWidth("55px").type("email").placeholder("email").get(),e=new w().id("password").required().name("password").pattern("[a-zA-Z0-9-_()]{6,}").badgeWidth("65px").placeholder("пароль").get();this.fields={email:t,password:e}}}class $ extends y{constructor(){super(),this.title="Данные для связи",this.submitText="отправить данные",this.setFields(),this.setFooter()}setFooter(){this.footer.push(new C().tag("div").attr("class","button").text("Отправляя данные, вы соглашаетесь на обработку персональных данных").get())}setFields(){let t=new w().id("name").badgeWidth("150px").required().placeholder("как к Вам обращаться").pattern("[а-яА-Я]{1,}").get(),e=new w().id("phone").badgeWidth("130px").required().placeholder("сотовый для связи").pattern("[0-9-+_()]{6,17}").get(),s=new w().id("company").badgeWidth("175px").required().placeholder("название Вашей компании").pattern("[a-zA-Zа-яА-я\\s()]{3,}").get();this.fields={name:t,phone:e,company:s}}}class I{constructor(){this.container=T(".user-content .cart .content").first(),this.container&&(this.container[x]("click",this.handleClick.bind(this)),this.container[x]("keyup",this.handleKeyUp.bind(this)),this.total=this.container[c](".total span"),this.$cartEmptyText=this.container[c](".empty-cart"),this.$cartCount=this.container[c](".cart .count"),this.rows=this.container[m](".row"),this.setUrl(),this.mapTables(),this.renderSums(),this.cookie=new E,this.setModals())}renderSums(){const t=[...this.container[m]("[shippable-table]")].reduce((e,s)=>{const i=+s.dataset.price,a=[...s[m]("[unit-row]")].reduce(function(l,o){const u=+o.dataset.multiplier,p=+o[c]("input").value,r=u*i*p,h=o[c](".subSum");return h&&(h[k]=_.format(r)),l+r}.bind(i),0),n=s.closest(".row")[c](".sub-sum");return n[k]=_.format(a),e+a},0);this.total[k]=_.format(t)}mapTables(){[...this.container[m](".shippable-table")].forEach(t=>{new v(t)})}counterCallback(){L("cartDeadline"),this.dropCart().then()}async dropCart(){const t=f();(await b("/cart/drop",{cartToken:t}))?.arr?.ok&&this.showEmptyCart()}rowUnitIds(t){return[...t[m]("[unit-row]")].map(e=>e.dataset.unitid)}cartRowDTO(t){const e=t.closest(".row");return{sess:f(),product_id:e.dataset.productId,unit_ids:this.rowUnitIds(e)}}async handleClick({target:t}){t.classList.contains("del")?this.renderSums():(t.classList.contains("plus")||t.classList.contains("minus"))&&(this.rowTotalCount(t.closest(".row"))?(this.renderSums(),this.changeCount(t)):this.renderSums())}changeCount(t){}async handleKeyUp({target:t}){if(t.classList.contains("input")&&t.tagName==="INPUT"){this.renderSums();const e=+t.value;this.updateOrCreate(t,e)}}rowTotalCount(t){return[...t[m]("input")].reduce((e,s)=>e+ +s.value,0)}updateOrCreate(t,e){const s=t.closest("[shippable-table]").dataset["1sid"],i=t.closest("[unit-row]").dataset.unitid;b(this.url+"/updateOrCreate",{product_id:s,unit_id:i,count:e})}async deleteCartRow(t){(await b(`${this.url}/deleteRow`,this.cartRowDTO(t)))?.arr?.ok&&(t.closest(".row").remove(),this.rows.length<1&&this.showEmptyCart(),this.renderSums())}setUrl(){this.url="/adminsc/orderitem",S()&&(this.url="/adminsc/order")}showEmptyCart(){this.container.innerHTML="",this.$cartEmptyText.classList.remove("none"),this.$cartCount.classList.add("none")}setModals(){const t=document[c]("#cartLead"),e=document[c]("#cartLogin"),s=document[c]("#cartSuccess");t&&new g({button:t,data:new $,callback:this.modalLeadCallback.bind(this)}),e&&new g({button:e,data:new W,callback:this.modalLoginCallback.bind(this)}),s&&new g({button:s,data:new q,callback:this.modalcartSuccessCallback.bind(this)})}async modalLeadCallback(t,e){const s=t.name.value,i=t.phone.value,a=t.company.value,n=f(),l=await b("/cart/lead",{name:s,phone:i,company:a,sess:n});e.close(),l&&location.reload()}async modalcartSuccessCallback(t,e){e.close()}async modalLoginCallback(t,e){let s=t.email.value,i=t.password.value,a=f(),n=await b("/cart/login",{email:s,password:i,sess:a});e.close(),n&&location.reload()}}export{I as default};
