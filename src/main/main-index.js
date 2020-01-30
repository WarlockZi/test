import 'jquery';
import 'slick-carousel';

window.onload = function () {

    $('.single-slide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
    });
}
