$(function () {   
//   chown -R 500:500 /var/www/vitexopt/data/www/vitexopt.ru
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

})
