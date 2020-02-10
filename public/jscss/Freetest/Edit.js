window.onload = function () {



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
            if (link!='#') {
            $(link).fadeIn(100);
            }
         });
      }
      else {
         $(link).fadeIn(100);
      }
      return false;
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
   

/////////////////////////////////////////////////////////////////////////////
/////////// RESULTS FREETEST , показать результаты /////////////////////////////
/////////////////////////////////////////////////////////////////////////////

//   $('.content').on('click', '#finish-freetest', function (event) {
//      event.preventDefault();
//      var button = document.querySelector('#finish-freetest');
//      if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
//         location.reload();
//         return;
//      }
//
//      var data = {action: 'resultFreetest'};
//
//      post(PROJ + '/freetest/do', data)
//      .then(function (val) {
//
//         debugger;
//         return colorView(JSON.parse(val))
//      })
//      .then(function (errorCnt) {
//         debugger;
//         return sendMailResults(errorCnt)
//      })
//      .then(function (data) {
//         debugger;
//         return post(PROJ + '/freetest/do', data)
//      });
//
//
//
//
//      function colorView(obj) {
//         return new Promise(function (resolve, reject) {
//            var green = 'rgb(0, 255, 41) 0px 2px 11px 3px', //'#e5f7d0',
//            bxShdRed = 'rgb(255, 41, 41) 0px 2px 11px 3px',
//            textarea = document.querySelectorAll('.freetest-text-editable');
//            textarea.forEach(function (elem, tindex, textarea) { // перебираем txtarea
//               var text = elem.innerHTML;
//               if (text) {
//                  var textareaId = elem.dataset.textarea,
//                  paginItem = document.querySelectorAll('a[href="#question-' + textareaId + '"]')[0],
//                  objArr = obj[textareaId],
//                  objArr = objArr.split(',');
//                  for (var i in objArr) {
//                     var our_string = objArr[i],
//                     reg = new RegExp(our_string, 'g');
//                     if (reg.test(text)) {
//                        elem.innerHTML = elem.innerHTML.replace(reg, "<span style ='color:green;font-weight:800'> " + our_string + "</span>");
//                        paginItem.style.boxShadow = green; // greennew RegExp(our_string, 'g')
//                     }
//                  }
//               }
//            })
//            var btn = document.getElementById("finish-freetest");
//            btn.href = location.href, //"?test="+testId;
//            btn.text = "ПРОЙТИ ТЕСТ ЗАНОВО",
//            errorsCnt = 0,
//// Правильные ответы зеленым
//            a = document.querySelectorAll("a[href^='#question-']");
//            for (var i = 0; i < a.length; i++) {
//               if (a[i].style.boxShadow != green) {// Если не красный, раскрасим в зеленый
//                  a[i].style.boxShadow = bxShdRed;
//                  errorsCnt++;
//               }
//            }
//            resolve(errorsCnt);
//         }
//         );
//      }
//
//
//
//
//      function sendMailResults(errorCnt) {
//         return new Promise(function (resolve, reject) {
//            var doctypeHtml = "<!DOCTYPE " + document.doctype.name + '>',
//            pageCache = doctypeHtml + document.documentElement.outerHTML,
//            url = PROJ + '/freetest/do';
//            var testId = +button.dataset.id;
//            var test_name = $('.test-name').text();
//            var name = $('.user-button span').text();
//            var userAnswers = {};
//            $('.question').each(function (index, element) {
//               var id = $(this).data('id'),
//               textarea = element.lastElementChild.innerText;
//               userAnswers[id] = textarea; // Сохраним в массиве под уникальным номером
//            });
//
//            var data = {
//               errorCnt: errorCnt,
//               pageCache: pageCache,
//               action: 'send_mail_Freetest',
//               userAnswers: userAnswers,
//               testId: testId,
//               name: name,
//               test_name: test_name
//            };
//
//            resolve(data);
//         });
//      }
//
//
//   });


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
};