const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/login-VgxUmiqU.js","assets/common-BmjU9IJD.js","assets/modal-Bix5cJPH.js","assets/constants-D_Ps4z6O.js","assets/modal-CsdT2GQ5.css"])))=>i.map(i=>d[i]);
import{$ as s,p as c,_ as d}from"./common-BmjU9IJD.js";import"./cookie-CmLS3Uuq.js";let o=s(".search input").first();o&&o.addEventListener("input",function(){u(o)});async function u(t){let r=t.parentNode,e=s(r).find(".search__result");if(t.value.length<1){e&&(e.innerHTML="");return}let a=await fetch("/search?q="+t.value);a=await a.json(a),e.childNodes.length!==0&&(e.innerHTML=""),a.map(n=>{let i=document.createElement("a");i.href=n.alias,i.innerHTML=`<img src='/pic/${n.preview_pic}' alt='${n.name}'>`+n.name,e.appendChild(i)}),s("body").on("click",function(n){e&&n.target!==e&&(e.innerHTML="")})}function m(){s(".password-control")&&s(".password-control").on("click",r);function r({target:e}){const a=e.parentNode.querySelector("input");a.getAttribute("type")==="password"?a.setAttribute("type","text"):a.setAttribute("type","password"),e.classList.toggle("view")}}s(".changepassword").on("click",async function(t){let r={old_password:s('[name="old_password"]')[0].value,new_password:s('[name="new_password"]')[0].value},e=s(".message")[0],a=await c("/auth/changepassword",r);a.success?(e.innerText=a.success,s(e).addClass("success"),s(e).removeClass("error")):a.error&&(e.innerText=a.error,s(e).addClass("error"),s(e).removeClass("success"))});let l=s("[data-auth='register']")[0];l&&s(l).on("click",f);function f({target:t}){p(email,password)}async function p(t,r){const e=s(".message")[0],a={email:t,password:r,surName:s("[name='surName']")[0].value,name:s("[name='name']")[0].value},n=await c("/auth/register",a);n?.arr?.success==="confirm"?(e.classList.remove("error"),e.classList.add("success"),e.innerHTML="-Пользователь зарегистрирован.<br>-Для подтверждения регистрации зайдите на почту, <bold>email</bold>.<br> -Перейдите по ссылке в письме."):n.msg==="mail exists"?(e.innerHTML="Эта почта уже зарегистрирована. Войдите в систему по кнопке внизу Войти или, если не помните пароль, восстановите пароль по кнопке Забыл пароль",e.classList.remove("success"),e.classList.add("error")):(e.innerHTML=n.msg,e.classList.remove("success"),e.classList.add("error"))}s("#save").on("click",async function(t){t.preventDefault();let r={name:s('[name = "name"]')[0].value,surName:s('[name = "surName"]')[0].value,middleName:s('[name = "middleName"]')[0].value,birthDate:s('[name = "birthDate"]')[0].value,phone:s('[name = "phone"]')[0].value,sex:void 0};await c("/user/edit",r)});const w=s("[data-auth='login']").first();if(w){const{default:t}=await d(async()=>{const{default:r}=await import("./login-VgxUmiqU.js");return{default:r}},__vite__mapDeps([0,1]));new t}if(s(".modal").first()){const{default:t}=await d(async()=>{const{default:r}=await import("./modal-Bix5cJPH.js");return{default:r}},__vite__mapDeps([2,1,3,4]));new t}m();
//# sourceMappingURL=auth-BKm5G3V-.js.map
