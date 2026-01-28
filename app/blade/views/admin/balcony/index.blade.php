<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="UTF-8">
    <meta name="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="index, follow">

    <meta name="keywords" content="{{$data['seo_keywords']}}">
    <meta name="description"content={{$data['seo_description']}}>
    <title>{{$data['seo_title']}}</title>

    <link href="{{$data['css']}}styles.css" type="text/css" data-template-style="true" rel="stylesheet">
    <link href="{{$data['css']}}template_styles.css" type="text/css" data-template-style="true" rel="stylesheet">
    <link href="{{$data['css']}}fonts.css" rel="stylesheet">
    <link href="{{$data['css']}}vendors_hash%253D80e9fd5032e9989e9336.css" rel="stylesheet">
    <link href="{{$data['css']}}app_hash%253D765821bf9468e6ce6185.css" rel="stylesheet">


    <script defer="" src="/public/src/balcony/js/vendors_hash%253D3974e78eae913c6dc5aa.js"></script>
    <script defer="" src="{{$data['js']}}scripts.js"></script>

    <link rel="shortcut icon" href="/public/src/balcony/images/favicon.ico" type="image/x-icon">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link href="{{$data['css']}}styles_170722988113314.min.css" rel="stylesheet">

    <link href="{{$data['css']}}override.css" type="text/css" data-template-style="true" rel="stylesheet">
</head>
<body class="body-container">

@include('admin.balcony.cookie')


<script>
   window.lazySizesConfig = window.lazySizesConfig || {};
   window.lazySizesConfig.expand = 1000;
   window.lazySizesConfig.loadMode = 1;
   window.lazySizesConfig.loadHidden = false;
   window.lazySizesConfig.preloadAfterLoad = true;
</script>
<script src="{{$data['js']}}lazysizes.min.js" async=""></script>

<div class="whatsapp-button">
    <a href="{{$data['tg_href']}}" target="_blank">
        <img src="{{$data['images']}}telegram.svg" alt="Связаться в WhatsApp">
    </a>
</div>

<div class="whatsap4-button">
    <a href="tel:+79139121454" target="_blank">
        <img src="{{$data['images']}}phone.svg" alt="Телефон">
    </a>
</div>


<div id="panel"></div>

