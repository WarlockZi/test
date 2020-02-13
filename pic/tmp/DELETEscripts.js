
window.onload = function () {


   var controller = 'test';
   if (window.location.pathname.indexOf('freetest') + 1) {
      controller = 'freetest';
   }


/////////////////////////////////////////////////////////////////////////////
///////////  RESULTS  TEST  Закончить тест/////////////////////////////
/////////////////////////////////////////////////////////////////////////////



   $('.content').on('click', '#btnn', function () {
      event.preventDefault();
      var button = document.querySelector('#btnn');
      if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
         location.reload();
         return;
      }

      var data = {action: 'result'};

      post(PROJ + '/test/do', data)
      .then(function (corrAnswers) {

         return colorView(JSON.parse(corrAnswers))
      })
      .then(function (errorCnt) {
//         debugger;
         return sendMailResults(errorCnt)
      })
      .then(function (data) {
//         debugger;
         return post(PROJ + '/test/do', data)
      })
      ;

      function colorView(correctAnswers) {
         return new Promise(function (resolve, reject) {
            var green = 'rgb(0, 255, 41) 0px 2px 11px 3px', //'#e5f7d0',
            bxShdRed = 'rgb(255, 41, 41) 0px 2px 11px 3px';
//            var loader = document.querySelector('.overlay-loader').remove();
            var q = document.querySelectorAll('.question'),
            errorsCnt = q.length;

            for (var j = 0; j < q.length; j++) {
               debugger;
               var a = q[j].querySelectorAll('.a');
               for (var i = 0; i < a.length; i++) {
                  var answer = a[i];
                  var input = answer.getElementsByTagName('input')[0],
                  inpVal = input.value;
//                  if (correctAnswers.indexOf(inpVal) != -1) { // это правильный ответ
                  label = answer.getElementsByTagName('label')[0], // Чтобы прикрепить зеленый значек к этому элементу
                  questId = +input.getAttribute('name').replace("question-", ""); // id question
                  paginItem = document.querySelectorAll('a[href="#question-' + questId + '"]')[0];

                  if (input.checked == true && correctAnswers.indexOf(inpVal) != -1) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
                     label.classList.add('done'); //green check зеленый значек
                  }
                  else if (input.checked == true && correctAnswers.indexOf(inpVal) == -1) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
                     paginItem.autocomplete.boxShadow = bxShdRed; // red
                  }
                  else if (input.checked == false && correctAnswers.indexOf(inpVal) != -1) {// кнопка не нажата, в correct_answers есть
                     paginItem.autocomplete.boxShadow = bxShdRed; // red
                     label.classList.add('done');// green check зеленый значек
                  }
                  else if (input.checked == false && correctAnswers.indexOf(inpVal) == -1) {// кнопка не нажата, в correct_answers нет 
//                        paginItem.style.boxShadow = bxShdRed; 
                  };
               };
            };
// Правильные ответы зеленым
            var a = document.querySelectorAll("a[href^='#question-']");
            for (var i = 0; i < a.length; i++) {
               if (a[i].autocomplete.boxShadow != bxShdRed) {// Если не красный, раскрасим в зеленый
                  a[i].autocomplete.boxShadow = "rgb(159, 212, 104) 0px 2px 11px 3px";
                  errorsCnt--;
               }
            }

            var btn = document.getElementById("btnn");
            btn.href = location.href, //"?test="+testId;
            btn.text = "ПРОЙТИ ТЕСТ ЗАНОВО";
            resolve(errorsCnt);
         }
         );
      }




      function sendMailResults(errorCnt) {
         return new Promise(function (resolve, reject) {
            var doctypeHtml = "<!DOCTYPE " + document.doctype.name + '>',
            pageCache = doctypeHtml + document.documentElement.outerHTML,
            url = PROJ + '/test/do';
            var testId = +button.dataset.id;
            var test_name = $('.test-name').text();
            var name = $('.user-button span').text();
            var userAnswers = {};
            $('.question').each(function (index, element) {
               var id = $(this).data('id'),
               textarea = element.lastElementChild.innerText;
               userAnswers[id] = textarea; // Сохраним в массиве под уникальным номером
            });

            var data = {
               questionCnt:$('.question').length,
               errorCnt: errorCnt,
               pageCache: pageCache,
               action: 'send_mail',
//               userAnswers: userAnswers,
               testId: testId,
               name: name,
               test_name: test_name
            };

            resolve(data);
         });
      }


   });


