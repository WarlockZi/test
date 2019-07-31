
///////////////////////////////
//////// PRODUCTS /////////////
///////////////////////////////


$('.product.column, .edit::before').hover(
function () {
   $(this).find('a').prepend(
   "<span class = 'edit'> редактировать"+
   "</span>"
   );
   $(this).css('border:solid');
},
function () {
   $(this).find('.edit').remove();
}
);



