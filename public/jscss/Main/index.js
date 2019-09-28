function empty_form() {
   var text = document.querySelector('#autocomplete').value;
//      debugger;
   if (!text) {
      alert('Заполните зарпос');
      return false;
   }
   return true;
}
;

$(function () {

   $('.single-slide').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 30000,
   });

})