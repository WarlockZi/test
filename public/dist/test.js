/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./public/src/Test/do.js":
/*!*******************************!*\
  !*** ./public/src/Test/do.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _do_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./do.scss */ "./public/src/Test/do.scss");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");



 //Скрыть все вопросы

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').removeClass("flex1"); //Показть первый вопрос

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question:first-child').addClass("flex1");
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[type="checkbox"]').on('click', function (e) {
  let a = e.target.labels[0];
  a.classList.toggle('pushed');
}); /////////////////////////////////////////////////////////////////////////////
///////////  RESULTS  TEST  Закончить тест/////////////////////////////
/////////////////////////////////////////////////////////////////////////////

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.content').on('click', async function (e) {
  let button = e.target;

  if (button.id === 'btnn') {
    if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }

    let corrAnswers = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/test/getCorrectAnswers', {});
    corrAnswers = JSON.parse(corrAnswers);
    let errorCnt = colorView(corrAnswers);
    let data = objToServer(errorCnt);
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/test/cachePageSendEmail', data);

    if (res) {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#btnn").el[0].href = location.href; //"?test="+testId

      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#btnn").el[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО"; //"?test="+testId
    }
  }
});

function colorView(correctAnswers) {
  let q = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').el;
  Array.from(q).map((question, i) => {
    let answers = question.querySelectorAll('.a'),
        errors = [];
    Array.from(answers).map(answer => {
      let input = answer.getElementsByTagName('input')[0],
          answerId = input.id.replace("answer-", ""),
          // id question
      label = answer.getElementsByTagName('label')[0],
          // Чтобы прикрепить зеленый значек к этому элементу
      correctAnser = correctAnswers.indexOf(answerId) !== -1;

      if (!checkCorrectAnswers(correctAnser, input, label)) {
        errors.push(true);
      }
    });
    let questId = +question.dataset['id'],
        // id question
    paginItem = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.pagination [data-pagination="' + questId + '"]').el[0];

    if (errors.length) {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(paginItem).addClass('redShadow');
    } else {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(paginItem).addClass('greenShadow');
    }
  });
  return (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.redShadow').el.length;
}

function checkCorrectAnswers(correctAnser, input, label) {
  if (input.checked && correctAnser) {
    // checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
    label.classList.add('done'); //green check зеленый значек

    return true;
  } else if (input.checked && !correctAnser) {
    // checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
    return false;
  } else if (!input.checked && correctAnser) {
    // кнопка не нажата, в correct_answers есть
    label.classList.add('done'); //green check зеленый значек

    label.classList.add('done'); // green check зеленый значек

    return false;
  } else if (!input.checked && !correctAnser) {
    // кнопка не нажата, в correct_answers нет
    return true;
  }
}

function objToServer(errorCnt) {
  return {
    token: document.querySelector('meta[name="token"]').getAttribute('content'),
    questionCnt: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').el.length,
    errorCnt: errorCnt,
    pageCache: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
    testId: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[data-test-id]').el[0].dataset.testId,
    test_name: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].innerText,
    userName: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.user-menu__FIO').el[0].innerText
  };
}

/***/ }),

/***/ "./public/src/Test/edit.js":
/*!*********************************!*\
  !*** ./public/src/Test/edit.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "aDelete": () => (/* binding */ aDelete),
/* harmony export */   "aAdd": () => (/* binding */ aAdd),
/* harmony export */   "qDelete": () => (/* binding */ qDelete),
/* harmony export */   "getQuestion": () => (/* binding */ getQuestion),
/* harmony export */   "getAnswers": () => (/* binding */ getAnswers)
/* harmony export */ });
/* harmony import */ var _edit_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit.scss */ "./public/src/Test/edit.scss");
/* harmony import */ var _components_popup_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/popup.scss */ "./public/src/components/popup.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _components_dnd_dnd__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/dnd/dnd */ "./public/src/components/dnd/dnd.js");




if (typeof (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.test_delete').el[0] !== 'undefined') new _common__WEBPACK_IMPORTED_MODULE_2__.test_delete((0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.test_delete').el[0]); /// class active для admin_main_menu

if (window.location.pathname.match('/adminsc\/test/')) {
  document.querySelector('.module.test').classList.add('activ');
}

(0,_components_dnd_dnd__WEBPACK_IMPORTED_MODULE_3__.check)('/image/create'); //Скрыть все вопросы

