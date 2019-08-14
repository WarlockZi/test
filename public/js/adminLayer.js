$(function () {

   switch (window.location.pathname) {
      case '/adminsc/catalog':
      case '/adminsc/catalog/category':
         $('.module.catalog').addClass('activ');
         break;
      case '/adminsc/crm':
      case '/adminsc/crm/users':
         $('.module.crm').addClass('activ');
         break;
      case '/adminsc/settings':
      case '/adminsc/Sitemap':
      case '/adminsc/settings/pics':
         $('.module.settings').addClass('activ');
         break;
   }
});
function clearCache() {
   async function clearCache() {
      let response = await fetch('/adminsc/clearCache')
      let result = await response.text();
   }
   ;
   clearCache().catch(alert);
}



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
//
/////////////////////////////////
//////// PRODUCTS /////////////
///////////////////////////////

$('.product.column, .edit::before').hover(
function () {
//   debugger;
   $(this).toggleClass('edit');
   let id = $(this).data('id');
   $(this).prop('href', '/adminsc/productEdit?id=' + id);

},
function () {
   $(this).toggleClass('edit');
}
);



