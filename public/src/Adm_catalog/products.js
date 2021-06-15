$(function () {

//   Filter
   $('.wrap').on('click', '.btn-filter', function () {

      var name = $('.filter').find("[name = 'name']").val();
      var aсt = +$('.filter').find("[name = 'aсt']").prop('checked');
      var art = $('.filter').find("[name = 'art']").val();
      var data = '?';
      var and = '';
      debugger;

      if (name) {
         data += 'name=' + name;
         and = '&';
      }
      data += and + 'act=' + aсt;
      and = '&';
      if (art) {
         data += and + 'art=' + art;
      }
      window.location.href = data;

      function page(pages) {
         var html = '';
         for (var i = 0; i < pages; i++) {
            var j = i + 1;
            html += "<a href='?page=" + i + "'>" + j + "</a>";
         }
         $('.navi').html(html);
      }
      ;
   });

//   Product deactivation
   $('.wrap').on('click', '.act', function () {
      
      let id = +$(this).parent().parent()[0].className;
      let checked = this.checked;
      let columnValue = 'N';
      if(checked){
         columnValue = 'Y';
      }
      debugger;

      $.post(
      "/adminsc/catalog/products",
      {param:JSON.stringify({
         action: "updateProduct",
         id: id,
         column: 'act',
         columnValue: columnValue
      })
      },
      onAjaxSuccess
      );

      function onAjaxSuccess(data)
      {
         // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
//         alert(data);
      }

   });
})
