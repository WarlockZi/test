import{$ as e,p as l,k as d}from"./common-DVK5bmCY.js";class f{constructor(t){this.testDo=e(".test-do .content")[0],this.navs=e("[data-pagination]")??"",this.finishBtn=e(".test-do__finish-btn").first(),this.showFirstQuest(),this.finishBtnInit(),this.testDo.addEventListener("click",this.handleClick.bind(this))}handleClick({target:t}){const s=e(".question.show")[0]??"";if(!s)return;const i=+s?.dataset.id,n=this.navs.findIndex(a=>a.classList.contains("active"))??"";t.type==="checkbox"?t.labels[0].classList.toggle("pushed"):t.id==="prev"?this.prevQ(i,n):t.id==="next"?this.nextQ():t===this.finishBtn&&this.finishTest(t).then()}prevQ(t,s){if(s<1)return!1;let i=+this.navs[s-1].dataset.pagination;this.pushNav(t,i),this.pushQ(i)}nextQ(){if(navIndex===navs.length-1)return!1;let t=+navs[navIndex+1].dataset.pagination;pushNav(id,t),pushQ(t)}pushNav(t,s){e(`[data-pagination="${t}"]`)[0].classList.toggle("active"),e(`[data-pagination="${s}"]`)[0].classList.toggle("active")}pushQ(t){currQuest.classList.toggle("show"),e(`.question[data-id="${t}"]`)[0].classList.toggle("show")}async finishTest(t){if(t.innerText==="ПРОЙТИ ТЕСТ ЗАНОВО"){location.reload();return}t.innerText="ПРОЙТИ ТЕСТ ЗАНОВО",t.classList.add("inactive");let s=await l("/adminsc/test/getCorrectAnswers",{});colorView(s.arr);let i=e(".redShadow").length,n=objToServer(i);await l("/adminsc/testresult/create",n)&&(t.href=location.href,t.innerText="ПРОЙТИ ТЕСТ ЗАНОВО")}objToServer(t){return{questionCnt:e(".question").length,errorCnt:t,html:d(".test-do .content"),testid:e("[data-test-id]")[0].dataset.testId,testname:e(".test-name")[0].innerText,user:e(".user-menu .fio")[0].innerText}}colorView(t){let s=e(".question");[].map.call(s,i=>{let n=colorQuestions(i,t);colorPgination(i,n)})}colorPgination(t,s){let i=t.dataset.id,n=e(`.pagination [data-pagination='${+i}']`)[0];s.length?e(n).addClass("redShadow"):e(n).addClass("greenShadow")}colorQuestions(t,s){let i=t.querySelectorAll(".a"),n=[];return[].map.call(i,a=>{let r=e(a).find("input"),o=a.dataset.id;checkCorrectAnswers(o,s,r,a)&&n.push(!0)}),n}checkCorrectAnswers(t,s,i,n){let a=s.indexOf(+t)!==-1,r=i.checked,o=!1;return r&&a?n.classList.add("done"):r&&!a?o=!0:!r&&a&&(n.classList.add("done"),o=!0),o}finishBtnInit(){window.location.pathname.match("^/test/result/.?")&&this.finishBtn.classList.add("inactive")}showFirstQuest(){e(".question").removeClass("show"),e(".question:first-child").addClass("show")}}export{f as default};