(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.block').removeClass("flex1"); //Показть первый вопрос

(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.block:first-child').addClass("flex1");
(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.a-add').on('click', aAdd);
(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.q-delete').on('click', qDelete);
(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.a-del').on('click', aDelete);
async function aDelete(e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(e.target).hasClass('a-del')) {
    if (confirm("Удалить этот ответ?")) {
      let a_id = +e.target.closest('.e-block-a').id;
      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_2__.post)('/answer/delete', {
        a_id
      });
      res = JSON.parse(res);

      if (res.msg === 'ok') {
        let f = e.target.closest('.e-block-a');
        f.remove();
        _common__WEBPACK_IMPORTED_MODULE_2__.popup.show('Ответ удален');
      }
    }
  }
}
async function aAdd(e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(e.target).hasClass('a-add')) {
    let q_id = +e.target.closest('.e-block-q').id;
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_2__.post)('/answer/show', {
      q_id
    });
    let visibleBlock = (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.block.flex1').el[0];
    (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(visibleBlock).find('.answers').insertAdjacentHTML('beforeend', res);
    let newAnswer = (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(visibleBlock).find('.e-block-a:last-child');
    (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(newAnswer).css('background-color', 'pink');
    setTimeout(function () {
      (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(newAnswer).css('background-color', 'white');
    }, 400);
    (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(newAnswer).on('click', aDelete);
  }
}
async function qDelete(e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(e.target).hasClass('q-delete')) {
    if (confirm("Удалить вопрос со всеми его ответами?")) {
      let q_id = +e.target.closest('.e-block-q').id;
      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_2__.post)('/question/delete', {
        q_id
      });
      res = JSON.parse(res);

      if (res.msg === 'ok') {
        let block = e.target.closest('.block');
        block.remove();
        (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(`[data-pagination = "${res.q_id}"]`).el[0].remove();
        (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('[data-pagination]:first-child').addClass('nav-active');
        (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.block:first-child').addClass('flex1');
      }
    }
  }
} ///// question sort input validate

(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.sort-q').on('change', _common__WEBPACK_IMPORTED_MODULE_2__.validate.sort); ////////// Update

(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.blocks').on('click', async function (e) {
  if (e.target.classList.contains('question__save')) {
    let visibleBlock = (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.block.flex1').el[0]; // let q = $(visibleBlock).find('.e-block-q')
    // let a = $(visibleBlock).find('.e-block-a')

    let question = getQuestion(e, visibleBlock);
    let answers = getAnswers(e, visibleBlock, question.id);
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_2__.post)('/question/update', {
      question,
      answers
    });
    res = JSON.parse(res);

    if (res) {
      _common__WEBPACK_IMPORTED_MODULE_2__.popup.show(res.msg);
    }
  }
});
function getQuestion(e, block) {
  return {
    id: +e.target.dataset['qid'],
    parent: +(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.test-name').el[0].getAttribute('value'),
    picq: '',
    qustion: (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(block).find('textarea').value,
    sort: +(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(block).find('.question__sort').value
  };
}
function getAnswers(e, block, q_id) {
  let answerBlocks = block.querySelectorAll('.e-block-a');
  let answers = [];
  answerBlocks.forEach(a => {
    answers.push({
      id: +a.querySelector('.checkbox').dataset['answer'],
      answer: a.querySelector('textarea').value,
      correct_answer: +a.querySelector('.checkbox').checked,
      parent_question: +q_id,
      pica: ''
    });
  }, q_id);
  return answers;
} //
// window.onload = function () {
//
//
// //////////////////////////////// Параметры теста///////////////
//
// // Открываем панель параметров теста
//    $('body').on('click', ".add-test, .test-params", function () {
// // Если форма открытa, закроем ее
// //debugger;
//       if (document.querySelector('.testParamsBorder')) {
//          $('.testParamsBorder').remove();
//       }
//       var testId = $(this).data('testid');
// //      var data = {testId: testId, action: 'testParams'};
// //      data = 'param=' + JSON.stringify(data);
//
//       $.ajax({
//          url: PROJ + '/test/edit',
//          type: 'POST',
//          data: ({testId: testId, action: 'testParams'}),
//          success: function (res) {
//             $('.wrap').after(res);
//             $('.overlay').add('.testParamsBorder').fadeIn();
//          }
//       });
//    });
// // Удалить тест
//    $('body').on('click', '#TestParamsDEL', function () {
//
//       var testId = +$('.testId').text();
//       $.ajax({
//          url: PROJ + '/test/edit',
//          type: 'POST',
//          data: ({tId: testId, action: 'tDel'}),
//          cache: false,
//          success: function (res) {
//             if (confirm('Удалить тест?')) {
//                $('.testParamsBorder').hide(100, function () {
//                   $(this).remove();
//                   $('body .test-params[data-testid =' + testId + ']').parent().add('.overlay').remove();
//                });
// // Удаляем из второго меню тест
//                $('[href="/test/edit/' + testId + '"]').parent().remove();
//             }
//
//          },
//          error: function () {
//             alert('Тест не удалился.');
//          }
//       });
//    });
// // Кнопка "Отмена"  - не сохранять параметры теста
//    $('body').on('click', '#saveTestParmsCansel, .overlay', function () {
//       $('.testParamsBorder').add('.overlay').fadeOut(400, function () {
//          $(this).remove();
//       });
//    });
// // Кнопака "ОК"  - сохранить параметры теста/Добавить новый тест
//    $('body').on('click', '#saveTestParamsOK', function () {
//       var testId = +$('.testId').text(),
//       testName = $('#saveTestName').val(),
//       parentTest = +$('#selectParenTest option:selected').val(),
//       isTest = +$('#isTest option:selected').val(),
//       sort = +$('.sort input').val(),
//       enable = $('input[data-test-id]').prop("checked") ? 1 : 0;
//       if ($('input[data-test-id]').prop("checked"))
//          var enable = 1;
//       else
//          var enable = 0;
//
//       if (testId) { // Редактируем существующий тест
//          $.ajax({
//             url: PROJ + '/test/edit',
//             type: 'POST',
//             data: ({action: 'tUpd', testId: testId, testName: testName, parentTest: parentTest, isTest: isTest, sort: sort, enable: enable}),
//             cache: false,
//             success: function (res) {
//                if (res) {
//
//                   $('a[href="' + PROJ + '/edit/' + testId + '"]').text(res);
//                   $('.test-name').text('Тест - ' + res);
//                   $('.testParamsBorder').add('.overlay').hide(100, function () {
//                      $(this).remove()
//                   });
//                }
//                else {
//                   window.alert('Заполнитe название');
//                }
//             },
//             error: function () {
//                window.alert("Обновление не прошло");
//             }
//          });
//       }
//       else { // Создаем новый тест
//          if (testName) {
//             $.ajax({
//                url: PROJ + '/test/edit',
//                type: 'POST',
//                data: ({action: 'tAdd', testId: testId, test_name: testName, parentTest: parentTest, isTest: isTest, sort: sort, enable: enable}),
//                success: function (res) {
//                   var obj = JSON.parse(res);
// // Если открыт тест и есть в DOM назв теста удаляем вопросы
//                   if (!$('.test-name')) {
//                      $('div.block').remove();
//                      $('.test-name').after(obj.answer);
//                      $('.test-name').after(obj.question);
// // Находимся в папке а не в тесте, поэтому контент добавляем
//                   }
//                   else {
// // Всатвляем все после контента
//                      var divTestName = '<p class="test-name" name = "test_id" value = "1">Тест - ' + obj.testName + '</p>' + obj.pagination + obj.question + obj.answer;
//                      $('.content').html(divTestName);
//                      $('.content .block').show();
//                   }
// // Закрываем рамку создания нового теста
//                   $('.testParamsBorder').add('.overlay').fadeOut(150);
// // Добавим пункты меню
//                   $('.menu').append(obj.menuItem);
//                },
//                error: function () {
//                }
//             });
//          }
//          else {
//             window.alert('Укажите название теста');
//             return;
//          }
//       }
//    });
// ///////////////////
//
// // Изменить сортировку Вопросов
//    $('body').on('change', "input[data-q-sort]", function () {
//       var qid = +$(this).data('q-sort');
//       edit("save_q", null, qid);
//    });
// // Textarea Вопрос
//    $('body').on('change', "textarea[data-question-id]", function () {
//       var qid = +$(this).data('question-id');
//       edit("save_q", null, qid); //,null,null,sort);
//    });
// // Textarea Ответ
//    $('body').on('change', "textarea[data-answer-id]", function () {
//       var id = $(this).data('answer-id');
//       edit("save_a", id);
//    });
// // Включить-выключить Checkbox Right Answer
//    $('body').on('change', "input[data-answer]", function () {
//       var id = $(this).data('answer');
//       edit("save_a", id);
//    });
//
//
//
// // Пагинация
//             $('.pagination>.nav-active').removeClass('nav-active').addClass('p-no-active'); // убираем активность
// //                alert(obj.menuItem);// Порядковый номер вопроса
//             $('.pagination>a:last').before(obj.pagination); // Добавить следующий пункт пагинации
//             $('.pagination>a:last').text('+'); // Порядковый номер вопроса
//
//             $('.block:visible').hide(); // Спрячем видимый блок
//             $('.block:last').after(obj.block); // Выведем новый блок
//             $('.content .block:last').show(200); //Покажем новый блок
//             check(0);
//          },
//          error: function () {
//             alert('Произошел сбой.');
//          }
//
//       });
//    });
// /////////////////////// Добавить О Т В Е Т   ///////////
//    $('body').on('click', '.add-answer', function () {
//       var qid = +$(this).data('id');
//       $.ajax({
//          url: PROJ + '/test/edit',
//          type: 'POST',
//          data: ({action: 'aAdd', qid: qid}),
//          cache: false,
//          success: function (res) {
//             var holder = document.querySelectorAll('.holder');
//             var a = $('.e-block-q[id = "' + qid + 'q"]').siblings(".e-block-a").last().after(res);
//             setTimeout(function () {
//                check(1);
//             }, 150);
//          },
//          error: function () {
//          }
//       });
//       check();
//    });
//
//
//
// //////////// Edit pagination
//    var prevActive = $('.pagination').find('.nav-active').attr('href');
//    $('.content').add('.test-data').find(prevActive).show();
// // Пагинация
//    $('.pagination').on('click', '.p-no-active', function () {
//       if ($(this).attr('class') == 'nav-active')
//          return false;
// // Сылка нажатой клавищи
//       var link = $(this).attr('href');
// // Ссылка активной клавиши
//       var prevActive = $('.pagination>a.nav-active ').attr('href');
// // C активной клавищи снимаем активность
//       $('.pagination>.nav-active').removeClass('nav-active').addClass('p-no-active');
// // Нажатой клавище добавляем активность
//       $(this).removeClass('p-no-active').addClass('nav-active');
//       if ($(prevActive) !== 0) {// Если удалили вопрос из DOM, его длинна будет 0 и следующий вопрос не покажется
//          $(prevActive).fadeOut(100, function () {
//             if (link != '#') {
//                $(link).fadeIn(100);
//             }
//          });
//       }
//       else {
//          $(link).fadeIn(100);
//       }
//       return false;
//    });
//
// /////////// Удалить картинку
//    $('body').on('click', ".pic-del", function () {
//       var a = $(this).data('a');
//       var q = $(this).data('q');
//       edit("del_a_q_pic", a, q);
//    });
// ////////////////////////////////// Функции ///////////////////////
//
//
//    function edit(action, id, question_id, test_id, test_name) {
//       var controller = 'test';
//       debugger;
//       if (window.location.pathname.indexOf('freetest') + 1) {
//          controller = 'freetest';
//       }
//       if (action == "save_q") {
//          var qpic = $('#imq[data-id = "' + question_id + '"]').attr('src'),
//          text = $.trim($('textarea[name = "' + question_id + 'q"]').val()),
//          sort = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
//          k_word = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
//          data = ({action: 'qUpd', data, qid: question_id, qpic: qpic, qtext: text, sort: sort}),
//          url = `${PROJ}/${controller}/edit`;
//          $.ajax({
//             url: url,
//             type: 'POST',
//             data: data,
//          });
//       }
//       else if (action == "save_a") {
//          var apic = $('#ima[data-id = "' + id + '"]').attr('src');
//          var text = $.trim($('textarea[name = ' + id + ']').val());
//          var right_answer = ($('#right_answer' + id).prop("checked")) ? "1" : "0";
//          var url = PROJ + `/${controller}/edit`;
//          $.ajax({
//             url: url,
//             type: 'POST',
//             data: ({action: 'aUpd', aid: id, apic: apic, atext: text, right_answer: right_answer}),
//             cache: false,
//          });
//       }
//       else if (action == "delete_a") {
//          //debugger;
//          var url = PROJ + '/test/edit';
//          $.ajax({
//             url: url,
//             type: 'POST',
//             data: ({aid: id, qid: question_id, action: action}),
//             cache: false,
//             success: function (res) {
//                if (+res > 1) {
//                   if (confirm('Удалить ответ?')) {
//                      $('#' + id).slideUp(200, function () {
//                         $(this).remove()
//                      });
//                   }
//                }
//                else {
//                   if (confirm('Это последний ответ для данного вопроса. Если его удалите, удалится и весь вопрос. Удалять?')) {
//                      edit('delete_q_a', id, question_id);
//                   }
//                   else {
//                      return;
//                   }
//                }
//             },
//             error: function () {
//                alert('Ошибка при удалении');
//             }
//          });
//       }
//       else if (action == "delete_q_a") {
//          var activePagination = +$('.pagination>a.nav-active ').text();
//          $.ajax({
//             url: PROJ + '/test/edit',
//             type: 'POST',
//             data: ({action: 'delete_q_a', aid: id, qid: question_id}),
//             cache: false,
//             success: function (res) {
//
//                $('#' + question_id + 'q').parent().add('.pagination>a.nav-active ').slideUp(400, function () {
//                   $(this).remove();
//                   $('.pagination>a').each(function (index, elem) {// Пересчет номеров пагинации
//                      index++
//                      $(this).text('' + index);
//                   });
//                });
//             },
//             error: function () {
//                alert('Ошибка при удалении');
//             },
//          });
//       }
//       else if (action == "del_a_q_pic") {
//
//          $.ajax({
//             url: `${PROJ}/${controller}/edit`,
//             type: 'POST',
//             data: ({action: 'aqPicDel', aid: id, qid: question_id}),
//             cache: false,
//             success: function (res) {
//                $('#ima' + id).remove();
//                $('#imq' + question_id).remove();
//             },
//             error: function () {
//                alert('Ошибка при удалении');
//             },
//          });
//       }
//
//
//    }
//
//    function check() {
//
//       var holder = document.getElementsByClassName('holder'),
//       tests = {
//          filereader: typeof FileReader != 'undefined',
//          dnd: 'draggable' in document.createElement('span'),
//          formdata: !!window.FormData,
//          progress: "upload" in new XMLHttpRequest
//       },
//       support = {
//          filereader: document.querySelectorAll('.filereader'),
//          formdata: document.querySelectorAll('.formdata'),
//          progress: document.querySelectorAll('.progress')
//       },
//       acceptedTypes = {
//          'image/png': true,
//          'image/jpeg': true,
//          'image/gif': true
//       },
//       progress = document.getElementById('uploadprogress'),
//       fileupload = document.getElementById('upload'),
//       message = "filereader formdata progress".split(' '); // преобразует строку в массив, разбив по сепаратору
//
//
//       for (var key in message) { //(function (api)
//          if (tests[message[key]] === false) {
//             support[message[key]].className = 'fail'; // присвоим класс
//          }
//          else {
//             collItem = support[message[key]];
//             for (var key1 = 0; key1 < collItem.length; ++key1) {
//                var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript
//                item.className = 'hidden';
//             }
//          }
//       }
//
//       if (tests.dnd) {
//
//          for (i = 0; i < holder.length; i++) {
//             holder[i].ondragover = function () {
//                this.className = 'hover';
//                return false;
//             };
//             holder[i].ondragleave = function () {
//                this.className = 'holder';
//                return false;
//             };
// //        holder[i].ondragend = function () {
// //            this.className = '';
// //            return false;
// //        };
//             holder[i].ondrop = function (e) {
//                this.className = 'holder';
//                e.preventDefault();
//                readfiles(e.dataTransfer.files, this);
//             };
//          }
//
//       }
//       else {
//          fileupload.className = 'hidden'; // прячем кнопку загрузки
//          fileupload.querySelector('input').onchange = function () {// загружаем файлы
//             readfiles(this.files);
//          };
//       }
//
//       function previewfile(file, elem) {
//          if (tests.filereader === true && acceptedTypes[file.type] === true) {
//             var imageContainer = elem, //document.querySelector('#'+fid+' [data-prefix = "'+pref+'"]');
//             reader = new FileReader();
//             reader.onload = function (event) {
//
//                if (!imageContainer.getElementsByTagName('img').length == 0) {
//                   var elem = imageContainer.getElementsByTagName('img')[0];
//                   elem.remove();
//                }
//                var image = new Image();
//                if (imageContainer.getAttribute('data-prefix') == 'q') {
//                   image.id = 'imq' + imageContainer.getAttribute('id');
//                }
//                else if (imageContainer.getAttribute('data-prefix') == 'a') {
//                   image.id = 'ima' + imageContainer.getAttribute('id');
//                }
//                image.src = event.target.result;
//                image.width = 150; // a fake resize
//                imageContainer.appendChild(image);
//             };
//             reader.readAsDataURL(file);
//          }
//          else {
//             holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
//             console.log(file);
//          }
//       }
//
//       function readfiles(files, elem) {
//
//          var formData = tests.formdata ? new FormData() : null;
//          for (var i = 0; i < files.length; i++) {
//             var pref = elem.getAttribute('data-prefix');
//             var fid = elem.id;
//             if (tests.formdata) {
//                formData.append('file', files[i]);
// //window.alert( files[i]['name']);
//                previewfile(files[i], elem);
//             }
//          }
//          formData.append('pref', pref);
//          formData.append('fid', fid);
// // now post a new XHR request
//          if (tests.formdata) {
//             var xhr = new XMLHttpRequest(),
//             controller = 'test';
//             if (window.location.pathname.indexOf('freetest') + 1) {
//                controller = 'freetest';
//             }
//             xhr.open('POST', `${PROJ}/${controller}/edit`, true);
//             xhr.send(formData);
//             xhr.onreadystatechange = function () {
//                if (xhr.readyState != 4) {
//                   return
//                }
//                if (xhr.status != 200) {
//                   alert(xhr.status + ': Ошибка' + xhr.statusText); // пример вывода: 404: Not Found
//                }
//             }
//          }
//       }
//
//    }
//
//
//    check();
//
// }
//    function readfiles(files, elem) {
//
//       var formData = tests.formdata ? new FormData() : null;
//       for (var i = 0; i < files.length; i++) {
//          var pref = elem.getAttribute('data-prefix');
//          var fid = elem.id;
//          if (tests.formdata) {
//             formData.append('file', files[i]);
// //window.alert( files[i]['name']);
//             previewfile(files[i], elem);
//          }
//       }
//       formData.append('pref', pref);
//       formData.append('fid', fid);
// // now post a new XHR request
//       if (tests.formdata) {
//          var xhr = new XMLHttpRequest(),
//          controller = 'test';
//          if (window.location.pathname.indexOf('freetest') + 1) {
//             controller = 'freetest';
//          }
//          xhr.open('POST', `${PROJ}/${controller}/edit`, true);
//          xhr.send(formData);
//          xhr.onreadystatechange = function () {
//             if (xhr.readyState != 4) {
//                return
//             }
//             if (xhr.status != 200) {
//                alert(xhr.status + ': Ошибка' + xhr.statusText); // пример вывода: 404: Not Found
//             }
//          }
//       }
//    }
//
// }
//
// function edit(action, id, question_id, test_id, test_name) {
//    var controller = 'test';
// //        debugger;
//    if (window.location.pathname.indexOf('freetest') + 1) {
//       controller = 'freetest';
//    }
//    if (action == "save_q") {
//       var qpic = $('#imq[data-id = "' + question_id + '"]').attr('src'),
//       text = $.trim($('textarea[name = "' + question_id + 'q"]').val()),
//       sort = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
//       k_word = $.trim($('input[data-q-sort = ' + question_id + ']').val()),
//       data = ({action: 'qUpd', data, qid: question_id, qpic: qpic, qtext: text, sort: sort}),
//       url = `${PROJ}/${controller}/edit`;
//       $.ajax({
//          url: url,
//          type: 'POST',
//          data: data,
//       });
//    }
//    else if (action == "save_a") {
//       var apic = $('#ima[data-id = "' + id + '"]').attr('src');
//       var text = $.trim($('textarea[name = ' + id + ']').val());
//       var right_answer = ($('#right_answer' + id).prop("checked")) ? "1" : "0";
//       var url = PROJ + `/${controller}/edit`;
//       $.ajax({
//          url: url,
//          type: 'POST',
//          data: ({action: 'aUpd', aid: id, apic: apic, atext: text, right_answer: right_answer}),
//          cache: false,
//       });
//    }
//    else if (action == "delete_a") {
//       //debugger;
//       var url = PROJ + '/test/edit';
//       $.ajax({
//          url: url,
//          type: 'POST',
//          data: ({aid: id, qid: question_id, action: action}),
//          cache: false,
//          success: function (res) {
//             if (+res > 1) {
//                if (confirm('Удалить ответ?')) {
//                   $('#' + id).slideUp(200, function () {
//                      $(this).remove()
//                   });
//                }
//             }
//             else {
//                if (confirm('Это последний ответ для данного вопроса. Если его удалите, удалится и весь вопрос. Удалять?')) {
//                   edit('delete_q_a', id, question_id);
//                }
//                else {
//                   return;
//                }
//             }
//          },
//          error: function () {
//             alert('Ошибка при удалении');
//          }
//       });
//    }
//    else if (action == "delete_q_a") {
//       var activePagination = +$('.pagination>a.nav-active ').text();
//       //debugger;
//       $.ajax({
//          url: PROJ + '/test/edit',
//          type: 'POST',
//          data: ({action: 'delete_q_a', aid: id, qid: question_id}),
//          cache: false,
//          success: function (res) {
//             $('#' + question_id + 'q').parent().add('.pagination>a.nav-active ').slideUp(400, function () {
//                $(this).remove();
//                var paginationACollection = $('.pagination>a');
//                var len = paginationACollection.length;
//                paginationACollection.each(function (index, elem) {// Пересчет номеров пагинации
//                   index++;
//                   if (index < len) {
//                      $(this).text('' + index);
//                   }
//                });
//                var paginItem = $('.pagination a:first').removeClass('p-no-active').addClass('nav-active');
//                var questId = paginItem[0].hash.replace('#question-', '');
//                $('#question-' + questId).show();
//             });
//          },
//          error: function () {
//             alert('Ошибка при удалении');
//          },
//       });
//    }
//    else if (action == "del_a_q_pic") {
//
//       $.ajax({
//          url: `${PROJ}/${controller}/edit`,
//          type: 'POST',
//          data: ({action: 'aqPicDel', aid: id, qid: question_id}),
//          cache: false,
//          success: function (res) {
//             $('#ima' + id).remove();
//             $('#imq' + question_id).remove();
//          },
//          error: function () {
//             alert('Ошибка при удалении');
//          },
//       });
//    }
//
// }
//
//
// function up() {
//    var top = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
//    if (top > 0) {
//       window.scrollBy(0, -100);
//       var t = setTimeout('up()', 20);
//    }
//    else
//       clearTimeout(t);
//    return false;
// }

/***/ }),

/***/ "./public/src/Test/show.js":
/*!*********************************!*\
  !*** ./public/src/Test/show.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _show_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./show.scss */ "./public/src/Test/show.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../common */ "./public/src/common.js");


(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".save-test").on('click', async function () {
  let test_name = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#test_name').el[0].innerText;
  let enable = 1;
  let sel = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('select').el[0];
  let isTest = +!(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#isPath').el[0].checked;
  let sort = 0;
  let parent = sel.options[sel.selectedIndex].value;
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/test/create', {
    test_name,
    enable,
    isTest,
    sort,
    parent
  });
  res = await JSON.parse(res);

  if (res) {
    window.location.href = `/adminsc/test/edit/${res.id}` + '?id=' + res.id + '&name=' + test_name;
  }
});

/***/ }),

/***/ "./public/src/common.js":
/*!******************************!*\
  !*** ./public/src/common.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "popup": () => (/* binding */ popup),
/* harmony export */   "test_delete": () => (/* binding */ test_delete),
/* harmony export */   "post": () => (/* binding */ post),
/* harmony export */   "get": () => (/* binding */ get),
/* harmony export */   "uniq": () => (/* binding */ uniq),
/* harmony export */   "validate": () => (/* binding */ validate),
/* harmony export */   "$": () => (/* binding */ $),
/* harmony export */   "fetchWrap": () => (/* binding */ fetchWrap),
/* harmony export */   "fetchW": () => (/* binding */ fetchW)
/* harmony export */ });
let validate = {
  sort: function () {
    let error = this.nextElementSibling;
    let ar = this.value.match(/\D+/);

    if (ar) {
      error.innerText = 'Только цифры';
      error.style.opacity = '1';
    } else {
      if (error.style.opacity === "1") {
        error.style.opacity = '0';
      }
    }
  },
  email: function (email) {
    if (!email) return false;
    let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  },
  password: function (password) {
    if (!password) return false;
    let re = /^[a-zA-Z\-0-9]{6,20}$/;
    return re.test(password);
  }
};

function clearCache() {
  async function clearCache() {
    let response = await fetch('/adminsc/clearCache');
    let result = await response.text();
  }

  clearCache().catch(alert);
}

let popup = {
  show: function (txt) {
    let close = this.el('div', 'popup__close');
    close.innerText = 'X';
    let popup__item = this.el('div', 'popup__item');
    popup__item.innerText = txt;
    popup__item.append(close);
    let popup = $('.popup').el[0];

    if (!popup) {
      popup = this.el('div', 'popup');
    }

    popup.append(popup__item);
    popup.addEventListener('click', this.close);
    document.body.append(popup);
    popup.style.position = 'sticky';
  },
  close: function (e) {
    if (e.target.classList.contains('popup__close')) {
      let popup = this.closest('.popup').remove();
    }
  },
  el: function (tagName, className) {
    let el = document.createElement(tagName);
    el.classList.add(className);
    return el;
  }
};

const uniq = array => Array.from(new Set(array));

async function get(key) {
  let p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}

async function post(url, data) {
  //      debugger;
  return new Promise(function (resolve, reject) {
    data.token = document.querySelector('meta[name="token"]').getAttribute('content');
    let req = new XMLHttpRequest();
    req.open('POST', url, true);
    req.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    if (data instanceof FormData) {
      req.send(data);
    } else {
      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      req.send('param=' + JSON.stringify(data));
    }

    req.onerror = function () {
      reject(Error("Network Error"));
    };

    req.onload = function () {
      resolve(req.response);
    };
  });
}

function MyJquery(elements) {
  this.el = elements;
  this.elType = {}.toString.call(elements);

  this.on = function (ev, f) {
    if (this.elType === "[object HTMLDivElement]") {
      this.el.addEventListener(ev, f);
    }

    if (this.elType === "[object NodeList]") {
      elements.forEach(s => s.addEventListener(ev, f));
    }
  };

  this.value = function () {
    return this.el[0].getAttribute('value');
  };

  this.count = function () {
    return this.el.length;
  };

  this.getWithStyle = function (attr, val) {
    let arr = [];
    elements.forEach(s => {
      if (s.style[attr] === val) {
        arr.push(s);
      }
    });
    return arr;
  };

  this.addClass = function (className) {
    if (this.elType === "[object HTMLDivElement]") {
      this.el.classList.add(className);
    }

    if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
      this.el.forEach(s => {
        s.classList.add(className);
      });
    }
  };

  this.removeClass = function (className) {
    this.el.forEach(s => {
      s.classList.remove(className);
    });
  };

  this.hasClass = function (className) {
    if (this.el.classList.contains(className)) return true;
  };

  this.append = function (el) {
    this.el[0].appendChild(el);
  };

  this.find = function (selector) {
    if (["[object HTMLDivElement]", "[object HTMLInputElement]"].includes(this.elType)) {
      return this.el.querySelector(selector);
    }

    if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
      return this.el[0].querySelector(selector);
    }
  };

  this.css = function (attr, val) {
    if (!val) {
      return this.el[0].style[attr];
    }

    if (this.elType === "[object HTMLDivElement]") {
      this.el.style[attr] = val;
    }

    if (this.elType === "[object NodeList]") {
      elements.forEach(s => {
        s.style[attr] = val;
      });
    }
  };
}

function $(selector) {
  let elements = '';

  if (typeof selector === "string") {
    elements = document.querySelectorAll(selector);
  } else {
    elements = selector;
  }

  return new MyJquery(elements);
}

class test_delete {
  constructor(elem) {
    this._elem = elem;
    elem.onclick = this.onClick.bind(this); // (*)

    elem.onmouseenter = this.showToolip;
    elem.onmouseleave = this.hideTooltip;
    elem.onmousemove = this.changeTooltipPos;
  }

  async delete() {
    if (confirm('Удалить тест?')) {
      let id = $('.test-name').value();
      let res = await post('/test/delete', {
        id: id
      });
      res = JSON.parse(res);

      if (res.msg === 'ok') {
        window.location = '/test/edit';
      }
    }
  }

  changeTooltipPos(e) {
    this.tip.style.top = e.pageY + 35 + 'px';
    this.tip.style.left = e.pageX - 170 + 'px';
  }

  hideTooltip() {
    this.tip.remove();
  }

  showToolip(e) {
    let x = e.clientX;
    let y = e.clientY;
    let tip = document.createElement('div');
    $(tip).addClass('tip');
    tip.style.top = y + 70 + 'px';
    tip.style.left = x - 170 + 'px';
    tip.innerText = this.getAttribute('tip');
    this.tip = tip;
    document.body.append(tip);
  }

  onClick(event) {
    let action = event.target.closest('.test_delete').dataset['click'];

    if (action) {
      this[action]();
    }
  }

}

async function fetchWrap(Obj, file) {
  let data = new FormData();
  data.append('ajax', true);
  data.append('param', JSON.stringify(Obj));
  file ? data.append('file', file) : '';
  let prom = await fetch(`/adminsc`, {
    body: data,
    method: 'post'
  });
  return prom.text();
}

async function fetchW(url, Obj) {
  let prom = await fetch(url, {
    body: 'param=' + JSON.stringify(Obj),
    method: 'post',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest'
    }
  });
  return prom;
}



