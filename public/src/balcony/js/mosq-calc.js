jQuery(document).ready(function() {


$( '.mosq-calc__btn .btn').attr('data-modal-window', '#modal-mosqit-order');

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

	function calc_mosq_func() {


var price_all = 0;
var order_text = "";

$( '.mosq-calc__item' ).each(function(i,elem) {


var w;
var h;
var count;
var price;
var anticohcka="нет";
var color="белый";

var count=$(elem).find(".mosq-calc-cart__count").text();







    	$(elem).find(".control__input.js-user-name").each(function(i2,elem2) {
			if (i2==0) {w=$(elem2).val() / 1000;}
			if (i2==1) {h=$(elem2).val() / 1000;}



		});


if ($(elem).find('[id^=mosq-yes-]').prop('checked')) {

var anticohcka="да";

if ($(elem).find('[id^=mosq-color-ral-]').prop('checked')) {
var color="Ral";

price=w * h * 2800 + (w * h * 2800 / 2);


} else {

price=w * h * 3500;

}


} else {

if ($(elem).find('[id^=mosq-color-ral-]').prop('checked')) {
var color="Ral";
price=w * h * 1600 + (w * h * 1600 / 2);


} else {

price=w * h * 1600;

}



}

price = price * count;
price_all = price_all + price;

	order_text=order_text+"Сетка " + (i + 1) +":\n";
	order_text=order_text+"Ширина: " + w + " м\n";
	order_text=order_text+"Высота: " + h + " м\n";
order_text=order_text+"Антикошка: " + anticohcka + "\n";
order_text=order_text+"Цвет: " + color + "\n";
	order_text=order_text+"Колличество: " + count + " шт.\n";
order_text=order_text+"Цена: " + numberWithSpaces(Math.round(price)) + " руб.\n\n";


$(elem).find(".mosq-calc-cart__price-value span").text(numberWithSpaces(Math.round(price)));

});

$('#modal-mosqit-order input[name="order"]').val(order_text);
price_all = price_all + 500;
$('#modal-mosqit-order input[name="price"]').val(numberWithSpaces(Math.round(price_all)) + " руб.");
$('.mosq-calc__total-price span').text(numberWithSpaces(Math.round(price_all)));

	}


calc_mosq_func();


$(".mosq-calc__item .btn-arrow.mosq-calc-cart__arrow").click(function(e){
calc_mosq_func();
});

$(".mosq-calc__close").click(function(e){
calc_mosq_func();
});




$( ".mosq-calc__item input:radio" ).on("change", function() {
calc_mosq_func();
});



    $(".mosq-calc__item .control__input").on('input', function() {
calc_mosq_func();
    });




$(".btn-arrow.mosq-calc__btn-add").click(function(e){


	$.getScript('/bitrix/templates/new_style/js/mosq-calc.js', function(){
});
calc_mosq_func();

});


});