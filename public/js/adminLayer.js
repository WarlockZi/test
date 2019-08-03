///////////////////////////////
//////// PRODUCTS /////////////
///////////////////////////////

$('.product.column, .edit::before').hover(
function () {
//   debugger;
   $(this).toggleClass('edit');
   let id = $(this).data('id');
   $(this).prop('href', '/adminsc/productEdit?id='+id);

},
function () {
   $(this).toggleClass('edit');
}
);



