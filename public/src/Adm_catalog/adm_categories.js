$(function () {

   var f = window.location.pathname.indexOf('adminsc/catalog');
   switch (true) {
      case (f > 0):
         $('.module.catalog').addClass('activ');
         break;
      }




});