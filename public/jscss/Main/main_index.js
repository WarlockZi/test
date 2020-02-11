// import 'slick-carousel';
// import {auto} from "../common";
import autocomplete from '../components/autocomplete';
// import autocomplete from "../max.auto";

window.onload = function () {
    // $.event.special.touchstart = {// чтобы не было ошибки при прикосновениях пальцем на мобилке
    //     setup: function (_, ns, handle) {
    //         if (ns.includes("noPreventDefault")) {
    //             this.addEventListener("touchstart", handle, {passive: false});
    //         } else {
    //             this.addEventListener("touchstart", handle, {passive: true});
    //         }
    //     }
    // };
    // $.event.special.touchmove = {
    //     setup: function (_, ns, handle) {
    //         if (ns.includes("noPreventDefault")) {
    //             this.addEventListener("touchstart", handle, {passive: false});
    //         } else {
    //             this.addEventListener("touchstart", handle, {passive: true});
    //         }
    //     } "deleted plugin jq from webpack"
    // };

    document.querySelector('body').addEventListener('click', function (e) {
        const search = document.querySelector('.result-search ul');
        if (document.querySelector('.result-search ul') && e.target !== search) {
            search.remove();
            // alert('Удаляем !');
        }
    });

    function empty_form() {
        var text = document.querySelector('#autocomplete').value;
        if (!text) {
            alert('Заполните зарпос');
            return false;
        }
        return true;
    };

    // $('.single-slide').slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     autoplay: true,
    //     autoplaySpeed: 3000,
    // });

}