$(function () {
   var url = '/adminsc/settings';
//         debugger;
   var f = window.location.pathname.indexOf('adminsc/settings/');
   switch (true) {
      case (f > 0):
         $('.module.settings').addClass('activ');
         break;
   }
   // изменили название значения
   $('.property-block').on('keyup', '.value', function (event) {
      var name = this.innerText,
      id = $(this).data('id');
      var d = $(this).parent().find('.value');
      d = $.makeArray(d);
      debugger;
      var arr = d.map((val) => val.innerText);
      var val = arr.join(',').trim();

// ^,-зпт в нач слова  |  (\+-знак плюса ,-зпт \s-пробел)*$  
      val = val.replace(/[\+\,\s]*$/, "");
      var param = {
         action: 'updateProp',
         val: val,
         id: id
      };
      setTimeout(function () {
         post(url, param)
      }, 800);
   });


// изменили название свойства
   $('.property-block').on('keyup', '.property input', function () {
      var name = this.value,
      name = name.trim();
      url = '/adminsc/settings/props',
      id = $(this).parent().data('prop');
      var param = {
         action: 'updatePropName',
         name: name,
         id: id
      };
      setTimeout(function () {
         post(url, param)
      }, 800);
   });

   function addProp(self, enter) {
      var a = $(self).parent().find('.value'),
      b = a[0],
      a = $(b).clone();
      $(a).text(' ');
      debugger;
// установка курсора в начало ред строки
      var list = $('.val:first');
      if (enter) {
         $(self).parent().append(a);
      }
      else {
         $(self).before(a);
      }
      $(a).focus();
   }
   ;

// добавление значения 
   $('.property-block').on('click', '.add-prop-val', function () {
      var parentId = $(this).parent().parent().parent().data('prop');
      debugger;
      var data = {
         model: 'props',
         action: 'addPropValue',
         parentId: parentId
      };

      post(url, data).then(function (nextid) {
         addProp(nextid);

      });
   });

   async function sendPropName(params) {


      let body = {
         action: 'create',
         name: 'dd',
         table: 'props',
         values: {
            name: 'dd',
         }
      }
      debugger;
      var myHeaders = new Headers();
      myHeaders.append('HTTP_X_REQUESTED_WITH','XMLHttpRequest');
      let response = await fetch('/adminsc', {
         method: 'POST',
         body: 'param=' + JSON.stringify(body),
         mode: 'no-cors',
         headers: {HTTP_X_REQUESTED_WITH:'XMLHttpRequest'}, 
      });
      
      return response


   }




// Добавить свойство
   $('.prop-head').on('click', '.add-prop', function () {
      var name = prompt('Введите название'),
      parent = $('.orange').data('id');
      if (!name)
         return;

      var param = {
         model:'prop',
         action: 'create',
         table: 'props',
         values:{
            name: name,
         }
      };
      debugger;

//      sendPropName(param);

      var data = 'param=' + JSON.stringify(param);

      $.ajax({
         type: 'POST',
         url: '/adminsc',
         data: data,
         success: function (obj) {
            debugger;
            var str = JSON.parse(obj);
            $('.property-block').append(str);
         }
      });

   });


// удаление значения 
   $('.properties').on('click', '.del-prop span:nth-child(2)', function () {
//      debugger;
      var id = $(this).parent().parent().parent().data('prop');
      var param = {
         action: 'delPropBlock',
         id: id,
      };
      var data = 'param=' + JSON.stringify(param);

      $.ajax({
         type: 'POST',
         url: '/adminsc/prodtypes',
         data: data,
         success: function (obj) {
//         debugger;
            var id = JSON.parse(obj).id[0];
            $("[data-prop = " + id + "]").fadeOut(200);
         },
      });

   });

   $('.property-block').on('keydown', '.value', function (event) {
      var char = event.which;
      if (char == 13) { // это Enter
         event.preventDefault();
         addProp($(this), true);
         return;
      }
   });


   /**
    * 
    * @param {type} url глобальный
    * @param {type} data данные
    * @return {Promise}
    */


});