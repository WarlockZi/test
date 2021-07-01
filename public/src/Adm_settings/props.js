$(function () {

   function obj(self, action) {
      return {
         token: $('#token').val(),
         url: '/adminsc',
         model: 'prop',
         table: 'props',
         action: action ? action : 'update',
         pkey: 'id',
         pkeyVal: 'nul',
         values: {}
   }
   }
   ;

// изменение названия свойства / добавление
   $('.property-block').on('input', '.property-name', function () {

      var Obj = new obj(this, 'update');
      Obj.pkeyVal = this.getAttribute('data-id');
      Obj.values.name = this.value.trim();
      
//         debugger;
      if (this.parentNode.classList.contains('new')) {
         var clone = this.parentNode.cloneNode(true);
         clone.innerHTML = '';
         var parent = this.parentNode.parentNode;
         parent.append(clone);
         this.classList.remove('new');
      }
      ;
//      debugger;
      setTimeout(function () {
         post(Obj.url, Obj)
      }, 800);
   });
// изменение селекта
   $('select.type').on('change', function () {
      var Obj = new obj(this, 'update');
      Obj.pkeyVal = this.getAttribute('data-id');
      Obj.values.type = this[this.selectedIndex].value;
      post(Obj.url, Obj);
   })
 // изменение сортировки
   $('.property-block').on('input','.sort', function () {
//      debugger;
      var Obj = new obj(this, 'update');
      Obj.pkeyVal = this.getAttribute('data-id');
      Obj.values.sort = this.innerHTML;
      post(Obj.url, Obj);
   })
   
// добавление значения 
   $('.property-block').on('input', '.value, .add-prop-val', function (event) {

      var url = '/adminsc',
      val = $(this).text(),
      id = $(this).parent().parent().parent().data('prop'),
      str = $(this).parent().find('span'),
      val = '',
      vals = new Set(str),
      dd = [];

      vals.forEach(function (item, same, set) {
         if (item.innerText)
            dd.push(item.innerText);
      });

      val = dd.join(',').trim(',');

      debugger;
      if (this.classList.contains('add-prop-val')) {
         var clone = this.cloneNode(true);
         clone.innerHTML = '';
         this.classList.remove('add-prop-val');
         var el = this.parentNode.querySelector('.new');
         var parent = this.parentNode;
         parent.insertBefore(clone, el);
      }

//        if (!val&&!'')
//            return false;

      var data = {
         token: $('#token').val(),
         model: 'prop',
         action: 'update',
         table: 'props',
         pkey: 'id',
         pkeyVal: id,
         values: {
            val: val,
         }
      };
      post(url, data);

   });




});