/***/ }),

/***/ "./public/src/components/cookie/cookie.js":
/*!************************************************!*\
  !*** ./public/src/components/cookie/cookie.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _cookie_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cookie.scss */ "./public/src/components/cookie/cookie.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");


check_cookie('cn');

function check_cookie(cookie_name) {
  if (getCookie(cookie_name)) (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cookie-notice').css('bottom', '-100%');else (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cookie-notice').css('bottom', "0");
}

function getCookie(cookie_name) {
  return document.cookie.match('(^|;)?' + cookie_name + '=([^;]*)');
}

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cn-accept-cookie').on('click', clicked);

function clicked() {
  setCookie();
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cookie-notice').css('bottom', '-100%');
}

function setCookie() {
  const date = new Date(),
        minute = 60 * 1000,
        day = minute * 60 * 24;
  let days = 1;
  date.setTime(date.getTime() + days * day);
  document.cookie = "cn=1; expires=" + date + "path=/; SameSite=lax";
}

/***/ }),

/***/ "./public/src/components/dnd/dnd.js":
/*!******************************************!*\
  !*** ./public/src/components/dnd/dnd.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "check": () => (/* binding */ check)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _dnd_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dnd.scss */ "./public/src/components/dnd/dnd.scss");


function check(url) {
  let holder = document.getElementsByClassName('holder'),
      tests = {
    filereader: typeof FileReader != 'undefined',
    dnd: 'draggable' in document.createElement('span'),
    formdata: !!window.FormData,
    progress: "upload" in new XMLHttpRequest()
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

  for (var key in message) {
    //(function (api)
    if (tests[message[key]] === false) {
      support[message[key]].className = 'fail'; // присвоим класс
    } else {
      let collItem = support[message[key]];

      for (var key1 = 0; key1 < collItem.length; ++key1) {
        var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript

        item.className = 'hidden';
      }
    }
  }

  if (tests.dnd) {
    for (let i = 0; i < holder.length; i++) {
      holder[i].ondragover = function () {
        this.className = 'hover';
        this.style.width = '234px';
        this.style.height = '162px';
        return false;
      };

      holder[i].ondragleave = function () {
        this.className = 'holder';
        return false;
      };

      holder[i].ondragend = function () {
        this.className = '';
        return false;
      };

      holder[i].ondrop = function (e) {
        this.className = 'holder';
        e.preventDefault();
        readfiles(e.dataTransfer.files, this);
      };
    }
  } else {
    fileupload.className = 'hidden'; // прячем кнопку загрузки

    fileupload.querySelector('input').onchange = function () {
      // загружаем файлы
      readfiles(this.files);
    };
  }

  function previewfile(file, elem) {
    if (tests.filereader === true && acceptedTypes[file.type] === true) {
      var imageContainer = elem,
          //document.querySelector('#'+fid+' [data-prefix = "'+pref+'"]');
      reader = new FileReader();

      reader.onload = function (event) {
        if (imageContainer.getElementsByTagName('img').length) {
          var elem = imageContainer.getElementsByTagName('img')[0];
          elem.remove();
        }

        var image = new Image();

        if (imageContainer.getAttribute('data-prefix') === 'q') {
          image.id = 'imq' + imageContainer.getAttribute('id');
        } else if (imageContainer.getAttribute('data-prefix') === 'a') {
          image.id = 'ima' + imageContainer.getAttribute('id');
        }

        image.src = event.target.result; // image.width = 150; // a fake resize

        imageContainer.appendChild(image);
      };

      reader.readAsDataURL(file);
    } else {
      holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
      console.log(file);
    }
  }

  async function readfiles(files, elem) {
    let formData = new FormData();

    for (var i = 0; i < files.length; i++) {
      formData.append('file', files[i], files[i]['name']);
      formData.append('type', elem.dataset['prefix']);
      formData.append('typeId', elem.id);
      previewfile(files[i], elem);
    }

    let res = await fetch(url, {
      method: 'POST',
      body: formData
    }); // let res = await post(url, formData)
    // if (res) {
    //     alert(res)
    // }
  }
}

/***/ }),

