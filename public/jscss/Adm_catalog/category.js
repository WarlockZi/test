$(function () {

   function obj(action) {
      return {
         token: $('#token').val(),
         url: '/adminsc',
         model: 'category',
         table: 'category',
         action: action ? action : 'update',
         pkey: 'id',
         pkeyVal: 'nul',
         values: {}
      }
   }
   ;

// изменение  / добавление названия значения 
   $('.category-update-btn').on('click',function () {

      var Obj = new obj('update');
      Obj.pkeyVal = $('#id').text();

      Obj.values.name = $('#name').text();
      Obj.values.alias = $('#alias').text();
      Obj.values.title = $('#title').text();
      Obj.values.keywords = $('#keywords').text();
      Obj.values.description = $('#description').text();
      Obj.values.core = $('#core').text();
      Obj.values.text = $('#text').text();
      var props = $('.properties select option:selected');
//      debugger;
      var prop = [];
      
      for (let val of props) {
         if (val.value)
            prop.push(val.value);
      }

      prop = uniq(prop);
      Obj.values.props = prop.join(',');
//      debugger;
      setTimeout(function () {
         post(Obj.url, Obj)
      }, 800);
   });

// При закрытии окна выбора свойств
   $('body').on('click', '.messageClose', function () {
      debugger;
      var close = document.querySelector('.messageClose'),
      overlay = document.querySelector('.overlay'),
      propIds = Array(),
      box = document.querySelector('.messageBox');

      var propEls = $('.prop-list>.prop-name');
      var catId = $_GET('id');
      for (var i = 0; i < propEls.length; i++) {
         var checked = propEls[i].getElementsByTagName('input')[0].checked;
         if (checked) {
            propIds.push(propEls[i].id);
         }
      }

      var data = {
         action: 'addCatProps',
         propIds: propIds,
         catId: catId
      }
      post(url, data);
      overlay.remove();
      box.remove();
   });
// Добавить свойство
   $('.properties').on('click', '.add-prop', function () {
      var catId = $_GET('id');
      var propsCollection = $('.property'); //; 
      var propIdsOnPage = {}; //.data('prop'); 
      for (var i = 0; i < propsCollection.length; i++) {
         propIdsOnPage[i] = propsCollection[i].getAttribute('data-prop');
      }
      var param = {
         action: 'getCatProps',
         catId: catId,
         propIdsOnPage: propIdsOnPage
      };
      post(url, param).then(function (data) {
//         debugger;
         if (data) {
            var data = JSON.parse(data);
            $('body').append(data.snippet);
         }
      });
   });
   function addProp(self, enter) {
      var a = $(self).parent().find('.value'),
      b = a[0],
      a = $(b).clone();
      $(a).text('');
// установка курсора в начало ред строки
      var list = $('.val:first');
      if (enter) {
         $(self).parent().append(a);
      }
      else {
         $(self).prev().append(a);
      }
      $(a).focus();
   }
   ;


// создание нового селекта
   $('.properties.column').on('change', '.new-prop', function () {
      let val = $(this).find('option:selected').val();
      let clone = $(this).clone(true);
      $(this).removeClass('new-prop');
      $(clone).find('option[value = ' + val + ']').remove();
//      debugger;
      $('.properties.column option[value= ' + val + ']').not($(this).find('option:selected')).remove();
      $(clone).insertBefore($('.add-property'));
   });

});
