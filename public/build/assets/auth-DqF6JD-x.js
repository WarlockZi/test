const __vite__fileDeps=["assets/login-ZF4bh_KA.js","assets/common-DVK5bmCY.js","assets/modal-BXtAzA2d.js","assets/modal-aJpmGEvw.css"],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{$ as s,g as f,s as w,p as i,t as l,v as u,_ as p}from"./common-DVK5bmCY.js";let c=s(".search input").first();c&&c.addEventListener("input",function(){v(c)});async function v(t){let a=t.parentNode,e=s(a).find(".search__result");if(t.value.length<1){e&&(e.innerHTML="");return}let n=await fetch("/search?q="+t.value);n=await n.json(n),e.childNodes.length!==0&&(e.innerHTML=""),n.map(r=>{let o=document.createElement("a");o.href=r.alias,o.innerHTML=`<img src='/pic/${r.preview_pic}' alt='${r.name}'>`+r.name,e.appendChild(o)}),s("body").on("click",function(r){e&&r.target!==e&&(e.innerHTML="")})}function g(){s(".password-control")&&s(".password-control").on("click",a);function a({target:e}){let n=e.parentNode.querySelector("input");n.getAttribute("type")==="password"?n.setAttribute("type","text"):n.setAttribute("type","password"),e.classList.toggle("view")}}h("cn");s("#cn-accept-cookie").on("click",_);function h(t){f(t)?s("#cookie-notice").css("bottom","-100%"):s("#cookie-notice").css("bottom","0")}function _(){w("cn",1,3),s("#cookie-notice").css("bottom","-100%")}s(".changepassword").on("click",async function(t){let a={old_password:s('[name="old_password"]')[0].value,new_password:s('[name="new_password"]')[0].value},e=s(".message")[0],n=await i("/auth/changepassword",a);n.success?(e.innerText=n.success,s(e).addClass("success"),s(e).removeClass("error")):n.error&&(e.innerText=n.error,s(e).addClass("error"),s(e).removeClass("success"))});let d=s("[data-auth='register']")[0];d&&s(d).on("click",L);function L({target:t}){let a=l(s("input[type = email]")[0].value),e=l(s("input[name = password]")[0].value);t.classList.contains("submit__button")&&b(a,e)&&k(a,e)}function m(t){let a=s(".message")[0];a.innerText="",a.innerText=a.innerText+t,s(a).removeClass("success"),s(a).addClass("error")}function b(t,a){let e=u.email(t);return e||(e=u.password(a),e)?(m(e),!1):!0}async function k(t,a){const e=s(".message")[0],n={email:t,password:a,surName:s("[name='surName']")[0].value,name:s("[name='name']")[0].value},r=await i("/auth/register",n);r?.arr?.success==="confirm"?(e.classList.remove("error"),e.classList.add("success"),e.innerHTML="-Пользователь зарегистрирован.<br>-Для подтверждения регистрации зайдите на почту, <bold>email</bold>.<br> -Перейдите по ссылке в письме."):r.msg==="mail exists"?(e.innerHTML="Эта почта уже зарегистрирована. Войдите в систему по кнопке внизу Войти или, если не помните пароль, восстановите пароль по кнопке Забыл пароль",e.classList.remove("success"),e.classList.add("error")):(e.innerHTML=r.msg,e.classList.remove("success"),e.classList.add("error"))}let T=s('[data-auth="returnpass"]')[0];T&&s(".submit__button").on("click",async function(t){let a=s('input[type="email"]')[0].value;await i("/auth/returnpass",{email:a})&&(window.location="/auth/login")});s("#save").on("click",async function(t){t.preventDefault();let a={name:s('[name = "name"]')[0].value,surName:s('[name = "surName"]')[0].value,middleName:s('[name = "middleName"]')[0].value,birthDate:s('[name = "birthDate"]')[0].value,phone:s('[name = "phone"]')[0].value,sex:void 0};await i("/user/edit",a)});const y=s("[data-auth='login']").first();if(y){const{default:t}=await p(()=>import("./login-ZF4bh_KA.js"),__vite__mapDeps([0,1]));new t}if(s(".modal-wrapper")){const{default:t}=await p(()=>import("./modal-BXtAzA2d.js"),__vite__mapDeps([2,1,3]));new t}g();