/***/ "./public/src/components/header/autocomplete.js":
/*!******************************************************!*\
  !*** ./public/src/components/header/autocomplete.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _autocomplete_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./autocomplete.scss */ "./public/src/components/header/autocomplete.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");


let inp = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("#autocomplete").el;
Array.from(inp).map(inp => {
  if (inp) {
    inp.addEventListener('input', function () {
      autocomplete(this.value, inp);
    });
  }
});

async function fetchJson(Input) {
  let response = await fetch('/search?q=' + Input);
  return await response.json();
}

function decorate(content, tag) {
  let el = document.createElement(tag);
  el.appendChild(content);
  return el;
}

async function autocomplete(val, inp) {
  if (val.length < 1) {
    result.innerHTML = '';
    return;
  }

  let data = await fetchJson(val);
  let ul = document.createElement('ul');
  let lis = data.map(e => {
    let a = document.createElement("a");
    a.href = e.alias;
    a.innerHTML = `<img src='/pic/${e.preview_pic}' alt='${e.name}'>` + e.name;
    ul.appendChild(decorate(a, 'li'));
  });
  let result = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(inp.parentNode).find('.search__result');
  result.appendChild(ul);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('body').on('click', function (e) {
    const search = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.result-search ul').el[0];

    if ((0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.result-search ul') && e.target !== search) {
      search.remove();
    }
  });
}

/***/ }),

