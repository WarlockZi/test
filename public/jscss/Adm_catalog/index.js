$(function () {

   switch (window.location.pathname) {
      case '/adminsc/catalog':
         $('.module.catalog').addClass('activ');
         break;}

   function $_GET(key) {
      var p = window.location.search;
      p = p.match(new RegExp(key + '=([^&=]+)'));
      return p ? p[1] : false;
   }


   function post(url, data) {
//      debugger;
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