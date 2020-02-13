window.onload = function () {

   var controller = 'test';


//////////// pagination
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

      var data = {action: 'getCorrectAnswers'};
// получим от сервера правильные ответы
      post(PROJ + '/test/do', data)
      .then(function (corrAnswers) {
// раскарасим кнопочки в соответсвии с прав ответами,
// посчитаем ошибки, отправим их и кеш страницы на сервер
         return colorView(JSON.parse(corrAnswers))
      })
      .then(function (errorCnt) {
         debugger;
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
                  }
                  ;
               }
               ;
            }
            ;
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
               questionCnt: $('.question').length,
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
};