/***/ "./public/src/components/header/header.js":
/*!************************************************!*\
  !*** ./public/src/components/header/header.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _top_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./top.scss */ "./public/src/components/header/top.scss");
/* harmony import */ var _header_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./header.scss */ "./public/src/components/header/header.scss");



/***/ }),

/***/ "./public/src/components/test-pagination/test-pagination.js":
/*!******************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _test_pagination_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./test-pagination.scss */ "./public/src/components/test-pagination/test-pagination.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _Test_edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../Test/edit */ "./public/src/Test/edit.js");


 //Скрыть все кнопки

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[data-pagination]').removeClass('nav-active'); // Показать первую кнопку

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[data-pagination]:first-child').addClass('nav-active'); //// Пагинация

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination').on('click', function (e) {
  //// add question
  if (e.target.classList.contains('add-question')) {
    show();
    return;
  } //// paginate


  if (e.target.getAttribute('data-pagination')) {
    paginate(e.target);
    return;
  }
});

function paginate(self) {
  /// get clicked button Return if clicked is active
  if (self.classList.contains('nav-active')) return;
  let active_btn = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination .nav-active').el[0]; //// change active button

  active_btn.classList.remove('nav-active');
  self.classList.add('nav-active'); //// hide the card

  let id_to_hide = active_btn.dataset['pagination'];
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(`#question-${id_to_hide}`).removeClass('flex1'); //// show the card

  let id_to_show = self.dataset['pagination'];
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(`#question-${id_to_show}`).addClass('flex1');
} //// добавление вопроса


