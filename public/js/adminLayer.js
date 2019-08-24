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
function () {
   $(this).toggleClass('edit');
}
);



