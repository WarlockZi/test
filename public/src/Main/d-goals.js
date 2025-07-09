"use strict";

function sendGoal(goal_YM, goal_GA) {
    var comment = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";
    try {
        //if (goal_GA != "") { void gtag('event', goal_GA); }
        if (goal_YM != "") { void ym(7715905, 'reachGoal', goal_YM); } 
        //console.log('[d-goals.js] Send: ' + ' YM: "' + goal_YM + '" | GA: "' + goal_GA + '" | ' + comment);
    } catch (e) {
        console.log('[d-goals.js] Error:' + e);
    }
}

function setGoal(event, selector, params) {
    let elements = document.querySelectorAll(selector);
    let goal_YM = params[0] !== undefined ? params[0] : "";
    // let goal_GA = params[1] !== undefined ? params[1] : "";
    let comment = params.length > 2 && params[2] !== undefined ? params[2] : "";

    Array.from(elements).forEach(element => {
        element.addEventListener(event, function(e) {
            sendGoal(goal_YM, comment);
            console.log(params);
        });
    });
}

console.log('[d-goals.js] Load: ok');
document.addEventListener('click', function(e){  
  if(e.target.matches('button') && null !== e.target.closest('#callme')) {
        sendGoal('call_me_submit', 'Заполнение формы напишите свой вопрос');
        sendGoal('call_back_form_submit', 'Отправка позвоните мне');
        console.log('call_me_submit');
     } 
});
setGoal('click',  'button#call-me', ['call_me_click', '/call_me_click', 'Нажатие позвоните мне']);
// setGoal('click',  'button#callme', ['call_me_submit', '/call_me_submit', 'Отправка позвоните мне']);
setGoal('submit',  '.feedback-form form', ['form_footer', '/form_footer', 'Заполнение формы напишите свой вопрос']);
setGoal('click',  'button#fixed-call-me', ['call_back_icon_click', '/call_back_icon_click', 'Нажатие телефона']);
//setGoal('click',  'button#callme', ['call_back_form_submit', '/call_back_form_submit', 'Отправка позвоните мне']);