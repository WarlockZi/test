import './free-test-edit.scss'

window.onload = function () {



//////////// Edit pagination
   var prevActive = document.querySelector('.pagination .nav-active').getAttribute('href');
   document.querySelector('.content .test-data').querySelector(prevActive).classList.add('nav-active');
// Пагинация
   document.querySelector('.pagination .p-no-active').addEventListener('click', function () {
      if (document.querySelector(this).attr('class') == 'nav-active')
         return false;
      let link = document.querySelector(this).getAttribute('href');
      let prevActive = document.querySelector('.pagination>a.nav-active ').getAttribute('href');
      document.querySelector('.pagination>.nav-active').classList.remove('nav-active')
      document.querySelector('.pagination>.nav-active').classList.add('p-no-active')


      document.querySelector(this).classList.remove('p-no-active')
      document.querySelector(this) .classList.add('nav-active')

      if (document.querySelector(prevActive) !== 0) {// Если удалили вопрос из DOM, его длинна будет 0 и следующий вопрос не покажется
         document.querySelector(prevActive).fadeOut(100, function () {
            if (link!='#') {
               document.querySelector(link).fadeIn(100);
            }
         });
      }
      else {
         document.querySelector(link).fadeIn(100);
      }
      return false;
   },true);


//////////////////////  ADD KEY Кнопка добавить ключевик ///////////////
   document.querySelector('.content').addEventListener('click', '.button_key', function () {
      document.querySelector('<input class = "input_key" type="text">').insertBefore(document.querySelector(this));
   },true)

///////////////////////   При изменении KEY_WORDS   ///////////////
   document.querySelector('.content').addEventListener('change', '.input_key', function () {
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
   },true);
//////////////////////////////// Параметры Freetest///////////////

// Открываем панель параметров freeтеста
   document.querySelector('body').addEventListener('click', ".add-freetest, .freetest-params", function () {
// Если форма открытa, закроем ее
      if (document.querySelector('.testParamsBorder')) {
         document.querySelector('.testParamsBorder').remove();
      }
      var testId = document.querySelector(this).data('testid');
      $.ajax({
         url: PROJ + '/freetest/edit',
         type: 'POST',
         data: ({testId: testId, action: 'freetestParams'}),
         success: function (res) {
            document.querySelector('.wrap').after(res);
            document.querySelector('.overlay').animate({opacity: 0.5}, 200);
            document.querySelector('.testParamsBorder').fadeIn(100);
         }
      });
   },true);
// Удалить freeтест
   document.querySelector('body').addEventListener('click', '#freetestParamsDEL', function () {

      var testId = +document.querySelector('.testId').text();
      $.ajax({
         url: PROJ + '/freetest/edit',
         type: 'POST',
         data: ({tId: testId, action: 'tDel'}),
         cache: false,
         success: function (res) {
            debugger;
            if (confirm('Удалить тест?')) {
               document.querySelector('.testParamsBorder').hide(100, function () {
                  document.querySelector(this).remove();
                  document.querySelector('body .test-params[data-testid =' + testId + ']').parent().add('.overlay').remove();
               });
// Удаляем из второго меню тест
               document.querySelector('[href="/freetest/edit/' + testId + '"]').parent().remove();
            }

         },
         error: function () {
            alert('Тест не удалился.');
         }
      });
   },true);
// Кнопка "Отмена"  - не сохранять параметры freeтеста
   document.querySelector('body').addEventListener('click', '#saveTestParmsCansel, .overlay', function () {
      document.querySelector('.testParamsBorder').add('.overlay').fadeOut(300, function () {
         document.querySelector(this).remove();
      });
   },true);
// Кнопака "ОК"  - сохранить параметры freeтеста/Добавить новый freeтест
   document.querySelector('body').addEventListener('click', '#saveFreetestParamsOK', function () {
      var testId = +document.querySelector('.testId').text(),
          testName = document.querySelector('#saveTestName').value,
          parentTest = +document.querySelector('#selectParenTest option:selected').value,
          isTest = +document.querySelector('#isTest option:selected').value,
          sort = +document.querySelector('.sort input').value,
          enable = document.querySelector('input[data-test-id]').prop("checked") ? 1 : 0;
      if (document.querySelector('input[data-test-id]').prop("checked"))
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

                  document.querySelector('a[href="' + PROJ + '/edit/' + testId + '"]').text(res);
                  document.querySelector('.test-name').text('Тест - ' + res);
                  document.querySelector('.testParamsBorder').add('.overlay').hide(100, function () {
                     document.querySelector(this).remove()
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
                  if (!document.querySelector('.test-name')) {
                     document.querySelector('div.block').remove();
                     document.querySelector('.test-name').after(obj.answer);
                     document.querySelector('.test-name').after(obj.question);
// Находимся в папке а не в тесте, поэтому контент добавляем
                  }
                  else {
// Всатвляем все после контента
                     var divTestName = '<p class="test-name" name = "test_id" value = "1">Тест - ' + obj.testName + '</p>' + obj.pagination + obj.question;
                     var c = document.querySelector('.content');
                     c[0].innerHTML = divTestName;
//                            c[0].innerHtml = divTestName;
                     document.querySelector('.content').html(divTestName);
                     document.querySelector('.content .block').show();
                  }
// Закрываем рамку создания нового теста
                  document.querySelector('.testParamsBorder').add('.overlay').fadeOut(150);
// Добавим пункты меню
                  document.querySelector('.menu').insertAdjacentHTML("beforeend",obj.menuItem);
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
   },true);
// freeтест Удалить ВОПРОС
   document.querySelector('body').addEventListener('click', '.delete-question', function () {
      var qId = +document.querySelector(this).data('id');
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
               document.querySelector('.pagination').querySelector(`[href = "#question-` + res + `"]`).fadeOut(200, function () {
                  document.querySelector(this).remove();
               });
               document.querySelector(".block[style='display: block;']").fadeOut(200, function () {
                  document.querySelector(this).remove();
               });
               document.querySelector('.pagination a:first-child').removeClass('p-no-active').classList.add('nav-active');
            }
            else {
               window.alert("Вопрос не удален");
            }
         },
         error: function () {
            window.alert("Вопрос не удален");
         }
      });
   },true);




};