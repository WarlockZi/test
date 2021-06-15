$(function () {
   var f = window.location.pathname.indexOf('adminsc/settings/');
   switch (true) {
      case (f > 0):
         $('.module.settings').addClass('activ');
         break;
   };
   });
