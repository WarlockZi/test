import{$ as i,p as r,m as d}from"./common-BmjU9IJD.js";import{b as l}from"./constants-D_Ps4z6O.js";class v{constructor(s){this.navs=i("[data-pagination]")??"",this.finishBtn=i(".finish-test").first(),i(".question").first().classList.add("show"),this.inactivateFinishBtn(),s.addEventListener("click",this.handleClick.bind(this))}handleClick({target:s}){const t=+i(".question.show").first()?.dataset.id,e=this.navs.findIndex(n=>n.classList.contains("active"))??0;s.type==="checkbox"?(this.handleCheckboxChange(s),s.labels[0].classList.toggle("pushed")):s.id==="prev"?this.prevQ(t,e):s.id==="next"?this.nextQ(t,e):s===this.finishBtn&&this.finishTest(s).then()}handleCheckboxChange(s){const t=s.closest(".question")[l]("[type='checkbox']"),e=[].filter.call(t,o=>o.checked===!0),n=s.closest(".question").dataset.id,a=i(".navigation").find(`[data-pagination="${n}"]`);e?a.classList.add("filled"):a.classList.remove("filled")}prevQ(s,t){if(t<1)return!1;const e=+this.navs[t-1].dataset.pagination;this.pushNav(s,e),this.pushQ(e)}nextQ(s,t){if(t+1===this.navs.length)return!1;const e=+this.navs[t+1].dataset.pagination;this.pushNav(s,e),this.pushQ(e)}pushNav(s,t){i(`[data-pagination="${s}"]`).first().classList.toggle("active"),i(`[data-pagination="${t}"]`).first().classList.toggle("active")}pushQ(s){i(".question.show").first().classList.toggle("show"),i(`.question[data-id="${s}"]`).first().classList.toggle("show")}async finishTest(s){if(s.innerText==="ПРОЙТИ ТЕСТ ЗАНОВО"){location.reload();return}s.innerText="ПРОЙТИ ТЕСТ ЗАНОВО",s.classList.add("inactive");const t=await r("/adminsc/test/getCorrectAnswers",{});this.colorView(t.arr);const e=i(".redShadow").length,n=this.DTO(e);await r("/adminsc/testresult/create",n)&&(s.href=location.href,s.innerText="ПРОЙТИ ТЕСТ ЗАНОВО")}DTO(s){return{questionCnt:i(".question").length,errorCnt:s,html:d(".test-do .content"),testid:i("[data-test-id]")[0].dataset.testId,testname:i(".test-name")[0].innerText,user:i(".user-menu .fio")[0].innerText}}colorView(s){let t=i(".question");[].map.call(t,e=>{let n=this.colorQuestions(e,s);this.colorPgination(e,n)})}colorPgination(s,t){const e=s.dataset.id,n=i(`.pagination [data-pagination='${+e}']`)[0];t.length?i(n).addClass("redShadow"):i(n).addClass("greenShadow")}colorQuestions(s,t){const e=s.querySelectorAll(".a"),n=[];return[].map.call(e,a=>{const o=i(a).find("input"),c=a.dataset.id;this.checkCorrectAnswers(c,t,o,a)&&n.push(!0)}),n}checkCorrectAnswers(s,t,e,n){const a=t.indexOf(+s)!==-1,o=e.checked;let c=!1;return o&&a?n.classList.add("done"):o&&!a?c=!0:!o&&a&&(n.classList.add("done"),c=!0),c}inactivateFinishBtn(){window.location.pathname.match("^/test/result/.?")&&this.finishBtn.classList.add("inactive")}}export{v as default};
//# sourceMappingURL=TestDo-B4Dehs2I.js.map
