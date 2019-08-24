$(function () {
   var url = '/adminsc/catalog';
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
   $('.properties.column').on('change', '.new-prop', function (event) {
      let val = $(this).find('option:selected').val();
      let clone = $(this).clone(true);
      $(this).removeClass('new-prop');
      $(clone).find('option[value = ' + val + ']').remove();
      debugger;
      $('.properties.column option[value= ' + val + ']').not($(this).find('option:selected')).remove();
      $(clone).insertBefore($('.add-property'));
   });
// изменение селекта
//$('.properties.column select').chosen().on('change', function(evt, params){
//   let slef = $(this);
//   let val = $(this).val();
//   let target = e.target;
//   debugger;

//   $("select").chosen().on("change", function (evt, params) {
////    if (params.selected === "Portugal") {
//      var previous = $(this).data("previous") || "";
//      debugger;
//      $(this).val(previous).trigger("chosen:updated");
////    } else {
//      $(this).data("previous", params.selected);
////    }
//   });
//   $('.properties.column select').append(slef);
//   l$('.properties.column option[value= '+val+']').not($(this).find('option:selected')).remove();
//   $(clone).insertBefore($('.add-property'));
//}); 
//<H1>
//Костюмы для ИТР от производителя спецодежды</H1>
//Подберем для Ваших работников Костюмы для ИТР. Можно нанести логотипы и нашивки по необходимости

   $('.category-update-btn').on('click', function (event) {

      let id = $('#id').text(),
      token = $('#token').val(),
      name = $('#name').text(),
      alias = $('#alias').text(),
      title = $('#title').text(),
      keywords = $('#keywords').text(),
      description = $('#description').text(),
      core = $('#core').text(),
      text = $('#text').text(),
      props = $('.properties select option:selected'),
      prop = []
      ;
      for (let val of props) {
         if (val.value)
            prop.push(val.value);
      }

      prop = uniq(prop);
      prop = prop.join(',');
      debugger;
      let param = 'param=' + JSON.stringify({
         'token': token,
         'action': 'update',
         'model': 'category',
         'table': 'category',
         'field': 'id',
         'val': id,
         values: {
            'name': name,
            'alias': alias,
            'props': prop,
            'title': title,
            'keywords': keywords,
            'description': description,
            'core': core,
            'text': text
         },
      });
      $.ajax({
         url: '/adminsc/catalog',
         method: 'POST',
         data: param,
         success: function (res) {
            debugger;
            if (res===true) {
               alert('Успешно сохранено.');
               
            }
         },
         error: function (res) {
            debugger;
            let d = res;
         },
      });
   });
});
