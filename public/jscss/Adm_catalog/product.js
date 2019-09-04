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
// сохранить изменения
   $('#product-update-btn').on('click', function () {

      var Obj = new obj('update');
      Obj.pkeyVal = $('#id').text();

      Obj.values.act = document.querySelector('#act').checked ? 'Y' : 'N';
      Obj.values.name = $('#name').text();
      Obj.values.alias = $('#alias').text();
      Obj.values.dpic = $('#dpic').val();
      Obj.values.text = $('#text').text();
      Obj.values.title = $('#title').text();
      Obj.values.keywords = $('#keywords').text();
      Obj.values.description = $('#description').text();
      Obj.values.core = $('#core').text();

      var props = $('.work-area .category-properties');
      var prop = ({});
      var u = uniq(props);
      u.map((i) => {
         var d = i;
         var el='' ;
      debugger;
         if ( el = i.querySelector('select')) {
            prop.el.name=el.selected;
         }else if(el = i.querySelector('input')){
//              prop.i.querySelector('span'):'dd';
         };
      });

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

//   
//   $('#product-update-btn').on('click', function () {
//      let id = $('#id').text(),
//      token = $('#token').val(),
//      name = $('#name').text(),
//      alias = $('#alias').text(),
//      title = $('#title').text(),
//      keywords = $('#keywords').text(),
//      description = $('#description').text(),
//      core = $('#core').text(),
//      dtxt = $('#text').text(),
//      props = $('.properties [data-type]'),
//      prop = ({})
//      ;
//      for (let val of props) {
//         if (val.value) {
////            debugger;
//            if (val.getAttribute('data-type') == 'select') {
//               let id = val.getAttribute('data-id');
//               let selected = $(val).find(':selected');
//               prop[id] = selected.val();
//            }
//            else if (val.getAttribute('data-type') == 'text') {
//               let id = val.getAttribute('data-id');
//               prop[id] = val.value;
//            }
//            else if (val.getAttribute('data-type') == 'multi-select') {
//               let id = val.getAttribute('data-id');
//               let options = $(val).find('option:selected');
//               let obj = [];
//               for (let opt of options) {
//                  obj.push(opt.value);
//               }
//               prop[id] = obj.join(',');
//
//            }
//         }
//      }
////      debugger;
//      prop = JSON.stringify(prop);
//
//
//         values: {
//            'name': name,
//            'alias': alias,
//            'props': prop,
//            'title': title,
//            'keywords': keywords,
//            'description': description,
//            'core': core,
//            'dtxt': dtxt
//         },
//      });
////      debugger;


//   $('.menu').accordion();
});