<div class="page-container main-page">
    <header class="header">

        @include('admin.balcony.header_nav')

        @include('admin.balcony.header_nav_mobile')
        <div class="side-labels"></div>


        <section class="stock-banner js-stock-banner">
            <div class="stock-banner__slider swiper js-stock-banner-slider">
                <div class="stock-banner__wrap swiper-wrapper">
                    <div class="stock-banner__item swiper-slide js-stock-banner-slide" data-is-video="false"
                         data-desktop-video="" data-mobile-video="" data-slide-index="0" data-mobile-color=""
                         data-text-color="">
                        <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale">
                            <img alt="Остекление балконов и лоджий со скидкой 20%* в Вологде" width="5712"
                                 height="4284"
                                 src="{{$data['images']}}slider/остекление.png"
                            >
                        </div>

                        <div class="stock-banner__item-content">
                            <div class="h2 stock-banner__item-title js-slide-title">Остекление балконов и лоджий со
                                скидкой 20%* в Вологде
                            </div>
                            <div class="stock-banner__item-desc js-slide-desc">
                                <div class="p"></div>
                            </div>

                            <div class="stock-banner__spacer"></div>
                            <div class="stock-banner__btn">
                                <a class="no-style btn btn--red" data-modal-window="#modal-zamer" href="">Записаться на
                                    замер</a>
                                <a class="no-style btn btn--blue only-desktop" href="/osteklenie-balkonov-i-lodzhii/">Подробнее</a>

                            </div>
                        </div>
                    </div>
                    <div class="stock-banner__item swiper-slide js-stock-banner-slide" data-is-video="false"
                         data-desktop-video="" data-mobile-video="" data-slide-index="1" data-mobile-color=""
                         data-text-color="">
                        <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale">
                            <img alt="Скидка на сервисные услуги 30%" width="1485" height="1112" class="lazyload"
                                 src="{{$data['images']}}slider/repair.jpg"
                            >
                        </div>

                        <div class="stock-banner__item-content">
                            <div class="h2 stock-banner__item-title js-slide-title">Скидка на сервисные услуги 30%</div>
                            <div class="stock-banner__item-desc js-slide-desc">
                                <div class="p">Скидка на сервисные услуги 30%</div>
                            </div>

                            <div class="stock-banner__spacer"></div>
                            <div class="stock-banner__btn">
                                <a class="no-style btn btn--red" data-modal-window="#modal-zamer" href="">Записаться на
                                    замер</a>
                                <a class="no-style btn btn--blue only-desktop" href="/servis/">Подробнее</a>

                            </div>
                        </div>
                    </div>
                    <div class="stock-banner__item swiper-slide js-stock-banner-slide" data-is-video="false"
                         data-desktop-video="" data-mobile-video="" data-slide-index="2" data-mobile-color=""
                         data-text-color="">
                        <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale">
                            <img alt="Акция" width="5712" height="4284" class="lazyload"

                                 src="{{$data['images']}}slider/delivery.webp"
                            >
                        </div>

                        <div class="stock-banner__item-content">
                            <div class="h2 stock-banner__item-title js-slide-title">Акция</div>
                            <div class="stock-banner__item-desc js-slide-desc">
                                <div class="p">При заказе от 3-х кашированных изделий – доставка бесплатно</div>
                            </div>

                            <div class="stock-banner__spacer"></div>
                            <div class="stock-banner__btn">
                                <a class="no-style btn btn--red" data-modal-window="#modal-zamer" href="">Записаться на
                                    замер</a>
                                <a class="no-style btn btn--blue only-desktop" href="/kottedzhi-i-doma/osteklenie/">Подробнее</a>

                            </div>
                        </div>
                    </div>
                    <div class="stock-banner__item swiper-slide js-stock-banner-slide" data-is-video="false"
                         data-desktop-video="" data-mobile-video="" data-slide-index="3" data-mobile-color=""
                         data-text-color="">
                        <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale">
                            <img alt="Дарим подарки" width="2560" height="1600" class="lazyload"
                                 {{--                                 @deb--}}
                                 src="{{$data['slider']}}gift.webp">

                        </div>

                        <div class="stock-banner__item-content">
                            <div class="h2 stock-banner__item-title js-slide-title">Дарим подарки</div>
                            <div class="stock-banner__item-desc js-slide-desc">
                                <div class="p">Дарим москитную сетку при заказе остекления</div>
                            </div>

                            <div class="stock-banner__spacer"></div>
                            <div class="stock-banner__btn">
                                <a class="no-style btn btn--red" data-modal-window="#modal-zamer" href="">Записаться на
                                    замер</a>
                                <a class="no-style btn btn--blue only-desktop"
                                   href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/">Подробнее</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stock-banner__pagination swiper-pagination js-stock-banner-pagination"></div>
            <div class="stock-banner__tabs">
                <div class="stock-banner-tabs">
                    <div class="stock-banner-tabs__wrap">
                        <div class="stock-banner-tabs__item js-stock-banner-tab active" data-slide-index="0">
                            <div class="h6 stock-banner-tabs__title">Остекление балконов и лоджий</div>
                            <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                        </div>
                        <div class="stock-banner-tabs__item js-stock-banner-tab" data-slide-index="1">
                            <div class="h6 stock-banner-tabs__title">Ремонт окон со скидкой</div>
                            <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                        </div>
                        <div class="stock-banner-tabs__item js-stock-banner-tab" data-slide-index="2">
                            <div class="h6 stock-banner-tabs__title">Бесплатная доставка</div>
                            <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                        </div>
                        <div class="stock-banner-tabs__item js-stock-banner-tab" data-slide-index="3">
                            <div class="h6 stock-banner-tabs__title">Дарим подарки</div>
                            <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </header>
    <main class="main-container">

        @include('admin.balcony.cta1_zamer')
        @include('admin.balcony.about_company')
        @include('admin.balcony.services')
        @include('admin.balcony.actions')

        @include('admin.balcony.cta2')
        @include('admin.balcony.poriadok_rabot')
        @include('admin.balcony.poriadok_rabot_after')
        @include('admin.balcony.faq')
        @include('admin.balcony.articles')

        @include('admin.balcony.examples')

        @include('admin.balcony.reviews')

    </main>
    @include('admin.balcony.footer')

</div>

@include('admin.balcony.modals')


<div class="mobile-button mobile-button--hidden js-mobile-button">
    <a class="mobile-button__btn no-style mobile-button__btn--red js-mobile-button--phone" href="tel:74959887888">
        <svg class="ico">
            <use xlink:href="/public/src/balcony/images/mobile-btn_1.svg#phone-call"></use>
        </svg>
    </a>
    <button class="mobile-button__btn mobile-button__btn--green js-mobile-button--chat">
        <svg class="ico">
            <use xlink:href="/public/src/balcony/images/mobile-btn_1.svg#chat"></use>
        </svg>
    </button>
</div>


@include('admin.balcony.feedback_form')

<div class="modal-bg"></div>


<div class="modal dialog">
    <span class="modal-close"></span>
    <p class="title">Заявка отправлена</p>
    <p>
        Ответим Вам в ближайшее время.
    </p>
</div>

@include('admin.balcony.jq')


</body>
</html>