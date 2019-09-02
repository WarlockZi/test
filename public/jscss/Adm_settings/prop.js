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

// изменение  / добавление названия значения 
   $('.property-block').on('input', 'span[contenteditable]', function () {

      var Obj = new obj(this, 'update');
      Obj.pkeyVal = this.getAttribute('data-id');
      var v = document.querySelectorAll('.property-block span[contenteditable]:not(.new)');
      v = Array.from(v);
//      debugger;
      v = v.map((i)=>i.innerText.trim());
      v = v.join(',');
      Obj.values.val = v;

      if (this.classList.contains('new')) {
         
         Obj.values.val+=','+this.innerText;
         var clone = this.cloneNode(true);
         clone.innerHTML = '';
//         clone.data-id = '';
         var span = document.createElement('span');
         var parent = this.parentNode;
         parent.append(span);
         parent.append(clone);
         parent.append(span.cloneNode());

         this.classList.remove('new');
      }
      ;
//      debugger;
      setTimeout(function () {
         post(Obj.url, Obj)
      }, 800);
   });


});