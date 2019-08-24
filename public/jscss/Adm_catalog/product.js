$(function () {

   $('#product-update-btn').on('click', function () {
      let id = $('#id').text(),
      token = $('#token').val(),
      name = $('#name').text(),
      alias = $('#alias').text(),
      title = $('#title').text(),
      keywords = $('#keywords').text(),
      description = $('#description').text(),
      core = $('#core').text(),
      dtxt = $('#text').text(),
      props = $('.properties [data-type]'),
      prop = ({})
      ;
      for (let val of props) {
         if (val.value) {
//            debugger;
            if (val.getAttribute('data-type') == 'select') {
               let id = val.getAttribute('data-id');
               let selected = $(val).find(':selected');
               prop[id] = selected.val();
            }
            else if (val.getAttribute('data-type') == 'text') {
               let id = val.getAttribute('data-id');
               prop[id] = val.value;
            }
            else if (val.getAttribute('data-type') == 'multi-select') {
               let id = val.getAttribute('data-id');
               let options = $(val).find('option:selected');
               let obj = [];
               for (let opt of options) {
                  obj.push(opt.value);
               }
               prop[id] = obj.join(',');

            }
         }
      }
//      debugger;
      prop = JSON.stringify(prop);

      let param = 'param=' + JSON.stringify({
         'token': token,
         'action': 'update',
         'model': 'product',
         'table': 'products',
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
            'dtxt': dtxt
         },
      });
//      debugger;
      $.ajax({
         url: '/adminsc/catalog',
         method: 'POST',
         data: param,
         success: function (res) {
//            debugger;
            if (res == 'true') {
               alert('Успешно сохранено.');

            }
         },
         error: function (res) {
            debugger;
            let d = res;
         },
      });
   });








//   $('.menu').accordion();
});