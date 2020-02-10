$(function () {


});

/////////////////////////////////
//////// PRODUCTS /////////////
///////////////////////////////

$('.product.column, .edit::before').hover(
function () {
//   debugger;
   $(this).toggleClass('edit');
   let id = $(this).data('id');
   $(this).prop('href', '/adminsc/catalog/product?id=' + id);

},
//function () {
//   $(this).toggleClass('edit');
//}
);

$('.breadcrumbs').on('click',
function (e) {
   var el = e.target,
   attr = el.getAttribute('data-id')
   ;
//   debugger;

   if (attr) {
      if (el.href) {
         el.href = '/adminsc/catalog/category?id=' + el.getAttribute('data-id');
//         $(this).toggleClass('edit');
      }
      else {
         window.location = '/adminsc/catalog/category?id='+ el.getAttribute('data-id');
//         $(this).toggleClass('edit');

      }
   }

   ;

//   let id = $(this).data('id');
//   $(this).prop('href', '/adminsc/catalog/product?id=' + id);

},
//function () {
//   $(this).toggleClass('edit');
//}
);



