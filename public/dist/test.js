(()=>{"use strict";async function e(e,t){return new Promise((function(a,n){t.token=document.querySelector('meta[name="token"]').getAttribute("content");let i=new XMLHttpRequest;i.open("POST",e,!0),i.setRequestHeader("X-Requested-With","XMLHttpRequest"),t instanceof FormData?i.send(t):(i.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),i.send("param="+JSON.stringify(t))),i.onerror=function(){n(Error("Network Error"))},i.onload=function(){a(i.response)}}))}function t(e){this.el=e,this.elType={}.toString.call(e),this.on=function(t,a){"[object HTMLDivElement]"===this.elType&&this.el.addEventListener(t,a),"[object NodeList]"===this.elType&&e.forEach((e=>e.addEventListener(t,a)))},this.value=function(){return this.el[0].getAttribute("value")},this.count=function(){return this.el.length},this.getWithStyle=function(t,a){let n=[];return e.forEach((e=>{e.style[t]===a&&n.push(e)})),n},this.addClass=function(e){"[object HTMLDivElement]"===this.elType&&this.el.classList.add(e),["[object NodeList]","[object Array]"].includes(this.elType)&&this.el.forEach((t=>{t.classList.add(e)}))},this.removeClass=function(e){this.el.forEach((t=>{t.classList.remove(e)}))},this.hasClass=function(e){if(this.el.classList.contains(e))return!0},this.append=function(e){this.el[0].appendChild(e)},this.find=function(e){return["[object HTMLDivElement]","[object HTMLInputElement]"].includes(this.elType)?this.el.querySelector(e):["[object NodeList]","[object Array]"].includes(this.elType)?this.el[0].querySelector(e):void 0},this.css=function(t,a){if(!a)return this.el[0].style[t];"[object HTMLDivElement]"===this.elType&&(this.el.style[t]=a),"[object NodeList]"===this.elType&&e.forEach((e=>{e.style[t]=a}))}}function a(e){let a="";return a="string"==typeof e?document.querySelectorAll(e):e,new t(a)}async function n(t){if(a(t.target).hasClass("a-del")){let a=+t.target.closest(".e-block-a").id,n=await e("/answer/delete",{a_id:a});if(n=JSON.parse(n),"ok"===n.msg){let e=t.target.closest(".e-block-a");confirm("Удалить этот ответ?")&&e.remove()}}}async function i(t){if(a(t.target).hasClass("a-add")){let i=+t.target.closest(".e-block-q").id,s=await e("/answer/show",{q_id:i}),o=a(".block.flex1").el[0];a(o).find(".answers").insertAdjacentHTML("afterBegin",s);let l=a(o).find(".e-block-a:first-child");a(l).css("background-color","pink"),setTimeout((function(){a(l).css("background-color","white")}),300),a(l).on("click",n)}}async function s(t){if(a(t.target).hasClass("q-delete")&&confirm("Удалить вопрос со всеми его ответами?")){let n=+t.target.closest(".e-block-q").id,i=await e("/question/delete",{q_id:n});i=JSON.parse(i),"ok"===i.msg&&(t.target.closest(".block").remove(),a(`[data-pagination = "${i.q_id}"]`).el[0].remove(),a("[data-pagination]:first-child").addClass("nav-active"),a(".block:first-child").addClass("flex1"))}}function o(e,t){return{id:+e.target.dataset.qid,parent:+a(".test-name").el[0].getAttribute("value"),picq:"",qustion:a(t).find("textarea").value,sort:+a(t).find(".sort-q").value}}function l(e,t,a){let n=t.querySelectorAll(".e-block-a"),i=[];return n.forEach((e=>{i.push({id:+e.querySelector(".checkbox").dataset.answer,answer:e.querySelector("textarea").value,correct_answer:+e.querySelector(".checkbox").checked,parent_question:+a,pica:""})}),a),i}async function c(t){let c=a(".block.flex1").el[0],r=await e("/question/UpdateOrCreate",{question:o(t,c),answers:l(0,c,a(c).find("textarea").value)});var d;r=JSON.parse(r),r&&(d=r.paginationButton,a(".pagination .nav-active").el[0]&&a(".pagination .nav-active").el[0].classList.remove("nav-active"),a(".add-question").el[0].insertAdjacentHTML("beforeBegin",d),a(".block.flex1").removeClass("flex1"),function(){let e=a(".overlay").find(".block");a(".blocks").append(e),a(e).addClass("flex1"),a(".a-add").on("click",i),a(".q-delete").on("click",s),a(".a-del").on("click",n)}(),closeOverlay())}document.cookie.match("(^|;)?cn=([^;]*)")?a("#cookie-notice").css("bottom","-100%"):a("#cookie-notice").css("bottom","0"),a("#cn-accept-cookie").on("click",(function(){(function(){const e=new Date;e.setTime(e.getTime()+864e5),document.cookie="cn=1; expires="+e+"path=/; SameSite=lax"})(),a("#cookie-notice").css("bottom","-100%")})),a(".question").removeClass("flex1"),a(".question:first-child").addClass("flex1"),a('[type="checkbox"]').on("click",(function(e){e.target.labels[0].classList.toggle("pushed")})),a(".content").on("click",(async function(t){let n=t.target;if("btnn"===n.id){if("ПРОЙТИ ТЕСТ ЗАНОВО"==n.text)return void location.reload();let t=await e("/test/getCorrectAnswers",{});t=JSON.parse(t);let s=(i=function(e){let t=a(".question").el;return Array.from(t).map(((t,n)=>{let i=t.querySelectorAll(".a"),s=[];Array.from(i).map((t=>{let a=t.getElementsByTagName("input")[0],n=a.id.replace("answer-",""),i=t.getElementsByTagName("label")[0];(function(e,t,a){return t.checked&&e?(a.classList.add("done"),!0):!(t.checked&&!e)&&(!t.checked&&e?(a.classList.add("done"),a.classList.add("done"),!1):!t.checked&&!e||void 0)})(-1!==e.indexOf(n),a,i)||s.push(!0)}));let o=a('.pagination [data-pagination="'+ +t.dataset.id+'"]').el[0];s.length?a(o).addClass("redShadow"):a(o).addClass("greenShadow")})),a(".redShadow").el.length}(t),{token:document.querySelector('meta[name="token"]').getAttribute("content"),questionCnt:a(".question").el.length,errorCnt:i,pageCache:`<!DOCTYPE ${document.doctype.name}>`+document.documentElement.outerHTML,testId:a("[data-test-id]").el[0].dataset.testId,test_name:a(".test-name").el[0].innerText,userName:a(".user-menu__FIO").el[0].innerText});await e("/test/cachePageSendEmail",s)&&(a("#btnn").el[0].href=location.href,a("#btnn").el[0].text="ПРОЙТИ ТЕСТ ЗАНОВО")}var i})),void 0!==a(".test_delete").el[0]&&new class{constructor(e){this._elem=e,e.onclick=this.onClick.bind(this),e.onmouseenter=this.showToolip,e.onmouseleave=this.hideTooltip,e.onmousemove=this.changeTooltipPos}async delete(){if(confirm("Удалить тест?")){let t=a(".test-name").value(),n=await e("/test/delete",{id:t});n=JSON.parse(n),"ok"===n.msg&&(window.location="/test/edit")}}changeTooltipPos(e){this.tip.style.top=e.pageY+35+"px",this.tip.style.left=e.pageX-170+"px"}hideTooltip(){this.tip.remove()}showToolip(e){let t=e.clientX,n=e.clientY,i=document.createElement("div");a(i).addClass("tip"),i.style.top=n+70+"px",i.style.left=t-170+"px",i.innerText=this.getAttribute("tip"),this.tip=i,document.body.append(i)}onClick(e){let t=e.target.closest(".test_delete").dataset.click;t&&this[t]()}}(a(".test_delete").el[0]),window.location.pathname.match("/adminsc/test/")&&document.querySelector(".module.test").classList.add("activ"),function(e){let t=document.getElementsByClassName("holder"),a={filereader:"undefined"!=typeof FileReader,dnd:"draggable"in document.createElement("span"),formdata:!!window.FormData,progress:"upload"in new XMLHttpRequest},n={filereader:document.querySelectorAll(".filereader"),formdata:document.querySelectorAll(".formdata"),progress:document.querySelectorAll(".progress")},i={"image/png":!0,"image/jpeg":!0,"image/gif":!0},s=(document.getElementById("uploadprogress"),document.getElementById("upload")),o="filereader formdata progress".split(" ");for(var l in o)if(!1===a[o[l]])n[o[l]].className="fail";else{let e=n[o[l]];for(var c=0;c<e.length;++c)e[c].className="hidden"}if(a.dnd)for(let e=0;e<t.length;e++)t[e].ondragover=function(){return this.className="hover",this.style.width="234px",this.style.height="162px",!1},t[e].ondragleave=function(){return this.className="holder",!1},t[e].ondragend=function(){return this.className="",!1},t[e].ondrop=function(e){this.className="holder",e.preventDefault(),d(e.dataTransfer.files,this)};else s.className="hidden",s.querySelector("input").onchange=function(){d(this.files)};function r(e,n){if(!0===a.filereader&&!0===i[e.type]){var s=n,o=new FileReader;o.onload=function(e){s.getElementsByTagName("img").length&&s.getElementsByTagName("img")[0].remove();var t=new Image;"q"===s.getAttribute("data-prefix")?t.id="imq"+s.getAttribute("id"):"a"===s.getAttribute("data-prefix")&&(t.id="ima"+s.getAttribute("id")),t.src=e.target.result,s.appendChild(t)},o.readAsDataURL(e)}else t.innerHTML+="<p>Загружен "+e.name+" "+(e.size?(e.size/1024|0)+"K":""),console.log(e)}async function d(e,t){let a=new FormData;for(var n=0;n<e.length;n++)a.append("file",e[n],e[n].name),a.append("type",t.dataset.prefix),a.append("typeId",t.id),r(e[n],t);await fetch("/image/create",{method:"POST",body:a})}}(),a(".block").removeClass("flex1"),a(".block:first-child").addClass("flex1"),a(".a-add").on("click",i),a(".q-delete").on("click",s),a(".a-del").on("click",n),a(".sort-q").on("change",(function(){let e=this.nextElementSibling;this.value.match(/\D+/)?(e.innerText="Только цифры",e.style.opacity="1"):"1"===e.style.opacity&&(e.style.opacity="0")})),a(".blocks").on("click",(function(t){if(t.target.classList.contains("question__save")){let n=a(".block.flex1").el[0],i=o(t,n);e("/question/update",{question:i,answers:l(0,n,i.id)})}})),a("[data-pagination]").removeClass("nav-active"),a("[data-pagination]:first-child").addClass("nav-active"),a(".pagination").on("click",(function(t){t.target.classList.contains("add-question")?async function(t){let n=+a(".test-name").value(),i=a("[data-pagination]").count(),s=await e("/question/show",{testid:n,questCount:i});s=JSON.parse(s);let o=s.block;a(".blocks").el[0].insertAdjacentHTML("afterBegin",o);let l=a(".blocks .block:last-child").el[0];a(l).addClass("flex1");let r=a(l).find(".question__save");a(r).on("click",c)}():t.target.getAttribute("data-pagination")&&function(e){if(e.classList.contains("nav-active"))return;let t=a(".pagination .nav-active").el[0];t.classList.remove("nav-active"),e.classList.add("nav-active"),a(`#question-${t.dataset.pagination}`).removeClass("flex1"),a(`#question-${e.dataset.pagination}`).addClass("flex1")}(t.target)})),a(".save-test").on("click",(async function(){let t=a("#test_name").el[0].innerText,n=a("select").el[0],i=+!a("#isPath").el[0].checked,s=n.options[n.selectedIndex].value,o=await e("/test/create",{test_name:t,enable:1,isTest:i,sort:0,parent:s});o=await JSON.parse(o),o&&(window.location.href=`/adminsc/test/edit/${o.id}?id=`+o.id+"&name="+t)}))})();