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



/////////////////////////////////////////////////////////////////////////////
/////////// RESULTS FREETEST , показать результаты /////////////////////////////
/////////////////////////////////////////////////////////////////////////////

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
               questionCnt: $('.question').length,
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