async function show(e) {
  let testid = +(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.test-name').value();
  let questCount = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("[data-pagination]").count();
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/question/show', {
    testid,
    questCount
  });
  res = JSON.parse(res);
  let Block = res.block;
  let blocks = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.blocks').el[0];
  blocks.insertAdjacentHTML('afterBegin', Block);
  let newBlock = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.blocks .block:first-child').el[0];
  document.querySelector('.flex1').classList.remove('flex1');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(newBlock).addClass('flex1');
  let save_button = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(newBlock).find('.question__save');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(save_button).on('click', questionSave); // $('.overlay').on('click', clickOverlay)
}

function showHidePaginBtn(e, pagItem) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination .nav-active').el[0]) {
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination .nav-active').el[0].classList.remove('nav-active');
  }

  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.add-question').el[0].insertAdjacentHTML('beforeBegin', pagItem);
}

function appendBlock() {
  let block = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.overlay').find('.block');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.blocks').append(block);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(block).addClass('flex1');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.a-add').on('click', _Test_edit__WEBPACK_IMPORTED_MODULE_2__.aAdd);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.q-delete').on('click', _Test_edit__WEBPACK_IMPORTED_MODULE_2__.qDelete);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.a-del').on('click', _Test_edit__WEBPACK_IMPORTED_MODULE_2__.aDelete);
}

