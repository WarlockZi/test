import '../../../node_modules/swiper/css/swiper.min.css';
// import '../../../public/css/vitex.css';
import Swiper from 'swiper';

import autocomplete from '../components/autocomplete/autocomplete';

window.onload = function () {

    // var footer = document.querySelector('footer');
    // footer.style.backgroundImage = 'url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAAAxCAMAAABtRU6pAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjYxOTNCRjQ5RjM2NDExRTFCNzc0RjcxMERFNTg5RUU2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjYxOTNCRjRBRjM2NDExRTFCNzc0RjcxMERFNTg5RUU2Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjE5M0JGNDdGMzY0MTFFMUI3NzRGNzEwREU1ODlFRTYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjE5M0JGNDhGMzY0MTFFMUI3NzRGNzEwREU1ODlFRTYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz78Fl/qAAAA1VBMVEVKUFpJT1lKUVpH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\')';


    var mySwiper = new Swiper('.swiper-container', {
        autoplay: {
            delay: 10000,
        },
        slidesPerView: 3,
        effect: 'coverflow',
        speed: 100,
        spaceBetween: 0,
        touchEventsTarget: 'container',
        simulateTouch: true,
        grabCursor: true,
        coverflowEffect: {
            rotate: 60,
            slideShadows: false,
        },

    });

//     var element = document.getElementById('slider');
//     window.mySwipe = new Swipe(element, {
//         startSlide: 0,
//         auto: 3000,
//         draggable: false,
//         autoRestart: false,
//         continuous: true,
//         disableScroll: true,
//         stopPropagation: true,
//         callback: function(index, element) {},
//         transitionEnd: function(index, element) {}
//     });
//
//     window.mySwipe = new Swipe(document.getElementById('slider'));


    // var next = document.querySelector('#slides .next');
    // next.addEventListener('click', function () {
    //     nextSlide();
    // }, true);
    // var prev = document.querySelector('#slides .prev');
    // prev.addEventListener('click', function () {
    //     prevSlide();
    // },true);
    // var slides = document.querySelectorAll('#slides .slide');
    // var currentSlide = 0;
    // var slideInterval = setInterval(nextSlide, 200000);
    //
    // function nextSlide() {
    //     slides[currentSlide].className = 'slide';
    //     currentSlide = (currentSlide + 1) % slides.length;
    //     slides[currentSlide].className = 'slide showing';
    // }
    //
    // function prevSlide() {
    //     slides[currentSlide].className = 'slide';
    //     if (currentSlide == 0) {
    //         currentSlide = slides.length-1;
    //     } else {
    //         currentSlide = (currentSlide - 1) % slides.length;
    //     }
    //     slides[currentSlide].className = 'slide showing';
    // }

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