//   $('.content').on('click', '#btnn', function () {
//      if (this.text === "ПРОЙТИ ТЕСТ ЗАНОВО") {
//         return;
//      }
////        up();
//      var name = $('.user-button span').text();
//      var userAnswers = {};
//      $('.question').each(function () {
//         var id = $(this).data('id');
//         $('input[name = question-' + id + ']').each(function () {// Переберем ответы
//            if ($(this).prop("checked")) {
//               var aid = $(this).val(); //получаем id ответа пользователя
//               userAnswers[id + aid] = aid; // Сохраним в массиве под уникальным номером
//            }
//         });
//      });
//                debugger;
//      $.ajax({
//         url: PROJ + '/test/do',
//         type: 'POST',
//         data: ({action: 'result', name: name, userAnswers: userAnswers}),
//         async: true,
//         beforeSend: function () {
//            var header = document.querySelector('.header');
//            var loader = document.createElement('div');
//            loader.className = "overlay-loader";
//            loader.innerHTML = "<div class='loader'><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
//            header.parentNode.insertBefore(loader, header);
//         },
//         success: function (correctAnswers) {
////                debugger;
//            var loader = document.querySelector('.overlay-loader').remove();
//            var pink = '#ffc9c9',
//            green = '#e5f7d0',
//            bxShdRed = 'rgb(255, 41, 41) 0px 2px 11px 3px';
//            $('.a').each(function (index, elem) {
//               var input = elem.getElementsByTagName('input')[0], // Подсветка отмеченных ответов
//               label = elem.getElementsByTagName('label')[0], // Чтобы прикрепить зеленый значек к этому элементу
//               questId = +input.getAttribute('name').replace("question-", ""), // id question
//               paginItem = document.querySelectorAll('a[href="#question-' + questId + '"]')[0];
//               if (input.checked == true && correctAnswers.indexOf(input.value) != -1) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
//                  label.classList.add('done'); //green check зеленый значек
//
//               }
//               else if (input.checked == true && correctAnswers.indexOf(input.value) == -1) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
//                  paginItem.style.boxShadow = bxShdRed; // red
//
//               }
//               else if (input.checked == false && correctAnswers.indexOf(input.value) != -1) {// в correct_answers нет,  кнопка не нажата
//                  paginItem.style.boxShadow = bxShdRed; // red
//                  label.classList.add('done'); //green e
//               }
//
//            })
//            var btn = document.getElementById("btnn");
//            btn.href = location; //"?test="+testId;
//            btn.text = "ПРОЙТИ ТЕСТ ЗАНОВО";
//// Правильные ответы зеленым
//            var a = document.querySelectorAll("a[href^='#question-']");
//            for (var i = 0; i < a.length; i++) {
//               if (a[i].style.boxShadow != bxShdRed) {// Если не красный, раскрасим в зеленый
//                  a[i].style.boxShadow = "rgb(159, 212, 104) 0px 2px 11px 3px";
//               }
//            }
//         },
//         error: function () {
//            alert('Error!');
//         }
//      });
//   });