function hideVisibleBlock() {
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.block.flex1').removeClass('flex1');
}

async function questionSave(e) {
  let block = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.block.flex1').el[0];
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/question/UpdateOrCreate', {
    question: (0,_Test_edit__WEBPACK_IMPORTED_MODULE_2__.getQuestion)(e, block),
    answers: (0,_Test_edit__WEBPACK_IMPORTED_MODULE_2__.getAnswers)(e, block, (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(block).find('textarea').value)
  });
  res = JSON.parse(res);

  if (res) {
    showHidePaginBtn(e, res.paginationButton);
    appendBlock(e);
    _common__WEBPACK_IMPORTED_MODULE_1__.popup.show(res.msg);
  }
}

/***/ }),

/***/ "./public/src/Admin/admin.scss":
/*!*************************************!*\
  !*** ./public/src/Admin/admin.scss ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/do.scss":
/*!*********************************!*\
  !*** ./public/src/Test/do.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/edit.scss":
/*!***********************************!*\
  !*** ./public/src/Test/edit.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/show.scss":
/*!***********************************!*\
  !*** ./public/src/Test/show.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/cookie/cookie.scss":
/*!**************************************************!*\
  !*** ./public/src/components/cookie/cookie.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/dnd/dnd.scss":
/*!********************************************!*\
  !*** ./public/src/components/dnd/dnd.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/footer/footer.scss":
/*!**************************************************!*\
  !*** ./public/src/components/footer/footer.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/autocomplete.scss":
/*!********************************************************!*\
  !*** ./public/src/components/header/autocomplete.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/header.scss":
/*!**************************************************!*\
  !*** ./public/src/components/header/header.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/top.scss":
/*!***********************************************!*\
  !*** ./public/src/components/header/top.scss ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/popup.scss":
/*!******************************************!*\
  !*** ./public/src/components/popup.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/test-pagination/test-pagination.scss":
/*!********************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.scss ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/normalize.scss":
/*!***********************************!*\
  !*** ./public/src/normalize.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************************!*\
  !*** ./public/src/Test/test.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _do__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./do */ "./public/src/Test/do.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./edit */ "./public/src/Test/edit.js");
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/test-pagination/test-pagination */ "./public/src/components/test-pagination/test-pagination.js");
/* harmony import */ var _Admin_admin_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Admin/admin.scss */ "./public/src/Admin/admin.scss");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");
/* harmony import */ var _show__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./show */ "./public/src/Test/show.js");








})();

/******/ })()
;
//# sourceMappingURL=test.js.map