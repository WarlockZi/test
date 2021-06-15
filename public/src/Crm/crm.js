$(function () {

   function $_GET(key) {
      var p = window.location.search;
      p = p.match(new RegExp(key + '=([^&=]+)'));
      return p ? p[1] : false;
   }


//   $('.menu').accordion();



});