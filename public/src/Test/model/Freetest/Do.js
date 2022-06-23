import {post} from '../../../common'

//   show first card
    let showedCard = document.querySelector('.test-data .question:first-child ').getAttribute('data-id');
    document.querySelector(`.question[data-id="${showedCard}"`).style.display = "flex"

    document.querySelector('.content #finish-freetest').addEventListener('click', function (event) {
        event.preventDefault();
        let button = document.querySelector('#finish-freetest');
        if (button.text === "ПРОЙТИ ТЕСТ ЗАНОВО") {
            location.reload();
            return;
        }

        let data = {action: 'resultFreetest'};

        post('/freetest/do', data)
            .then(function (val) {

                debugger;
                return colorView(JSON.parse(val))
            })
            .then(function (errorCnt) {
                debugger;
                return sendMailResults(errorCnt)
            })
            .then(function (data) {
                debugger;
                return post('/freetest/do', data)
            });


        function colorView(obj) {
            return new Promise(function (resolve, reject) {
                    let green = 'rgb(0, 255, 41) 0px 2px 11px 3px', //'#e5f7d0',
                        bxShdRed = 'rgb(255, 41, 41) 0px 2px 11px 3px',
                        textarea = document.querySelectorAll('.freetest-text-editable');
                    textarea.forEach(function (elem, tindex, textarea) { // перебираем txtarea
                        let text = elem.innerHTML;
                        if (text) {
                            let textareaId = elem.dataset.textarea,
                                paginItem = document.querySelectorAll('a[href="#question-' + textareaId + '"]')[0],
                                objArr = obj[textareaId]
                                objArr = objArr.split(',')
                            for (let i in objArr) {
                                let our_string = objArr[i],
                                    reg = new RegExp(our_string, 'g');
                                if (reg.test(text)) {
                                    elem.innerHTML = elem.innerHTML.replace(reg, "<span style ='color:green;font-weight:800'> " + our_string + "</span>");
                                    paginItem.autocomplete.boxShadow = green; // greennew RegExp(our_string, 'g')
                                }
                            }
                        }
                    })
                    let btn = document.getElementById("finish-freetest");
                    btn.href = location.href, //"?test="+testId;
                        btn.text = "ПРОЙТИ ТЕСТ ЗАНОВО",
                        errorsCnt = 0,
// Правильные ответы зеленым
                        a = document.querySelectorAll("a[href^='#question-']");
                    for (let i = 0; i < a.length; i++) {
                        if (a[i].autocomplete.boxShadow != green) {// Если не красный, раскрасим в зеленый
                            a[i].autocomplete.boxShadow = bxShdRed;
                            errorsCnt++;
                        }
                    }
                    resolve(errorsCnt);
                }
            );
        }


        function sendMailResults(errorCnt) {
            return new Promise(function (resolve, reject) {
                let doctypeHtml = "<!DOCTYPE " + document.doctype.name + '>',
                    pageCache = doctypeHtml + document.documentElement.outerHTML,
                    url = '/freetest/do';
                let testId = +button.dataset.id;
                let test_name = document.querySelector('.test-name').text();
                let name = document.querySelector('.user-button span').text();
                let userAnswers = {};
                document.querySelector('.question').each(function (index, element) {
                    let id = document.querySelector(this).data('id'),
                        textarea = element.lastElementChild.innerText;
                    userAnswers[id] = textarea; // Сохраним в массиве под уникальным номером
                });

                let data = {
                    questionCnt: document.querySelector('.question').length,
                    errorCnt: errorCnt,
                    pageCache: pageCache,
                    action: 'send_mail_Freetest',
                    userAnswers: userAnswers,
                    testId: testId,
                    name: name,
                    test_name: test_name
                };

                resolve(data);
            });
        }
    },true);


/////////////////////////////////////////////////////////////////////////////
/////////// RESULTS FREETEST , показать результаты /////////////////////////////
/////////////////////////////////////////////////////////////////////////////

//    $('.content').on('click', '#finish-freetest', function (event) {
//       event.preventDefault();
//       let button = document.querySelector('#finish-freetest');
//       if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
//          location.reload();
//          return;
//       }
//
//       let data = {action: 'resultFreetest'};
//
//       post(PROJ + '/freetest/do', data)
//       .then(function (val) {
//
//          debugger;
//          return colorView(JSON.parse(val))
//       })
//       .then(function (errorCnt) {
//          debugger;
//          return sendMailResults(errorCnt)
//       })
//       .then(function (data) {
//          debugger;
//          return post(PROJ + '/freetest/do', data)
//       });
//
//
//
//
//       function colorView(obj) {
//          return new Promise(function (resolve, reject) {
//             let green = 'rgb(0, 255, 41) 0px 2px 11px 3px', //'#e5f7d0',
//             bxShdRed = 'rgb(255, 41, 41) 0px 2px 11px 3px',
//             textarea = document.querySelectorAll('.freetest-text-editable');
//             textarea.forEach(function (elem, tindex, textarea) { // перебираем txtarea
//                let text = elem.innerHTML;
//                if (text) {
//                   let textareaId = elem.dataset.textarea,
//                   paginItem = document.querySelectorAll('a[href="#question-' + textareaId + '"]')[0],
//                   objArr = obj[textareaId],
//                   objArr = objArr.split(',');
//                   for (let i in objArr) {
//                      let our_string = objArr[i],
//                      reg = new RegExp(our_string, 'g');
//                      if (reg.test(text)) {
//                         elem.innerHTML = elem.innerHTML.replace(reg, "<span style ='color:green;font-weight:800'> " + our_string + "</span>");
//                         paginItem.autocomplete.boxShadow = green; // greennew RegExp(our_string, 'g')
//                      }
//                   }
//                }
//             })
//             let btn = document.getElementById("finish-freetest");
//             btn.href = location.href, //"?test="+testId;
//             btn.text = "ПРОЙТИ ТЕСТ ЗАНОВО",
//             errorsCnt = 0,
// // Правильные ответы зеленым
//             a = document.querySelectorAll("a[href^='#question-']");
//             for (let i = 0; i < a.length; i++) {
//                if (a[i].autocomplete.boxShadow != green) {// Если не красный, раскрасим в зеленый
//                   a[i].autocomplete.boxShadow = bxShdRed;
//                   errorsCnt++;
//                }
//             }
//             resolve(errorsCnt);
//          }
//          );
//       }
//
//
//
//
//       function sendMailResults(errorCnt) {
//          return new Promise(function (resolve, reject) {
//             let doctypeHtml = "<!DOCTYPE " + document.doctype.name + '>',
//             pageCache = doctypeHtml + document.documentElement.outerHTML,
//             url = PROJ + '/freetest/do';
//             let testId = +button.dataset.id;
//             let test_name = $('.test-name').text();
//             let name = $('.user-button span').text();
//             let userAnswers = {};
//             $('.question').each(function (index, element) {
//                let id = $(this).data('id'),
//                textarea = element.lastElementChild.innerText;
//                userAnswers[id] = textarea; // Сохраним в массиве под уникальным номером
//             });
//
//             let data = {
//                questionCnt: $('.question').length,
//                errorCnt: errorCnt,
//                pageCache: pageCache,
//                action: 'send_mail_Freetest',
//                userAnswers: userAnswers,
//                testId: testId,
//                name: name,
//                test_name: test_name
//             };
//
//             resolve(data);
//          });
//       }
//    });

