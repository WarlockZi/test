import{$ as a,v as t,p as r}from"./common-BEiZe_HE.js";var n={VITE_SU_EMAIL:"vvoronik@yandex.ru"};class d{constructor(){if(this.loginForm=a("[data-auth='login']").first(),!this.loginForm)return!1;this.loginForm.addEventListener("click",this.sendData.bind(this)),this.email=a("input[type = email]")[0],this.pass=a("input[name= password]")[0],this.msg=a(".message")[0]}async sendData({target:s}){if(s.classList.contains("submit__button")){let i={email:this.email.value,password:this.pass.value};if(this.validateData()){const e=await this.send(i);await this.parseLoginResponse(e)}}}validateData(){let s=t.email(this.email.value);return s?(this.msg.innerText="",this.msg.innerText=s,a(this.msg).addClass("error"),!1):!(n?.VITE_SU_EMAIL===this.email.value)&&(s=t.password(this.pass.value),s)?(this.msg.innerText="",this.msg.innerText=s,a(this.msg).addClass("error"),!1):!0}async send(s){return await r("/auth/login",s)}async parseLoginResponse(s){const i=s?.arr?.id;localStorage.setItem("id",i),s?.arr?.role==="employee"?window.location="/adminsc":s?.arr?.role==="user"?window.location="/auth/profile":s?.error}}export{d as default};
//# sourceMappingURL=login-CX5EeMGt.js.map
