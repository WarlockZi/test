"use strict";(self.webpackChunkmy_webpack_project=self.webpackChunkmy_webpack_project||[]).push([[239,402],{239:(t,e,s)=>{s.d(e,{default:()=>m});var i=s(448);class a{constructor(){let t={get_cookie:function(t){let e=document.cookie.match("(^|;) ?"+t+"=([^;]*)(;|$)");return e?unescape(e[2]):null},delete_cookie:function(t){let e=new Date;e.setTime(e.getTime()-1),document.cookie=t+="=; expires="+e.toGMTString()},set_cookie:function(t,e,s,i,a,n,r,o){let l=t+"="+escape(e);s&&(l+="; expires="+new Date(s,i,a).toGMTString()),n&&(l+="; path="+escape(n)),r&&(l+="; domain="+escape(r)),o&&(l+="; secure"),document.cookie=l}},e={get:(e,s)=>s in e?e[s]:t.get_cookie(s),set:(e,s,i)=>i?t.set_cookie(s,i):t.delete_cookie(s)};this.cookie=new Proxy(t,e)}}var n=s(21);class r{constructor(){this.title="Заголовок",this.submitText="OK",this.footer=[],this.content=[],this.fields=[]}}class o extends r{constructor(){super(),this.title="Заказ принят в обработку",this.submitText="Успешно"}setFooter(){this.footer.push((new i.n).tag("div").attr("id","submit").attr("class","button").text("ok").get())}setContent(){this.content.push((new i.n).tag("div").attr("class","text").text("Какое-то сообщение").get())}}class l{constructor(t){const{_type:e,_className:s,_hidden:i,_required:a,_name:n,_autocomplete:r,_pattern:o,_badgeWidth:l,_id:h,_placeholder:d,_errorEl:c}=t;return this.container=document.createElement("div"),this.container.classList.add("input-container"),this.input=document.createElement("input"),e&&(this.input.type=e),this.input.placeholder=" ",s&&this.input.classList.add(s),i&&(this.input.hidden=i),a&&(this.input.required=a),r&&(this.input.autocomplete=r),n&&(this.input.name=n),o&&(this.input.pattern=o),this.input.id=h,this.labelBadge=document.createElement("div"),this.labelBadge.classList.add("badge"),this.labelBadge.style.width=l,this.label=document.createElement("label"),this.label.innerText=d,this.label.htmlFor=h,this.container.append(this.input),this.container.append(this.labelBadge),this.container.append(this.label),c&&this.container.append(c),this.container}}class h{constructor(t){this._type="text",this._required=!1,this._badgeWidth="50px",this._id="name",this._placeholder="email",this._autocomplete=!1}id(t){return this._id=t,this}type(t){return this._type=t,this}hidden(){return this._hidden=!0,this}required(){return this._required=!0,this}name(t){return this._name=t,this}autocomplete(){return this._autocomplete=!0,this}placeholder(t){return this._placeholder=t,this}class(t){return this._class=t,this}pattern(t){let e=new RegExp(t);return this._pattern=e.source,this}badgeWidth(t){return this._badgeWidth=t,this}errorEl(t){return this._errorEl=t,this}get(){return new l(this)}}class d extends r{constructor(){super(),this.title="Вход",this.submitText="Войти",this.setFields()}setFields(){let t=(new h).id("email").required().name("email").autocomplete().badgeWidth("55px").type("email").placeholder("email").get(),e=(new h).id("password").required().name("password").autocomplete().pattern("[a-zA-Z0-9-_()]{6,}").badgeWidth("65px").placeholder("пароль").get();this.fields={email:t,password:e}}}class c extends r{constructor(){super(),this.title="Данные для связи",this.submitText="отправить данные",this.setFields(),this.setFooter()}setFooter(){this.footer.push((new i.n).tag("div").attr("class","button").text("Отправляя данные, вы соглашаетесь на обработку персональных данных").get())}setFields(){let t=(new h).id("name").badgeWidth("150px").required().placeholder("как к Вам обращаться").pattern("[а-яА-Я]{1,}").get(),e=(new h).id("phone").badgeWidth("130px").required().placeholder("сотовый для связи").pattern("[0-9-+_()]{6,17}").get(),s=(new h).id("company").badgeWidth("175px").required().placeholder("название Вашей компании").pattern("[a-zA-Zа-яА-я\\s()]{3,}").get();this.fields={name:t,phone:e,company:s}}}var u=s(832),p=s(87);class m{constructor(){let t=(0,i.$)(".user-content .cart .content").first();t&&(this.container=t,t.onclick=this.handleClick.bind(this),this.total=t[u.qs](".total span"),this.$cartEmptyText=t[u.qs](".empty-cart"),this.$cartCount=t[u.qs](".cart .count"),this.rows=t[u.qa](".row"),this.setUrl(),this.mapTables(),this.renderSums(),this.cookie=new a,this.setModals())}renderSums(){const t=[...this.container[u.qa]("[shippable-table]")].reduce(((t,e)=>{const s=+e.dataset.price,a=[...e[u.qa]("[unit-row]")].reduce(function(t,e){const a=+e.dataset.multiplier,n=+e[u.qs]("input").value,r=a*s*n,o=e[u.qs](".subSum");return o&&(o[u.it]=i.X9.format(r)),t+r}.bind(s),0);return e.closest(".row")[u.qs](".sub-sum")[u.it]=i.X9.format(a),t+a}),0);this.total[u.it]=i.X9.format(t)}mapTables(){[...this.container[u.qa](".shippable-table")].forEach((t=>{new p.A(t)}))}counterCallback(){(0,i.vE)("cartDeadline"),this.dropCart()}async dropCart(){const t=(0,i.gf)(),e=await(0,i.bE)("/cart/drop",{cartToken:t});e?.arr?.ok&&this.showEmptyCart()}rowUnitIds(t){return[...t[u.qa]("[unit-row]")].map((t=>t.dataset.unitid))}cartRowDTO(t){let e=t.closest(".row");return{sess:(0,i.gf)(),product_id:e.dataset.productId,unit_ids:this.rowUnitIds(e)}}async handleClick({target:t}){t.classList.contains("del")?(await this.deleteCartRow(t),this.renderSums()):(t.classList.contains("plus")||t.classList.contains("minus"))&&(this.rowTotalCount(t.closest(".row"))?this.renderSums():await this.deleteCartRow(t),this.renderSums())}rowTotalCount(t){return[...t[u.qa]("input")].reduce(((t,e)=>t+ +e.value),0)}async deleteCartRow(t){const e=await(0,i.bE)(`${this.url}/deleteRow`,this.cartRowDTO(t));e?.arr?.ok&&(t.closest(".row").remove(),this.rows.length<1&&this.showEmptyCart(),this.renderSums())}setUrl(){this.url="/adminsc/orderitem",(0,i.a$)()&&(this.url="/adminsc/order")}showEmptyCart(){this.container.innerHTML="",this.$cartEmptyText.classList.remove("none"),this.$cartCount.classList.add("none")}setModals(){const t=document[u.qs]("#cartLead"),e=document[u.qs]("#cartLogin"),s=document[u.qs]("#cartSuccess");t&&new n.default({button:t,data:new c,callback:this.modalLeadCallback.bind(this)}),e&&new n.default({button:e,data:new d,callback:this.modalLoginCallback.bind(this)}),s&&new n.default({button:s,data:new o,callback:this.modalcartSuccessCallback.bind(this)})}async modalLeadCallback(t,e){let s=t.name.value,a=t.phone.value,n=t.company.value,r=(0,i.gf)(),o=await(0,i.bE)("/cart/lead",{name:s,phone:a,company:n,sess:r});e.close(),o&&location.reload()}async modalcartSuccessCallback(t,e){e.close()}async modalLoginCallback(t,e){let s=t.email.value,a=t.password.value,n=(0,i.gf)(),r=await(0,i.bE)("/cart/login",{email:s,password:a,sess:n});e.close(),r&&location.reload()}}},21:(t,e,s)=>{s.d(e,{default:()=>a});var i=s(448);class a{constructor(t){this.modal=(0,i.$)("[data-modal='default']").first(),this.modal&&t?.button&&(this.button=t.button,this.data=t.data,this.callback=t.callback,this.fieldsObj={},this.closeEl=(0,i.$)(this.modal).find(".modal-close"),this.title=(0,i.$)(this.modal).find(".title"),this.box=(0,i.$)(this.modal).find(".modal-box"),this.content=(0,i.$)(this.modal).find(".content"),this.footer=(0,i.$)(this.modal).find(".footer"),this.overlay=(0,i.$)(this.modal).find(".overlay"),this.check=(0,i.$)(".checkmark").first(),this.button.addEventListener("click",this.show.bind(this)),this.closeEl.addEventListener("click",this.close.bind(this)),this.overlay.addEventListener("click",this.close.bind(this)))}async show(){this.$submit=(new i.n).tag("div").attr("type","submit").attr("class","button").attr("id","submit").text(this.data.submitText).get(),this.$submit.addEventListener("click",this.submit.bind(this)),this.content.innerHTML="",this.renderTitle(),await this.renderFields(),await this.renderContent(),await this.renderFooter(),this.renderSubmitText(),this.modal.style.display="flex",setTimeout(function(){this.overlay.style.opacity=1,this.box.style.opacity=1,this.box.classList.remove("transform-out"),this.box.classList.add("transform-in")}.bind(this),1)}async renderFields(){let t=this.data.fields;for(let e in t)this.fieldsObj[e]=t[e].querySelector("input"),this.content.appendChild(t[e])}async renderContent(){for(let t in this.data.content)this.content.appendChild(this.data.content[t])}async renderFooter(){for(let t in this.data.footer)this.footer.appendChild(this.data.footer[t]);this.footer.appendChild(this.$submit)}renderTitle(){this.title.innerText=this.data.title??"Заголовок"}renderSubmitText(){this.$submit.innerText=this.data.submitText??"ok"}async submit(){this.callback(this.fieldsObj,this)}close(){this.box.classList.remove("transform-in"),this.box.classList.add("transform-out"),this.overlay.style.opacity=0,this.box.style.opacity=0,setTimeout(function(){this.modal.style.display="none",this.footer.innerHTML=""}.bind(this),500)}}},87:(t,e,s)=>{s.d(e,{A:()=>n});var i=s(448),a=s(832);class n{constructor(t){if(!t)return!1;this.target=t,this.table=t.closest("[shippable-table]"),this.table[a.z]("click",this.handleClick.bind(this)),this.blueButton=this.table[a.qs](".blue-button"),this.greenButtonWrap=this.table[a.qs](".green-button-wrap")??!1,this.price=+this.table.dataset.price,this.sid=this.table.dataset["1sid"],this.total=this.table[a.qs]("[data-total]"),this.setFormatter(),this.showButtons(),this.renderSums()}showButtons(){if(!this.blueButton||!this.greenButtonWrap)return!1;this.getTotalCount()?(this.blueButton.style.display="none",this.greenButtonWrap.style.display="flex"):(this.blueButton.style.display="flex",this.greenButtonWrap.style.display="none")}handleClick({target:t}){const e=t??this.target;if(e.classList.contains("blue-button"))this.showGreenButton(e);else if(e.classList.contains("green-button"))window.location.href="/cart";else if(e.classList.contains("plus")){const t=e.closest(".unit-row");this.increment(t)}else if(e.classList.contains("minus")){const t=e.closest(".unit-row");this.decrement(t)}else if(e.classList.contains("input")){const t=e.closest(".unit-row");this.handleChange(t)}return this}increment(t){t[a.qs]("input").value++,t.dataset.rowSum=""+t[a.qs]("input").value,this.handleChange(t)}decrement(t){const e=t[a.qs]("input");+e.value<2?e.value="":(e.value--,t.dataset.rowSum=e.value),this.handleChange(t)}getTotalCount(){return[...this.table[a.qa]("input")].reduce(((t,e)=>t+ +e.value),0)}handleChange(t){const e=this.getTotalCount(t);this.renderSums(),0===e?this.showBlueButton():this.toServer(this.dto(t))}renderSums(){let t=[...this.table[a.qa](".unit-row")].reduce(((t,e,s)=>{const i=this.rowDto(e);let a=+this.price*+i.multiplier*+i.count;return i.sub_sum&&(i.sub_sum.innerText=this.formatter.format(a)),t+a}),0);this.total&&(this.total.innerText=this.formatter.format(t))}showBlueButton(){if(!this.blueButton)return!1;this.getTotalCount()||(this.greenButtonWrap.style.display="none",this.greenButtonWrap[a.qs]("input").value="0",this.blueButton.style.display="flex",this.deleteOrderItems(this.tableDTO(this.table)))}showGreenButton(){if(!this.greenButtonWrap)return!1;this.greenButtonWrap.style.display="flex";const t=+this.greenButtonWrap[a.qs]("input").value;this.greenButtonWrap[a.qs]("input").value=t||1,this.blueButton.style.display="none",this.toServer(this.dto(this.greenButtonWrap[a.qs]("[unit-row]")))}getUrl(){return(0,i.a$)()?"/adminsc/order":"/adminsc/orderitem"}deleteOrderItems(t){const e=`${this.getUrl()}/delete`;(0,i.bE)(e,t)}async toServer(t){const e=`${this.getUrl()}/updateOrCreate`;await(0,i.bE)(e,t)}setFormatter(){this.formatter=new Intl.NumberFormat("ru",{style:"currency",currency:"RUB",minimumFractionDigits:2})}rowDto(t){return{count:t[a.qs]("input").value,multiplier:t.dataset.multiplier,sub_sum:t[a.qs](".sub-sum")}}tableDTO(t){return{unit_ids:this.unitIds(t),product_id:this.sid}}unitIds(t){return[...t[a.qa]("[unit-row]")].map((t=>t.dataset.unitid))}dto(t){return{count:t[a.qs]("input").value,unit_id:t.dataset.unitid,product_id:this.sid}}}}}]);
//# sourceMappingURL=239.js.map