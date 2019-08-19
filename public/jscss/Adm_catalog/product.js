$(function () {


   var f = window.location.pathname.indexOf('adminsc/catalog');
   switch (true) {
      case (f > 0):
         $('.module.catalog').addClass('activ');
         break;
      }

   function post(url, data) {
      return new Promise(function (resolve, reject) {
         var req = new XMLHttpRequest();
         req.open('POST', url);
         req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         req.setRequestHeader('Content-Type', 'application/json');
         req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
         req.send('param=' + JSON.stringify(data));
         req.onerror = function () {
            reject(Error("Network Error"));
         };
         req.onload = function () {
            resolve(req.response);
         };
      });
   }
//   $('.menu').accordion();



});