import 'jquery';
import 'slick-carousel';
import {auto} from "../common";
import autocomplete from "../max.auto";

window.onload = function () {
    // auto();
    // autocomplete();

    $.event.special.touchstart = {// чтобы не было ошибки при прикосновениях пальцем на мобилке
        setup: function (_, ns, handle) {
            if (ns.includes("noPreventDefault")) {
                this.addEventListener("touchstart", handle, {passive: false});
            } else {
                this.addEventListener("touchstart", handle, {passive: true});
            }
        }
    };
    $.event.special.touchmove = {
        setup: function (_, ns, handle) {
            if (ns.includes("noPreventDefault")) {
                this.addEventListener("touchstart", handle, {passive: false});
            } else {
                this.addEventListener("touchstart", handle, {passive: true});
            }
        }
    };

    function empty_form() {
        var text = document.querySelector('#autocomplete').value;
        if (!text) {
            alert('Заполните зарпос');
            return false;
        }
        return true;
    };

    $('.single-slide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
    });
}
