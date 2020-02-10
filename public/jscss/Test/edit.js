window.onload = function () {

   var controller = 'test';

//////////////////////////////// Параметры теста///////////////

// Открываем панель параметров теста
   $('body').on('click', ".add-test, .test-params", function () {
// Если форма открытa, закроем ее 
//debugger;
      if (document.querySelector('.testParamsBorder')) {
         $('.testParamsBorder').remove();
      }
      var testId = $(this).data('testid');
//      var data = {testId: testId, action: 'testParams'};
//      data = 'param=' + JSON.stringify(data);
      
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
      var lastQuest = questionCollection.length - 1;
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
            if (link != '#') {
               $(link).fadeIn(100);
            }
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
      debugger;
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
         //debugger;
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
      //debugger;
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
      //debugger;
      $.ajax({
         url: PROJ + '/test/edit',
         type: 'POST',
         data: ({action: 'delete_q_a', aid: id, qid: question_id}),
         cache: false,
         success: function (res) {
            $('#' + question_id + 'q').parent().add('.pagination>a.nav-active ').slideUp(400, function () {
               $(this).remove();
               var paginationACollection = $('.pagination>a');
               var len = paginationACollection.length;
               paginationACollection.each(function (index, elem) {// Пересчет номеров пагинации
                  index++;
                  if (index < len) {
                     $(this).text('' + index);
                  }
               });
               var paginItem = $('.pagination a:first').removeClass('p-no-active').addClass('nav-active');
               var questId = paginItem[0].hash.replace('#question-', '');
               $('#question-' + questId).show();
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