/////////////////////////////////////////////////////////////////////////////
/////////// RESULTS FREETEST , показать результаты /////////////////////////////
/////////////////////////////////////////////////////////////////////////////

   function post(url, data) {

      return new Promise(function (resolve, reject) {
         var req = new XMLHttpRequest();
         req.open('POST', url);
         req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
         req.send('param=' + JSON.stringify(data));
         req.onerror = function () {
            reject(Error("Network Error"));
         };
         req.onload = function () {
            resolve(req.response);
         };
      });
   }



   $('.content').on('click', '#finish-freetest', function (event) {
      event.preventDefault();
      var button = document.querySelector('#finish-freetest');
      if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
         location.reload();
         return;
      }

      var data = {action: 'resultFreetest'};

      post(PROJ + '/freetest/do', data)
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
         return post(PROJ + '/freetest/do', data)
      });




      function colorView(obj) {
         return new Promise(function (resolve, reject) {
            var green = 'rgb(0, 255, 41) 0px 2px 11px 3px', //'#e5f7d0',
            bxShdRed = 'rgb(255, 41, 41) 0px 2px 11px 3px',
            textarea = document.querySelectorAll('.freetest-text-editable');
            textarea.forEach(function (elem, tindex, textarea) { // перебираем txtarea
               var text = elem.innerHTML;
               if (text) {
                  var textareaId = elem.dataset.textarea,
                  paginItem = document.querySelectorAll('a[href="#question-' + textareaId + '"]')[0],
                  objArr = obj[textareaId],
                  objArr = objArr.split(',');
                  for (var i in objArr) {
                     var our_string = objArr[i],
                     reg = new RegExp(our_string, 'g');
                     if (reg.test(text)) {
                        elem.innerHTML = elem.innerHTML.replace(reg, "<span style ='color:green;font-weight:800'> " + our_string + "</span>");
                        paginItem.autocomplete.boxShadow = green; // greennew RegExp(our_string, 'g')
                     }
                  }
               }
            })
            var btn = document.getElementById("finish-freetest");
            btn.href = location.href, //"?test="+testId;
            btn.text = "ПРОЙТИ ТЕСТ ЗАНОВО",
            errorsCnt = 0,
// Правильные ответы зеленым
            a = document.querySelectorAll("a[href^='#question-']");
            for (var i = 0; i < a.length; i++) {
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
            var doctypeHtml = "<!DOCTYPE " + document.doctype.name + '>',
            pageCache = doctypeHtml + document.documentElement.outerHTML,
            url = PROJ + '/freetest/do';
            var testId = +button.dataset.id;
            var test_name = $('.test-name').text();
            var name = $('.user-button span').text();
            var userAnswers = {};
            $('.question').each(function (index, element) {
               var id = $(this).data('id'),
               textarea = element.lastElementChild.innerText;
               userAnswers[id] = textarea; // Сохраним в массиве под уникальным номером
            });

            var data = {
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


   });


//////////////////////  ADD KEY Кнопка добавить ключевик ///////////////
   $('.content').on('click', '.button_key', function () {
      $('<input class = "input_key" type="text">').insertBefore($(this));
   })

///////////////////////   При изменении KEY_WORDS   ///////////////
   $('.content').on('change', '.input_key', function () {
      var qid = this.parentNode.parentNode.querySelector('textarea').dataset.questionId,
      str = '', k,
      arrKeyWords = this.parentNode.querySelectorAll('.input_key');
      for (k = 0; k < arrKeyWords.length; k++) {
//                    debugger;
         var val = arrKeyWords[k].value;
         if (val) {
            str += (!k ? '' : ',') + val.trim();
         }
      }
      $.post("/freetest/edit", {"action": 'addKey', "qid": qid, "str": str});
   });
//////////////////////////////// Параметры Freetest///////////////

// Открываем панель параметров freeтеста
   $('body').on('click', ".add-freetest, .freetest-params", function () {
// Если форма открытa, закроем ее 
      if (document.querySelector('.testParamsBorder')) {
         $('.testParamsBorder').remove();
      }
      var testId = $(this).data('testid');
      $.ajax({
         url: PROJ + '/freetest/edit',
         type: 'POST',
         data: ({testId: testId, action: 'freetestParams'}),
         success: function (res) {
            $('.wrap').after(res);
            $('.overlay').animate({opacity: 0.5}, 200);
            $('.testParamsBorder').fadeIn(100);
         }
      });
   });
// Удалить freeтест
   $('body').on('click', '#freetestParamsDEL', function () {

      var testId = +$('.testId').text();
      $.ajax({
         url: PROJ + '/freetest/edit',
         type: 'POST',
         data: ({tId: testId, action: 'tDel'}),
         cache: false,
         success: function (res) {
            debugger;
            if (confirm('Удалить тест?')) {
               $('.testParamsBorder').hide(100, function () {
                  $(this).remove();
                  $('body .test-params[data-testid =' + testId + ']').parent().add('.overlay').remove();
               });
// Удаляем из второго меню тест
               $('[href="/freetest/edit/' + testId + '"]').parent().remove();
            }

         },
         error: function () {
            alert('Тест не удалился.');
         }
      });
   });
// Кнопка "Отмена"  - не сохранять параметры freeтеста
   $('body').on('click', '#saveTestParmsCansel, .overlay', function () {
      $('.testParamsBorder').add('.overlay').fadeOut(300, function () {
         $(this).remove();
      });
   });
// Кнопака "ОК"  - сохранить параметры freeтеста/Добавить новый freeтест  
   $('body').on('click', '#saveFreetestParamsOK', function () {
      var testId = +$('.testId').text(),
      testName = $('#saveTestName').val(),
      parentTest = +$('#selectParenTest option:selected').val(),
      isTest = +$('#isTest option:selected').val(),
      sort = +$('.sort input').val(),
      enable = $('input[data-test-id]').prop("checked") ? 1 : 0;
      if ($('input[data-test-id]').prop("checked"))
         var enable = 1;
      else
         var enable = 0;
      if (testId) { // Редактируем существующий тест
         $.ajax({
            url: PROJ + '/freetest/edit',
            type: 'POST',
            data: ({action: 'tUpd', testId: testId, testName: testName, parentTest: parentTest, isTest: isTest, sort: sort, enable: enable}),
            cache: false,
            success: function (res) {
               if (res) {

                  $('a[href="' + PROJ + '/edit/' + testId + '"]').text(res);
                  $('.test-name').text('Тест - ' + res);
                  $('.testParamsBorder').add('.overlay').hide(100, function () {
                     $(this).remove()
                  });
               }
               else {
                  window.alert('Заполнитe название');
               }
            },
            error: function () {
               window.alert("Обновление не прошло");
            }
         });
      }
      else { // Создаем новый тест
         if (testName) {
            $.ajax({
               url: PROJ + '/freetest/edit',
               type: 'POST',
               data: ({action: 'tAdd', testId: testId, test_name: testName, parentTest: parentTest, isTest: isTest, sort: sort, enable: enable}),
               success: function (res) {
// Разбиваем объект
                  debugger;
                  var obj = JSON.parse(res);
// Если открыт тест и есть в DOM назв теста удаляем вопросы
                  if (!$('.test-name')) {
                     $('div.block').remove();
                     $('.test-name').after(obj.answer);
                     $('.test-name').after(obj.question);
// Находимся в папке а не в тесте, поэтому контент добавляем
                  }
                  else {
// Всатвляем все после контента
                     var divTestName = '<p class="test-name" name = "test_id" value = "1">Тест - ' + obj.testName + '</p>' + obj.pagination + obj.question;
                     var c = $('.content');
                     c[0].innerHTML = divTestName;
//                            c[0].innerHtml = divTestName;
                     $('.content').html(divTestName);
                     $('.content .block').show();
                  }
// Закрываем рамку создания нового теста
                  $('.testParamsBorder').add('.overlay').fadeOut(150);
// Добавим пункты меню 
                  $('.menu').append(obj.menuItem);
               },
               error: function () {
               }
            });
         }
         else {
            window.alert('Укажите название теста');
            return;
         }
      }
   });
// freeтест Удалить ВОПРОС  
   $('body').on('click', '.delete-question', function () {
      var qId = +$(this).data('id');
      if (!confirm('Удалить вопрос?')) {
         return;
      }

      $.ajax({
         url: `${PROJ}/freetest/edit`,
         type: 'POST',
         data: ({action: 'qDel', qId: qId}),
         cache: false,
         success: function (res) {
            if (res) {
               $('.pagination').find(`[href = "#question-` + res + `"]`).fadeOut(200, function () {
                  $(this).remove();
               });
               $(".block[style='display: block;']").fadeOut(200, function () {
                  $(this).remove();
               });
               $('.pagination a:first-child').removeClass('p-no-active').addClass('nav-active');
            }
            else {
               window.alert("Вопрос не удален");
            }
         },
         error: function () {
            window.alert("Вопрос не удален");
         }
      });
   });
//////////////////////////////// Параметры теста///////////////

// Открываем панель параметров теста
   $('body').on('click', ".add-test, .test-params", function () {
// Если форма открытa, закроем ее 
      if (document.querySelector('.testParamsBorder')) {
         $('.testParamsBorder').remove();
      }
      var testId = $(this).data('testid');
      $.ajax({
         url: PROJ + '/test/edit',
         type: 'POST',
         data: ({testId: testId, action: 'testParams'}),
         success: function (res) {
            $('.wrap').after(res);
            $('.overlay').add('.testParamsBorder').fadeIn();
         }
      });
   });
// Удалить тест
   $('body').on('click', '#TestParamsDEL', function () {

      var testId = +$('.testId').text();
      $.ajax({
         url: PROJ + '/test/edit',
         type: 'POST',
         data: ({tId: testId, action: 'tDel'}),
         cache: false,
         success: function (res) {
            if (confirm('Удалить тест?')) {
               $('.testParamsBorder').hide(100, function () {
                  $(this).remove();
                  $('body .test-params[data-testid =' + testId + ']').parent().add('.overlay').remove();
               });
// Удаляем из второго меню тест
               $('[href="/test/edit/' + testId + '"]').parent().remove();
            }

         },
         error: function () {
            alert('Тест не удалился.');
         }
      });
   });
// Кнопка "Отмена"  - не сохранять параметры теста
   $('body').on('click', '#saveTestParmsCansel, .overlay', function () {
      $('.testParamsBorder').add('.overlay').fadeOut(400, function () {
         $(this).remove();
      });
   });
// Кнопака "ОК"  - сохранить параметры теста/Добавить новый тест  
   $('body').on('click', '#saveTestParamsOK', function () {
      var testId = +$('.testId').text(),
      testName = $('#saveTestName').val(),
      parentTest = +$('#selectParenTest option:selected').val(),
      isTest = +$('#isTest option:selected').val(),
      sort = +$('.sort input').val(),
      enable = $('input[data-test-id]').prop("checked") ? 1 : 0;
      if ($('input[data-test-id]').prop("checked"))
         var enable = 1;
      else
         var enable = 0;
      if (testId) { // Редактируем существующий тест
         $.ajax({
            url: PROJ + '/test/edit',
            type: 'POST',
            data: ({action: 'tUpd', testId: testId, testName: testName, parentTest: parentTest, isTest: isTest, sort: sort, enable: enable}),
            cache: false,
            success: function (res) {
               if (res) {

                  $('a[href="' + PROJ + '/edit/' + testId + '"]').text(res);
                  $('.test-name').text('Тест - ' + res);
                  $('.testParamsBorder').add('.overlay').hide(100, function () {
                     $(this).remove()
                  });
               }
               else {
                  window.alert('Заполнитe название');
               }
            },
            error: function () {
               window.alert("Обновление не прошло");
            }
         });
      }
      else { // Создаем новый тест
         if (testName) {
            $.ajax({
               url: PROJ + '/test/edit',
               type: 'POST',
               data: ({action: 'tAdd', testId: testId, test_name: testName, parentTest: parentTest, isTest: isTest, sort: sort, enable: enable}),
               success: function (res) {
                  var obj = JSON.parse(res);
// Если открыт тест и есть в DOM назв теста удаляем вопросы
                  if (!$('.test-name')) {
                     $('div.block').remove();
                     $('.test-name').after(obj.answer);
                     $('.test-name').after(obj.question);
// Находимся в папке а не в тесте, поэтому контент добавляем
                  }
                  else {
// Всатвляем все после контента
                     var divTestName = '<p class="test-name" name = "test_id" value = "1">Тест - ' + obj.testName + '</p>' + obj.pagination + obj.question + obj.answer;
                     $('.content').html(divTestName);
                     $('.content .block').show();
                  }
// Закрываем рамку создания нового теста
                  $('.testParamsBorder').add('.overlay').fadeOut(150);
// Добавим пункты меню 
                  $('.menu').append(obj.menuItem);
               },
               error: function () {
               }
            });
         }
         else {
            window.alert('Укажите название теста');
            return;
         }
      }
   });
///////////////////

// Изменить сортировку Вопросов
   $('body').on('change', "input[data-q-sort]", function () {
      var qid = +$(this).data('q-sort');
      edit("save_q", null, qid);
   });
// Textarea Вопрос
   $('body').on('change', "textarea[data-question-id]", function () {
      var qid = +$(this).data('question-id');
      edit("save_q", null, qid); //,null,null,sort);
   });
// Textarea Ответ
   $('body').on('change', "textarea[data-answer-id]", function () {
      var id = $(this).data('answer-id');
      edit("save_a", id);
   });
// Включить-выключить Checkbox Right Answer
   $('body').on('change', "input[data-answer]", function () {
      var id = $(this).data('answer');
      edit("save_a", id);
   });
   
   
/////////////////////// Добавить В О П Р О С  ///////////
   $('.add-question').on('click', function () {

      var testId = +$('.test-name').attr('value');
        debugger;
      var questionCollection = document.querySelectorAll(".pagination>[class$='active']");
      var lastQuest = +questionCollection[questionCollection.length - 1].innerHTML;
      $.ajax({
         url: `${PROJ}/${controller}/edit`,
         type: 'POST',
         data: ({action: 'qAdd', testid: testId, questQnt: lastQuest + 1}),
         cache: false,
         success: function (res) {
            var obj = JSON.parse(res);
// Пагинация 
            $('.pagination>.nav-active').removeClass('nav-active').addClass('p-no-active'); // убираем активность
//                alert(obj.menuItem);// Порядковый номер вопроса
            $('.pagination>a:last').before(obj.pagination); // Добавить следующий пункт пагинации 
            $('.pagination>a:last').text('+'); // Порядковый номер вопроса 

            $('.block:visible').hide(); // Спрячем видимый блок
            $('.block:last').after(obj.block); // Выведем новый блок
            $('.content .block:last').show(200); //Покажем новый блок 
            check(0);
         },
         error: function () {
            alert('Произошел сбой.');
         }

      });
   });
/////////////////////// Добавить О Т В Е Т   ///////////
   $('body').on('click', '.add-answer', function () {
      var qid = +$(this).data('id');
      $.ajax({
         url: PROJ + '/test/edit',
         type: 'POST',
         data: ({action: 'aAdd', qid: qid}),
         cache: false,
         success: function (res) {
            var holder = document.querySelectorAll('.holder');
            var a = $('.e-block-q[id = "' + qid + 'q"]').siblings(".e-block-a").last().after(res);
            setTimeout(function () {
               check(1);
            }, 150);
         },
         error: function () {
         }
      });
      check();
   });
////////////////    Подсказка   ///////////////////////////////////////////
   $("[data-tooltip]").mousemove(function (eventObject) {
      var data_tooltip = $(this).attr("data-tooltip");
      $("#tooltip").text(data_tooltip)
      .css({
         "top": eventObject.screenY - 10,
         "left": eventObject.screenX - 1490
      })
      .show();
   }).mouseout(function () {
      $("#tooltip").hide()
      .text("")
      .css({
         "top": 0,
         "left": 0
      });
   });
///////////////////////////    Login     /////////////////////
   var loginButton = document.querySelector("#login"); //превряем есть ли на стр логин
   if (loginButton) {

      loginButton.addEventListener("click", function (e) {
         e.preventDefault();
         var email = $('input[type = email]').val(),
         password = $('input[type= password]').val(),
         token = document.querySelector("[name = 'token']").value,
         formData = new FormData(),
         xhr = new XMLHttpRequest();
         formData.append('email', email);
         formData.append('password', password);
         formData.append('token', token);
         xhr.open('POST', PROJ + '/user/login', true);
         xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
         xhr.send(formData);
         xhr.onreadystatechange = function () {

            if (xhr.readyState == 4 && xhr.status == 200) {

               if (xhr.responseText != 'true') {

                  $('body').after(xhr.responseText);
                  var overlay = document.querySelector(".overlay"),
                  box = document.querySelector(".messageBox"),
                  clos = document.querySelector(".messageClose")
                  ;
                  overlay.addEventListener("click", function () {
                     overlay.autocomplete.display = 'none';
                     box.autocomplete.display = 'none';
                  });
                  clos.addEventListener("click", function () {
                     overlay.autocomplete.display = 'none';
                     box.autocomplete.display = 'none';
                  });

               }
               else if (xhr.responseText == 'squash') {

                  window.location.href = PROJ + "/squash";

                  //document.write("new data");document.close()'
               }


            }
            else {
               window.location.href = PROJ + "/user/cabinet";
            }


         }
//                else {
////alert( xhr.status + ': Ошибка' + xhr.statusText ); // пример вывода: 404: Not Found
//                }


      });
   }
///////////////////////////    REGISTER     /////////////////////

   $("[name = 'reg']").on("click", function (e) {
      e.preventDefault();
      var email = $('input[type = email]').val(),
      password = $("input[type= password]").val(),
      confPass = $("[name='confPass']").val(),
      surName = $("[name='surName']").val(),
      name = $("[name='name']").val(),
      secName = $("[name='secName']").val(),
      token = document.querySelector("[name = 'token']").value;
      formData = new FormData(),
      xhr = new XMLHttpRequest();
      formData.append('email', email);
      formData.append('password', password);
      formData.append('confPass', confPass);
      formData.append('surName', surName);
      formData.append('name', name);
      formData.append('secName', secName);
      formData.append('token', token);
      xhr.open('POST', PROJ + '/user/register', true);
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.send(formData);
      xhr.onreadystatechange = function (res) {

         if (xhr.readyState == 4 && xhr.status == 200) {

            if (xhr.responseText) {

               $('body').after(xhr.responseText);
               var overlay = document.querySelector(".overlay"),
               box = document.querySelector(".messageBox"),
               clos = document.querySelector(".messageClose")
               ;
               overlay.addEventListener("click", function () {
                  overlay.autocomplete.display = 'none';
                  box.autocomplete.display = 'none';
               });
               clos.addEventListener("click", function () {
                  overlay.autocomplete.display = 'none';
                  box.autocomplete.display = 'none';
               });
            }
         }
         else {
            if (xhr.status != 200) {
//alert( xhr.status + ': Ошибка' + xhr.statusText ); // пример вывода: 404: Not Found
            }
         }
      }
   })

//////////// Edit pagination
   var prevActive = $('.pagination').find('.nav-active').attr('href');
   $('.content').add('.test-data').find(prevActive).show();
// Пагинация
   $('.pagination').on('click', '.p-no-active', function () {
      if ($(this).attr('class') == 'nav-active')
         return false;
// Сылка нажатой клавищи 
      var link = $(this).attr('href');
// Ссылка активной клавиши
      var prevActive = $('.pagination>a.nav-active ').attr('href');
// C активной клавищи снимаем активность
      $('.pagination>.nav-active').removeClass('nav-active').addClass('p-no-active');
// Нажатой клавище добавляем активность
      $(this).removeClass('p-no-active').addClass('nav-active');
      if ($(prevActive) !== 0) {// Если удалили вопрос из DOM, его длинна будет 0 и следующий вопрос не покажется
         $(prevActive).fadeOut(100, function () {
            $(link).fadeIn(100);
         });
      }
      else {
         $(link).fadeIn(100);
      }
      return false;
   });
/////////// Удалить картинку
   $('body').on('click', ".pic-del", function () {
      var a = $(this).data('a');
      var q = $(this).data('q');
      edit("del_a_q_pic", a, q);
   });
////////////////////////////////// Функции ///////////////////////


   function edit(action, id, question_id, test_id, test_name) {
      var controller = 'test';
//        debugger;
      if (window.location.pathname.indexOf('freetest') + 1) {
         controller = 'freetest';
      }
      if (action == "save_q") {
         var qpic = $('#imq[data-id = "' + question_id + '"]').attr('src'),
         text = $.trim($('textarea[name = "' + question_id + 'q"]').val()),
         sort = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
         k_word = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
         data = ({action: 'qUpd', data, qid: question_id, qpic: qpic, qtext: text, sort: sort}),
         url = `${PROJ}/${controller}/edit`;
         $.ajax({
            url: url,
            type: 'POST',
            data: data,
         });
      }
      else if (action == "save_a") {
         var apic = $('#ima[data-id = "' + id + '"]').attr('src');
         var text = $.trim($('textarea[name = ' + id + ']').val());
         var right_answer = ($('#right_answer' + id).prop("checked")) ? "1" : "0";
         var url = PROJ + `/${controller}/edit`;
         $.ajax({
            url: url,
            type: 'POST',
            data: ({action: 'aUpd', aid: id, apic: apic, atext: text, right_answer: right_answer}),
            cache: false,
         });
      }
      else if (action == "delete_a") {
         debugger;
         var url = PROJ + '/test/edit';
         $.ajax({
            url: url,
            type: 'POST',
            data: ({aid: id, qid: question_id, action: action}),
            cache: false,
            success: function (res) {
               if (+res > 1) {
                  if (confirm('Удалить ответ?')) {
                     $('#' + id).slideUp(200, function () {
                        $(this).remove()
                     });
                  }
               }
               else {
                  if (confirm('Это последний ответ для данного вопроса. Если его удалите, удалится и весь вопрос. Удалять?')) {
                     edit('delete_q_a', id, question_id);
                  }
                  else {
                     return;
                  }
               }
            },
            error: function () {
               alert('Ошибка при удалении');
            }
         });
      }
      else if (action == "delete_q_a") {
         var activePagination = +$('.pagination>a.nav-active ').text();
         $.ajax({
            url: PROJ + '/test/edit',
            type: 'POST',
            data: ({action: 'delete_q_a', aid: id, qid: question_id}),
            cache: false,
            success: function (res) {
               $('#' + question_id + 'q').parent().add('.pagination>a.nav-active ').slideUp(400, function () {
                  $(this).remove();
                  $('.pagination>a').each(function (index, elem) {// Пересчет номеров пагинации
                     index++
                     $(this).text('' + index);
                  });
               });
            },
            error: function () {
               alert('Ошибка при удалении');
            },
         });
      }
      else if (action == "del_a_q_pic") {

         $.ajax({
            url: `${PROJ}/${controller}/edit`,
            type: 'POST',
            data: ({action: 'aqPicDel', aid: id, qid: question_id}),
            cache: false,
            success: function (res) {
               $('#ima' + id).remove();
               $('#imq' + question_id).remove();
            },
            error: function () {
               alert('Ошибка при удалении');
            },
         });
      }


   }

   function check() {

      var holder = document.getElementsByClassName('holder'),
      tests = {
         filereader: typeof FileReader != 'undefined',
         dnd: 'draggable' in document.createElement('span'),
         formdata: !!window.FormData,
         progress: "upload" in new XMLHttpRequest
      },
      support = {
         filereader: document.querySelectorAll('.filereader'),
         formdata: document.querySelectorAll('.formdata'),
         progress: document.querySelectorAll('.progress')
      },
      acceptedTypes = {
         'image/png': true,
         'image/jpeg': true,
         'image/gif': true
      },
      progress = document.getElementById('uploadprogress'),
      fileupload = document.getElementById('upload'),
      message = "filereader formdata progress".split(' '); // преобразует строку в массив, разбив по сепаратору


      for (var key in message) { //(function (api) 
         if (tests[message[key]] === false) {
            support[message[key]].className = 'fail'; // присвоим класс 
         }
         else {
            collItem = support[message[key]];
            for (var key1 = 0; key1 < collItem.length; ++key1) {
               var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript
               item.className = 'hidden';
            }
         }
      }

      if (tests.dnd) {

         for (i = 0; i < holder.length; i++) {
            holder[i].ondragover = function () {
               this.className = 'hover';
               return false;
            };
            holder[i].ondragleave = function () {
               this.className = 'holder';
               return false;
            };
//        holder[i].ondragend = function () {
//            this.className = '';
//            return false;
//        };
            holder[i].ondrop = function (e) {
               this.className = 'holder';
               e.preventDefault();
               readfiles(e.dataTransfer.files, this);
            };
         }

      }
      else {
         fileupload.className = 'hidden'; // прячем кнопку загрузки
         fileupload.querySelector('input').onchange = function () {// загружаем файлы
            readfiles(this.files);
         };
      }

      function previewfile(file, elem) {
         if (tests.filereader === true && acceptedTypes[file.type] === true) {
            var imageContainer = elem, //document.querySelector('#'+fid+' [data-prefix = "'+pref+'"]');
            reader = new FileReader();
            reader.onload = function (event) {

               if (!imageContainer.getElementsByTagName('img').length == 0) {
                  var elem = imageContainer.getElementsByTagName('img')[0];
                  elem.remove();
               }
               var image = new Image();
               if (imageContainer.getAttribute('data-prefix') == 'q') {
                  image.id = 'imq' + imageContainer.getAttribute('id');
               }
               else if (imageContainer.getAttribute('data-prefix') == 'a') {
                  image.id = 'ima' + imageContainer.getAttribute('id');
               }
               image.src = event.target.result;
               image.width = 150; // a fake resize
               imageContainer.appendChild(image);
            };
            reader.readAsDataURL(file);
         }
         else {
            holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
            console.log(file);
         }
      }

      function readfiles(files, elem) {

         var formData = tests.formdata ? new FormData() : null;
         for (var i = 0; i < files.length; i++) {
            var pref = elem.getAttribute('data-prefix');
            var fid = elem.id;
            if (tests.formdata) {
               formData.append('file', files[i]);
//window.alert( files[i]['name']);
               previewfile(files[i], elem);
            }
         }
         formData.append('pref', pref);
         formData.append('fid', fid);
// now post a new XHR request
         if (tests.formdata) {
            var xhr = new XMLHttpRequest(),
            controller = 'test';
            if (window.location.pathname.indexOf('freetest') + 1) {
               controller = 'freetest';
            }
            xhr.open('POST', `${PROJ}/${controller}/edit`, true);
            xhr.send(formData);
            xhr.onreadystatechange = function () {
               if (xhr.readyState != 4) {
                  return
               }
               if (xhr.status != 200) {
                  alert(xhr.status + ': Ошибка' + xhr.statusText); // пример вывода: 404: Not Found
               }
            }
         }
      }

   }


   check();

}
function up() {
   var top = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
   if (top > 0) {
      window.scrollBy(0, -100);
      var t = setTimeout('up()', 20);
   }
   else
      clearTimeout(t);
   return false;
}
function check() {

   var holder = document.getElementsByClassName('holder'),
   tests = {
      filereader: typeof FileReader != 'undefined',
      dnd: 'draggable' in document.createElement('span'),
      formdata: !!window.FormData,
      progress: "upload" in new XMLHttpRequest
   },
   support = {
      filereader: document.querySelectorAll('.filereader'),
      formdata: document.querySelectorAll('.formdata'),
      progress: document.querySelectorAll('.progress')
   },
   acceptedTypes = {
      'image/png': true,
      'image/jpeg': true,
      'image/gif': true
   },
   progress = document.getElementById('uploadprogress'),
   fileupload = document.getElementById('upload'),
   message = "filereader formdata progress".split(' '); // преобразует строку в массив, разбив по сепаратору


   for (var key in message) { //(function (api) 
      if (tests[message[key]] === false) {
         support[message[key]].className = 'fail'; // присвоим класс 
      }
      else {
         collItem = support[message[key]];
         for (var key1 = 0; key1 < collItem.length; ++key1) {
            var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript
            item.className = 'hidden';
         }
      }
   }

   if (tests.dnd) {

      for (i = 0; i < holder.length; i++) {
         holder[i].ondragover = function () {
            this.className = 'hover';
            return false;
         };
         holder[i].ondragleave = function () {
            this.className = 'holder';
            return false;
         };
//        holder[i].ondragend = function () {
//            this.className = '';
//            return false;
//        };
         holder[i].ondrop = function (e) {
            this.className = 'holder';
            e.preventDefault();
            readfiles(e.dataTransfer.files, this);
         };
      }

   }
   else {
      fileupload.className = 'hidden'; // прячем кнопку загрузки
      fileupload.querySelector('input').onchange = function () {// загружаем файлы
         readfiles(this.files);
      };
   }

   function previewfile(file, elem) {
      if (tests.filereader === true && acceptedTypes[file.type] === true) {
         var imageContainer = elem, //document.querySelector('#'+fid+' [data-prefix = "'+pref+'"]');
         reader = new FileReader();
         reader.onload = function (event) {

            if (!imageContainer.getElementsByTagName('img').length == 0) {
               var elem = imageContainer.getElementsByTagName('img')[0];
               elem.remove();
            }
            var image = new Image();
            if (imageContainer.getAttribute('data-prefix') == 'q') {
               image.id = 'imq' + imageContainer.getAttribute('id');
            }
            else if (imageContainer.getAttribute('data-prefix') == 'a') {
               image.id = 'ima' + imageContainer.getAttribute('id');
            }
            image.src = event.target.result;
            image.width = 150; // a fake resize
            imageContainer.appendChild(image);
         };
         reader.readAsDataURL(file);
      }
      else {
         holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
         console.log(file);
      }
   }

   function readfiles(files, elem) {

      var formData = tests.formdata ? new FormData() : null;
      for (var i = 0; i < files.length; i++) {
         var pref = elem.getAttribute('data-prefix');
         var fid = elem.id;
         if (tests.formdata) {
            formData.append('file', files[i]);
//window.alert( files[i]['name']);
            previewfile(files[i], elem);
         }
      }
      formData.append('pref', pref);
      formData.append('fid', fid);
// now post a new XHR request
      if (tests.formdata) {
         var xhr = new XMLHttpRequest(),
         controller = 'test';
         if (window.location.pathname.indexOf('freetest') + 1) {
            controller = 'freetest';
         }
         xhr.open('POST', `${PROJ}/${controller}/edit`, true);
         xhr.send(formData);
         xhr.onreadystatechange = function () {
            if (xhr.readyState != 4) {
               return
            }
            if (xhr.status != 200) {
               alert(xhr.status + ': Ошибка' + xhr.statusText); // пример вывода: 404: Not Found
            }
         }
      }
   }

}

function edit(action, id, question_id, test_id, test_name) {
   var controller = 'test';
//        debugger;
   if (window.location.pathname.indexOf('freetest') + 1) {
      controller = 'freetest';
   }
   if (action == "save_q") {
      var qpic = $('#imq[data-id = "' + question_id + '"]').attr('src'),
      text = $.trim($('textarea[name = "' + question_id + 'q"]').val()),
      sort = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
      k_word = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
      data = ({action: 'qUpd', data, qid: question_id, qpic: qpic, qtext: text, sort: sort}),
      url = `${PROJ}/${controller}/edit`;
      $.ajax({
         url: url,
         type: 'POST',
         data: data,
      });
   }
   else if (action == "save_a") {
      var apic = $('#ima[data-id = "' + id + '"]').attr('src');
      var text = $.trim($('textarea[name = ' + id + ']').val());
      var right_answer = ($('#right_answer' + id).prop("checked")) ? "1" : "0";
      var url = PROJ + `/${controller}/edit`;
      $.ajax({
         url: url,
         type: 'POST',
         data: ({action: 'aUpd', aid: id, apic: apic, atext: text, right_answer: right_answer}),
         cache: false,
      });
   }
   else if (action == "delete_a") {
      debugger;
      var url = PROJ + '/test/edit';
      $.ajax({
         url: url,
         type: 'POST',
         data: ({aid: id, qid: question_id, action: action}),
         cache: false,
         success: function (res) {
            if (+res > 1) {
               if (confirm('Удалить ответ?')) {
                  $('#' + id).slideUp(200, function () {
                     $(this).remove()
                  });
               }
            }
            else {
               if (confirm('Это последний ответ для данного вопроса. Если его удалите, удалится и весь вопрос. Удалять?')) {
                  edit('delete_q_a', id, question_id);
               }
               else {
                  return;
               }
            }
         },
         error: function () {
            alert('Ошибка при удалении');
         }
      });
   }
   else if (action == "delete_q_a") {
      var activePagination = +$('.pagination>a.nav-active ').text();
      $.ajax({
         url: PROJ + '/test/edit',
         type: 'POST',
         data: ({action: 'delete_q_a', aid: id, qid: question_id}),
         cache: false,
         success: function (res) {
            $('#' + question_id + 'q').parent().add('.pagination>a.nav-active ').slideUp(400, function () {
               $(this).remove();
               $('.pagination>a').each(function (index, elem) {// Пересчет номеров пагинации
                  index++
                  $(this).text('' + index);
               });
            });
         },
         error: function () {
            alert('Ошибка при удалении');
         },
      });
   }
   else if (action == "del_a_q_pic") {

      $.ajax({
         url: `${PROJ}/${controller}/edit`,
         type: 'POST',
         data: ({action: 'aqPicDel', aid: id, qid: question_id}),
         cache: false,
         success: function (res) {
            $('#ima' + id).remove();
            $('#imq' + question_id).remove();
         },
         error: function () {
            alert('Ошибка при удалении');
         },
      });
   }


}
