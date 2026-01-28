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
    <meta name="description"
          content={{$data['seo_description']}}>
    <link href="{{$data['css']}}styles.css" type="text/css" data-template-style="true" rel="stylesheet">
    <link href="{{$data['css']}}template_styles.css" type="text/css" data-template-style="true" rel="stylesheet">


    <title>{{$data['seo_title']}}</title>
    <link href="{{$data['css']}}fonts.css" rel="stylesheet">
    <link href="{{$data['css']}}vendors_hash%253D80e9fd5032e9989e9336.css" rel="stylesheet">
    <link href="{{$data['css']}}app_hash%253D765821bf9468e6ce6185.css" rel="stylesheet">


    <script defer="" src="/public/src/balcony/js/vendors_hash%253D3974e78eae913c6dc5aa.js"></script>
    <script defer="" src="{{$data['js']}}scripts.js"></script>

    <link rel="shortcut icon" href="/public/src/balcony/images/favicon.ico" type="image/x-icon">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link href="{{$data['css']}}styles_170722988113314.min.css" rel="stylesheet">

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
<script src="js/lazysizes.min.js" async=""></script>

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

        <nav class="head-menu head-menu--fixed js-head-menu">

            <div class="inner-container head-menu__top">
                <div class="mega-menu__head">

                    <a class="navbar-logo" href="/">
                        <img src="/public/src/balcony/images/logo.jpg" alt="" class="img-responsive" width="60"
                             height="60">
                        {{$conf['company']}}
                    </a>

                </div>


                <ul class="head-menu__main-menu main-menu">


                    <li class="main-menu__item">
                        <a class="no-style main-menu__label" href="/contacts/">Контакты</a>
                    </li>

                    <li data-submenu-toggle="" class="main-menu__item">
                        <a class="no-style main-menu__label" href="/company/">О нас</a>
                        <div data-submenu="" class="main-menu__submenu submenu">
                            <ul class="submenu__list">
                                <li class="submenu__item">
                                    <a class="submenu__link" href="/company/reviews/">Отзывы клиентов</a>
                                </li>
                                <li class="submenu__item">
                                    <a class="submenu__link" href="/company/news/">Новости</a>
                                </li>
                                <li class="submenu__item">
                                    <a class="submenu__link" href="/company/articles/">Статьи</a>
                                </li>
                                <li class="submenu__item">
                                    <a class="submenu__link" href="/company/director/">Написать Директору</a>
                                </li>
                                <li class="submenu__item">
                                    <a class="submenu__link" href="/contacts/">Контакты</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <div class="head-menu__group">
                    <div class="head-menu__head-contact head-contact">
                        <div class="head-contact__phone">
                            <div class="head-contact__top-group">
                                <div class="head-contact__city">
                                    <svg class="ico">
                                        <use xlink:href="/public/src/balcony/images/interface.svg#geolocation"></use>
                                    </svg>
                                    {{--                                    @deb--}}
                                    {{$conf['city']}}
                                </div>
                                <div class="head-contact__work-time">
                                    с {{$conf['work_from']}} до {{$conf['work_to']}}
                                </div>
                            </div>
                            <a class="no-style head-contact__phone-link"
                               href={{$conf['phone_href']}}>{{$conf['phone']}}</a>

                        </div>
                        <div class="head-contact__icon-group">
                            <a class="no-style head-contact__icon icon-tg" href="{{$conf['tg_href']}}">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/interface_23423.svg#tg-small"></use>
                                </svg>
                            </a>

                        </div>

                    </div>
                    <div class="burger-nav burger-nav--open js-btn-open-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

            <div class="inner-container head-menu__bottom">
                <div class="head-slider js-mega-menu">
                    <div class="head-slider__slider" data-head-slider="">


                        <ul class="swiper-wrapper head-menu__bottom-wrapper">
                            <!-- 0 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                                <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/" class="no-style mega-menu-item ">
                                    <div class="mega-menu-item__label">Пластиковые окна</div>
                                </a>

                                <div class="mega-menu__sub-container type-big-submenu js-mg-submenu-lv1 js-system-menu">
                                    <ul class="mega-menu__submenu mg-submenu-lv1 type-big-submenu">

                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item "
                                            data-system-code="exprof-prowin">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-prowin/">Exprof
                                                Prowin</a>
                                        </li>

                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item "
                                            data-system-code="exprof-profecta">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-profekta/">Exprof
                                                Profecta</a>
                                        </li>

                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item "
                                            data-system-code="exprof-experta">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-experta/">Exprof
                                                Experta</a>
                                        </li>

                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item "
                                            data-system-code="gotovie-rshenia">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/gotovye-resheniya/">Готовые
                                                решения</a>
                                        </li>
                                    </ul>
                                    <div class="mega-menu__stock" data-system-banner="common">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/menu-1.jpg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <div class="h3 mg-stock__title">Пластиковые окна с установкой под ключ
                                                </div>
                                                <p class="p mg-stock__desc">Делаем правильный монтаж в Новосибирске с
                                                    гарантией!</p>
                                                <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/"
                                                   class="btn mg-stock__btn no-style" data-modal-window="#modal-zamer">Заказать</a>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="mega-menu__stock" data-system-banner="exprof-prowin"
                                         style="display:none;">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/exprof-prowin.jpg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <div class="h3 mg-stock__title">Окна Provin</div>
                                                <p class="p mg-stock__desc">Идеально для неотапливаемых помещений,
                                                    балконов и лоджий.</p>
                                                <div class="mg-stock__items">

                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/d17/abxt5qpthj7wr3n2vvpuz9t8nxer4yw1/icons_100.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Долговечность и надежность
                                                        </div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/38c/iq26zf46dkblvdva9h97g8pjk402hqsk/icons_udaroprochnost.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Оптимальное соотношение
                                                            цена/качества
                                                        </div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/32b/demye19hgfb8msqs9ato6b7vcbzpk70n/icons_energo.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Высокая цветопроницаемость
                                                        </div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/ff3/t7tvnnfmsiwjj2oso72jnyrwqo2d0wwo/icons_design.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Идеальная геометрия</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="mega-menu__stock" data-system-banner="exprof-profecta"
                                         style="display:none;">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/exprof-profecta.jpg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <div class="h3 mg-stock__title">Exprof Profecta</div>
                                                <p class="p mg-stock__desc">Такие окна обладают базовым уровнем
                                                    безопасности и оснащены двумя уплотнительными контурами.</p>
                                                <div class="mg-stock__items">

                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/52c/7b5ijj498dgzfo7sa1l6i9x83z1882w7/icons_geometry.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Доступная цена</div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/687/1us5y8ytex4jdlsim3mim8nj03gf5u40/icons_glyanets.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Выбор цветовых решений</div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/656/9z1dlplzc5kb6deqvovf1wpvi1mojh6b/icons_color.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Высокая звукоизоляция</div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/212/pcyz5y2rum7q35bqp2lk7vkq1cgf99ko/icons_price.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Высокое теплосбережение</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="mega-menu__stock" data-system-banner="exprof-experta"
                                         style="display:none;">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/exprof-experta.jpg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <div class="h3 mg-stock__title">Exprof Experta</div>
                                                <p class="p mg-stock__desc">Профильные системы Exprof Experta не только
                                                    теплые и тихие, но и "тихие" - 70ти миллиметровая монтажная глубина
                                                    конструкции хорошо поглащает уличный шум.</p>
                                                <div class="mg-stock__items">

                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/52c/7b5ijj498dgzfo7sa1l6i9x83z1882w7/icons_geometry.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Высокая звукоизоляция</div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/93e/3kwcoi96chd5l0a00iwg5s7cr9f1znox/icons_noizeless.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Повышенная защита от ветра и
                                                            влаги
                                                        </div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/dea/8hjgfdtv8p37ln0x4ttd9vkagqh7rub7/icons_classa.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Долговечность и надежность
                                                        </div>
                                                    </div>
                                                    <div class="mg-stock__icon">
                                                        <img class="ico lazyload"
                                                             data-src="/new_style_files/upload/iblock/ebd/f369acgu2bp39lyvjfc0aa6omvhyzars/icons_hemy.svg"
                                                             alt="">
                                                        <div class="mg-stock__icon-desc">Высокое теплосбережение</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="mega-menu__stock" data-system-banner="gotovie-rshenia"
                                         style="display:none;">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/gotovye-resheniya.jpeg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <div class="h3 mg-stock__title">Готовые решения</div>
                                                <p class="p mg-stock__desc">Чтобы выяснить более точно сколько стоит
                                                    пластиковое окно мы рекомендуем воспользоваться бесплатной услугой
                                                    вызова замерщика.</p>

                                            </div>


                                        </div>
                                    </div>


                                </div>
                            </li>

                            <!-- 9 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                                <a href="/osteklenie-balkonov-i-lodzhii/" class="no-style mega-menu-item ">
                                    <div class="mega-menu-item__label">Балконы и лоджии</div>
                                </a>

                                <div class="mega-menu__sub-container type-big-submenu js-mg-submenu-lv1">
                                    <ul class="mega-menu__submenu mg-submenu-lv1 type-big-submenu">


                                        <!-- 10 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/osteklenie-balkonov-i-lodzhii/teploe-osteklenie/">Теплое
                                                остекление </a>

                                        </li>

                                        <!-- 11 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/osteklenie-balkonov-i-lodzhii/holodnoe-osteklenie/">Холодное
                                                алюминиевое остекление </a>

                                        </li>

                                        <!-- 12 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/osteklenie-balkonov-i-lodzhii/francuzskoe-osteklenie/">Французское
                                                остекление </a>

                                        </li>

                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/osteklenie-balkonov-i-lodzhii/otdelka/">Отделка балконов и
                                                лоджий </a>

                                        </li>

                                        <!-- 16 -->


                                    </ul>
                                    <div class="mega-menu__stock">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/menu-2.jpg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <p class="p mg-stock__desc">Остекление балкона под ключ за 10 дней -
                                                    ЛЕГКО!</p>
                                                <a href="/osteklenie-balkonov-i-lodzhii/"
                                                   class="btn mg-stock__btn no-style">Подробнее</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>                <!-- 17 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                                <a href="/kottedzhi-i-doma/osteklenie/" class="no-style mega-menu-item ">
                                    <div class="mega-menu-item__label">Коттеджи и дачи</div>
                                </a>

                                <div class="mega-menu__sub-container type-big-submenu js-mg-submenu-lv1">
                                    <ul class="mega-menu__submenu mg-submenu-lv1 type-big-submenu">


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/kottedzhi-i-doma/osteklenie/">Остекление коттеджей и домов </a>

                                        </li>


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/kottedzhi-i-doma/osteklenie-besedok/">Остекление беседок и
                                                террас </a>

                                        </li>


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/kottedzhi-i-doma/dachnoe-osteklenie/">Дачное остекление </a>

                                        </li>

                                    </ul>
                                    <div class="mega-menu__stock">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/menu-3.jpg">
                                            </div>

                                            <div class="mg-stock__right">
                                                <p class="p mg-stock__desc">Остекление коттеджей, дач, беседок
                                                    Делаем правильный монтаж в Вологде!</p>
                                                <a href="/kottedzhi-i-doma/osteklenie/"
                                                   class="btn mg-stock__btn no-style">Подробнее</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>                <!-- 21 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                                <a href="/plastikovyye-dveri-s-ustanovkoy/" class="no-style mega-menu-item ">
                                    <div class="mega-menu-item__label">Двери</div>
                                </a>

                                <div class="mega-menu__sub-container type-big-submenu js-mg-submenu-lv1">
                                    <ul class="mega-menu__submenu mg-submenu-lv1 type-big-submenu">


                                        <!-- 22 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovyye-dveri-s-ustanovkoy/balkonnye/">Балконные блоки </a>

                                        </li>

                                        <!-- 23 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovyye-dveri-s-ustanovkoy/alyuminievaya-vhodnaya-gruppa/">Алюминиевая
                                                входная группа </a>

                                        </li>

                                        <!-- 24 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovyye-dveri-s-ustanovkoy/pvx/">Входная группа ПВХ </a>

                                        </li>

                                        <!-- 25 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/plastikovyye-dveri-s-ustanovkoy/portal/">Портальные системы
                                                дверей </a>

                                        </li>

                                    </ul>
                                    <div class="mega-menu__stock">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/menu-4.jpg">
                                            </div>

                                            <div class="mg-stock__right">

                                                <p class="p mg-stock__desc">Россрочки и выгодные условия! Индивидуальный
                                                    подход к каждому клиенту!</p>
                                                <a href="/plastikovyye-dveri-s-ustanovkoy/"
                                                   class="btn mg-stock__btn no-style">Подробнее</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>                <!-- 26 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                                <a href="/servis/" class="no-style mega-menu-item ">
                                    <div class="mega-menu-item__label">Сервис</div>
                                </a>

                                <div class="mega-menu__sub-container type-big-submenu js-mg-submenu-lv1">
                                    <ul class="mega-menu__submenu mg-submenu-lv1 type-big-submenu">


                                        <!-- 22 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/servis/zamena-uplotnitelya/">Замена уплотнителя, регулировка
                                                пластиковых окон и дверей</a>

                                        </li>

                                        <!-- 23 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/servis/zamena-steklopaketa/">Замена стеклопакета </a>

                                        </li>

                                        <!-- 24 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/servis/remont-i-zamena-furnitury/">Ремонт и замена фурнитуры </a>

                                        </li>

                                        <!-- 25 -->


                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label" href="/servis/zamena-otkosov/">Замена
                                                откосов и подоконникв, наружняя отделка окна </a>

                                        </li>
                                        <li class="mg-submenu-lv1__item js-mg-submenu-lv1-item ">
                                            <a class="no-style mg-submenu-lv1__label"
                                               href="/servis/detskaya-bezopasnost/">Детская безопасность </a>

                                        </li>

                                    </ul>
                                    <div class="mega-menu__stock">
                                        <div class="mg-stock">
                                            <div class="mg-stock__left">
                                                <img class="mg-stock__img lazyload"
                                                     data-src="/new_style_files/images/menu/menu-5.webp">
                                            </div>

                                            <div class="mg-stock__right">
                                                <p class="p mg-stock__desc">Сделаем красиво и уютнопо приятной цене!</p>
                                                <a href="/servis/" class="btn mg-stock__btn no-style">Подробнее</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>                <!-- 26 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item only-desktop">
                                <div class="mega-menu-item">
                                    <div class="mega-menu-item__label">Дополнительно</div>
                                </div>
                                <div class="mega-menu__submenu mg-submenu-lv1 mg-submenu-lv1_ul js-mg-submenu-lv1">

                                    <ul>
                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label mg-submenu-lv1__label_title"
                                               href="/services/"><b>Услуги</b></a>
                                        </li>
                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label " href="/company/director/">Служба
                                                сервиса</a>
                                        </li>


                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label "
                                               href="/services/ustanovka-plastikovih-okon/">Монтаж окон</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label mg-submenu-lv1__label_title"
                                               href="/aksessuary/"><b>Аксессуары</b></a>
                                        </li>
                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label "
                                               href="/aksessuary/moskitnye-setki/">Москитные сетки</a>
                                        </li>

                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label "
                                               href="/aksessuary/ruchki/">Ручки</a>
                                        </li>
                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label " href="/aksessuary/laminatsiya/">Ламинация
                                                окон</a>
                                        </li>

                                        <li class="mg-submenu-lv1__item">
                                            <a class="no-style mg-submenu-lv1__label " href="/aksessuary/shprosse/">Шпроссе</a>
                                        </li>
                                    </ul>
                                </div>

                            </li>

                            <!-- 55 -->


                            <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                                <a href="/actions/" class="no-style mega-menu-item ">
                                    <div class="mega-menu-item__label">Акции</div>
                                </a>
                                <div class="mega-menu__sub-container type-big-submenu type--slider js-mg-submenu-lv1">


                                    <div class="promotions-slider">
                                        <div class="promotions-slider__slider" data-promotions-slider="">

                                            <div class="swiper-wrapper">


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/8cf/zoryiwk4cxaov5ww1bbm9rnonim7a4wm.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Получайте подарки</div>
                                                        Москитная сетка, доставка, набор по уходу за окнами и другие
                                                        подарки при заказе остекления в {{$config['company']}}.
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/c9b/rw4uytsfz44pkia3todc87bzjtlkc7b2.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Скидка 20%</div>
                                                        Скидка 20% на ремонт пластиковых окон до 15 февраля.
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/f8f/hq6dkwenw169k2npu2fpotu53xygyc1p.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Безопасные окна</div>
                                                        Обеспечьте безопасность для Ваших детей. Скидка 15% на
                                                        специальную фурнитуру для окон.
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/358/f7uh233muxbtzdyiwl9oepel1g63ovlt.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Остекление зимой -
                                                            выгодно!
                                                        </div>
                                                        Не боимся холодов! Присоединяйся к нам!
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/119/v3kh9cfwdx9agf9w53ck9iix7trua4zr.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Окно Зимой? Легко!
                                                        </div>
                                                        Произведем монтаж зимой со скидкой 20%!
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/272/chdw0387km1ejfle09piqanfid13ek9e.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Красивые лоджии и
                                                            балконы у нас!
                                                        </div>
                                                        Отделка на утепление и обшивку до 15%!
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/ab4/x7pjlio11mwhfgy7y9ol75jm9ev0tn3z.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Спасаем кошек</div>
                                                        Получите цену за 1 м2 сетки «антикошка» всего 2500 рублей.
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/224/lkbipswzspw4h8xus0q9dix81byz9wh1.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Нам 3 года - Вам 30%
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="swiper-slide promotions-slider__card">
                                                    <div class="promotions-slider__img">
                                                        <img alt="" class="img lazyload"
                                                             data-src="/upload/resize_cache/webp/iblock/ee7/bbm8u4l51akdj8vwl717rwwx32whkkka.webp">
                                                    </div>
                                                    <div class="promotions-slider__desc">
                                                        <div class="h3 promotions-slider__title">Антикризисные окна за 3
                                                            549р.
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="promotions-slider__prev" data-promotions-slider-prev="">
                                                <svg class="promotions-slider__prev-icon">
                                                    <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                                </svg>
                                            </div>
                                            <div class="promotions-slider__next nx-list-slider__next"
                                                 data-promotions-slider-next="">
                                                <svg class="promotions-slider__next-icon">
                                                    <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            </li>

                            <!-- 56 -->


                            <!-- test2 -->
                            <!-- EXTRA -->


                            <!-- wtf-action-3 -->
                        </ul>

                        <div class="head-slider__prev" data-head-slider-prev="">
                            <svg class="head-slider__prev-icon">
                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                            </svg>
                        </div>
                        <div class="head-slider__next" data-head-slider-next="">
                            <svg class="head-slider__next-icon">
                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </nav>


        <nav class="mob-mega-menu js-mob-mega-menu">
            <div class="mob-mega-menu__overlay js-mb-overlay"></div>
            <div class="mob-mega-menu__box">
                <div class="mob-mega-menu__container">
                    <div class="mob-mega-menu__top">
                        <div class="mob-mega-menu__action-box js-mob-mg__action-box"></div>


                        <ul>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">Пластиковые окна</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/"
                                           class="no-style mob-mg-submenu__head-label">
                                            Окна Exprof </a>
                                    </div>
                                    <ul class="mob-mg-submenu__list">


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Пластиковые окна с установкой</div>
                                            </a>
                                        </li>

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-prowin/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Exprof Prowin</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-profekta/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Exprof Profecta</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-experta/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Exprof Experta</div>
                                            </a>
                                        </li>
                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/gotovye-resheniya/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Готовые решения</div>
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </li>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">Балконы и лоджии</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <a href="/osteklenie-balkonov-i-lodzhii/"
                                           class="no-style mob-mg-submenu__head-label">
                                            Балконы и лоджии </a>
                                    </div>
                                    <ul class="mob-mg-submenu__list">


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/osteklenie-balkonov-i-lodzhii/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Остекление балконов и лоджий</div>
                                            </a>
                                        </li>

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/osteklenie-balkonov-i-lodzhii/teploe-osteklenie/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Теплое остекление</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/osteklenie-balkonov-i-lodzhii/holodnoe-osteklenie/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Холодное алюминиевое остекление</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/osteklenie-balkonov-i-lodzhii/francuzskoe-osteklenie/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Французское остекление</div>
                                            </a>
                                        </li>

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/osteklenie-balkonov-i-lodzhii/otdelka/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Отделка балконов и лоджий</div>
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </li>

                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">Коттеджи и дачи</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <a href="/kottedzhi-i-doma/osteklenie/"
                                           class="no-style mob-mg-submenu__head-label">
                                            Коттеджи и дачи </a>
                                    </div>
                                    <ul class="mob-mg-submenu__list">


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/kottedzhi-i-doma/osteklenie/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Остекление коттеджей и домов</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/kottedzhi-i-doma/osteklenie-besedok/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Остекление беседок и террас</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/kottedzhi-i-doma/dachnoe-osteklenie/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Дачное остекление</div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">Двери</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <a href="/plastikovyye-dveri-s-ustanovkoy/"
                                           class="no-style mob-mg-submenu__head-label">
                                            Двери </a>
                                    </div>
                                    <ul class="mob-mg-submenu__list">


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovyye-dveri-s-ustanovkoy/balkonnye/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Балконные блоки</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovyye-dveri-s-ustanovkoy/alyuminievaya-vhodnaya-gruppa/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Алюминиевая входная группа</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovyye-dveri-s-ustanovkoy/pvx/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Входная группа ПВХ</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/plastikovyye-dveri-s-ustanovkoy/portal/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Портальные системы дверей</div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">Сервис</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <a href="/servis/" class="no-style mob-mg-submenu__head-label">
                                            Сервис </a>
                                    </div>
                                    <ul class="mob-mg-submenu__list">


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/servis/zamena-uplotnitelya/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Замена уплотнителя, регулировка
                                                    пластиковых окон и дверей
                                                </div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/servis/zamena-steklopaketa/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Замена стеклопакета</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/servis/remont-i-zamena-furnitury/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Ремонт и замена фурнитуры</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/servis/zamena-otkosov/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Замена откосов и подоконникв, наружняя
                                                    отделка окна
                                                </div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/servis/detskaya-bezopasnost/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Детская безопасность</div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">Дополнительно</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <span class="no-style mob-mg-submenu__head-label">
																Дополнительно																	</span>
                                    </div>
                                    <ul class="mob-mg-submenu__list">
                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/services/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label"><b>Услуги</b></div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/services/feedback/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Служба сервиса</div>
                                            </a>
                                        </li>
                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/services/vyzov-zamershhika/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Замер окна</div>
                                            </a>
                                        </li>
                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/services/ustanovka-plastikovih-okon/"
                                               class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Монтаж окон</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/aksessuary/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label"><b>Аксессуары</b></div>
                                            </a>
                                        </li>

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/aksessuary/moskitnye-setki/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Москитные сетки</div>
                                            </a>
                                        </li>

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/aksessuary/ruchki/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Ручки</div>
                                            </a>
                                        </li>
                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/aksessuary/laminatsiya/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Ламинация окон</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/aksessuary/shprosse/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Шпроссе</div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <a href="/actions/" class="no-style mob-mg-item">
                                    <div class="mob-mg-item__label">Акции</div>
                                </a>
                            </li>


                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <div class="mob-mg-item">

                                    <div class="mob-mg-item__label">О нас</div>
                                    <div class="mob-mg-item__arrow">
                                        <svg class="ico">
                                            <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-right"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mob-mega-menu__submenu mob-mg-submenu js-mg-submenu">
                                    <div class="mob-mg-submenu__head">
                                        <div class="mob-mg-submenu__head-back js-mob-mg-back">
                                            <svg class="ico">
                                                <use xlink:href="/public/src/balcony/images/interface.svg#short-arrow-left"></use>
                                            </svg>
                                        </div>
                                        <a href="/company/" class="no-style mob-mg-submenu__head-label">
                                            О нас </a>
                                    </div>
                                    <ul class="mob-mg-submenu__list">

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/company/reviews/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Отзывы клиентов</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/company/certificate/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Сертификаты качества</div>
                                            </a>
                                        </li>
                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/company/news/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Новости</div>
                                            </a>
                                        </li>


                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/company/articles/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Статьи</div>
                                            </a>
                                        </li>

                                        <li class="mob-mg-submenu__item js-mob-mg-item">
                                            <a href="/company/director/" class="no-style mob-mg-item">
                                                <div class="mob-mg-item__label">Написать Директору</div>
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </li>

                            <li class="mob-mega-menu__item js-mob-mg-item">
                                <a href="/contacts/" class="no-style mob-mg-item">
                                    <div class="mob-mg-item__label">Контакты</div>
                                </a>
                            </li>


                            <li>
                                <a class="no-style btn" style="margin: 15px 30px;width:calc(100% - 60px)"
                                   href="/payment/">Оплата онлайн</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="side-labels">
        </div>


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

        <!-- Ваш HTML-код -->

        <!-- JavaScript-код для анимации кнопки WhatsApp -->
        <script>
           window.addEventListener("scroll", function () {
              const button = document.querySelector(".whatsapp-button");
              button.style.opacity = window.scrollY > 100 ? "1" : "0";
              button.style.transition = "opacity 0.5s";
           });
        </script>



        <section class="tile-advantage">
            <div class="inner-container tile-advantage__container">
                <h2 class="h2 section-header">Почему нас выбирают?</h2>
                <div class="tile-advantage__wrap tile-advantage__col3">
                    <div class="tile-advantage__item tile-advantage__item-s2">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload" src="{{$data['images']}}advantages/1.webp">
                            </div>
                            <div class="tile-advantage__title">Принимаем заявки 24/7</div>
                        </div>
                    </div>
                    <div class="tile-advantage__item ">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     src="{{$data['images']}}advantages/2.webp">
                            </div>
                            <div class="tile-advantage__title">Бесплатный замер</div>
                        </div>
                    </div>
                    <div class="tile-advantage__item ">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     src="{{$data['images']}}advantages/3.webp">
                            </div>
                            <div class="tile-advantage__title">Лучшие цены в Вологде</div>
                        </div>
                    </div>
                    <div class="tile-advantage__item ">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     src="{{$data['images']}}advantages/4.webp">
                            </div>

                            <div class="tile-advantage__title">Кратчайшие сроки</div>
                        </div>
                    </div>
                    <div class="tile-advantage__item tile-advantage__item-s2">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     src="{{$data['images']}}advantages/5.webp">
                            </div>

                            <div class="tile-advantage__title">Более 700 000м2 остекленных объектов</div>
                        </div>
                    </div>
                    <div class="tile-advantage__item ">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     src="{{$data['images']}}advantages/6.webp">
                            </div>
                            <div class="tile-advantage__title">Гарантия на окна 3 года</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="free-meas-form js-free-meas-form">
            <div class="inner-container free-meas-form__container">
                <div class="free-meas-form__block">
                    <div class="free-meas-form__bg">
                        <img class="img lazyload"
                             src="{{$data['images']}}advantages/6.webp">
                    </div>

                    <div class="free-meas-form__row">
                        <form class="free-meas-form__form" action="/ajax/?controller=form&action=add">
                            <input type="hidden" name="form" value="zamer">
                            <input type="hidden" name="attribute" value="ct">
                            <div class="free-meas-form__content">
                                <div class="free-meas-form__title-block">
                                    <div class="h2 free-meas-form__title">Запишитесь на бесплатный замер</div>
                                    <!-- <div class="free-meas-form__subtitle"><sup>*</sup> Оконных и дверных конструкций</div> -->
                                </div>
                                <div class="free-meas-form__group">
                                    <div class="control free-meas-form__fio">
                                        <div class="control__group">
                                            <label class="control__label">Ваше имя</label>
                                            <input class="control__input js-user-name" placeholder="Иван" name="name"
                                                   type="text" autocomplete="name">
                                        </div>
                                    </div>
                                    <div class="control free-meas-form__phone">
                                        <div class="control__group">
                                            <label class="control__label">Номер телефона</label>
                                            <input class="control__input js-user-phone" placeholder="+7(999)888-77-66"
                                                   name="phone" type="tel" autocomplete="tel">
                                        </div>
                                    </div>
                                    <button class="btn btn--red free-meas-form__btn">Записаться</button>
                                    <div class="free-meas-form__person-data">
                                        <label class="checkbox-small checkbox-small--white">
                                            <input class="checkbox-small__input js-person-data" type="checkbox"
                                                   name="person-data" id="free-meas__person-data">
                                            <label class="checkbox-small__checkbox"
                                                   for="free-meas__person-data"></label>
                                            <span class="checkbox-small__label">Нажимая на кнопку «Записаться», я даю согласие на <a
                                                        href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                        href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </section>

        <section class="tile-advantage company-block">

            <h2 class="h2 section-header">О компании</h2>
            <div class="stock-banner js-stock-banner-2">
                <div class="stock-banner__slider swiper js-stock-banner-slider-2">
                    <div class="stock-banner__wrap swiper-wrapper">


                        <div class="stock-banner__item swiper-slide js-stock-banner-slide-2" data-is-video="false"
                             data-desktop-video="" data-mobile-video="" data-slide-index="0" data-mobile-color=""
                             data-text-color="">
                            <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale ">
                                <img alt="Собственное производство" width="1200" height="650" class="lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                     data-src="/upload/resize_cache/webp/iblock/883/lw50c33gpv2h8i7sng9nelxapr9uc8a9.webp"
                                     data-srcset="/upload/resize_cache/iblock/883/500_100000_1/lw50c33gpv2h8i7sng9nelxapr9uc8a9.jpg 500w, /upload/resize_cache/webp/iblock/883/lw50c33gpv2h8i7sng9nelxapr9uc8a9.webp 1920w">
                            </div>

                            <div class="stock-banner__item-content">


                                <div class="h2 stock-banner__item-title js-slide-title">Собственное производство</div>

                                <div class="stock-banner__item-desc js-slide-desc">
                                    <div class="p">Полный контроль – мы несем ответственность за изготовление изделий.
                                        Поэтому очень важно иметь возможность контролировать процесс создания изделия от
                                        эскиза до готового продукта.
                                        Независимость – со своим производством мы не зависимы от поставщиков извне.
                                        Работа со «своим» коллективом и машинами делает нас независимыми от внешних
                                        обстоятельств.
                                    </div>
                                </div>

                                <div class="stock-banner__spacer"></div>
                                <div class="stock-banner__btn">
                                    <a class="no-style btn
																	btn--red																"
                                       data-modal-window="#modal-zamer" href="">
                                        Записаться на замер </a>
                                    <a class="no-style btn
																	btn--blue																									only-desktop
								" href="#">
                                        Подробнее </a>

                                </div>
                            </div>
                        </div>

                        <div class="stock-banner__item swiper-slide js-stock-banner-slide-2" data-is-video="false"
                             data-desktop-video="" data-mobile-video="" data-slide-index="1" data-mobile-color=""
                             data-text-color="">
                            <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale ">
                                <img alt="Наша команда" width="1200" height="798" class="lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                     data-src="/upload/resize_cache/webp/iblock/a7f/318fat6au5f87pe0zs4n2463d7bedwdq.webp"
                                     data-srcset="/upload/resize_cache/iblock/a7f/500_100000_1/318fat6au5f87pe0zs4n2463d7bedwdq.jpg 500w, /upload/resize_cache/webp/iblock/a7f/318fat6au5f87pe0zs4n2463d7bedwdq.webp 1920w">
                            </div>

                            <div class="stock-banner__item-content">


                                <div class="h2 stock-banner__item-title js-slide-title">Наша команда</div>

                                <div class="stock-banner__item-desc js-slide-desc">
                                    <div class="p">Командная работа настолько важна, что практически невозможно достичь
                                        высот ваших способностей или заработать желаемых денег, не достигнув успеха в
                                        команде.
                                    </div>
                                </div>

                                <div class="stock-banner__spacer"></div>
                                <div class="stock-banner__btn">
                                    <a class="no-style btn
																	btn--red																"
                                       data-modal-window="#modal-zamer" href="">
                                        Записаться на замер </a>
                                    <a class="no-style btn
																	btn--blue																									only-desktop
								" href="/company/employees/">
                                        Подробнее </a>

                                </div>
                            </div>
                        </div>

                        <div class="stock-banner__item swiper-slide js-stock-banner-slide-2" data-is-video="false"
                             data-desktop-video="" data-mobile-video="" data-slide-index="2" data-mobile-color=""
                             data-text-color="">
                            <div class="stock-banner__item-bg stock-banner__item-bg--animation-scale ">
                                <img alt="Проекты" width="4284" height="5712" class="lazyload"
                                     src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                     data-src="/upload/resize_cache/webp/iblock/fff/dpkx0ii0c96l7d8bytkxvp3sf1laz94r.webp"
                                     data-srcset="/upload/resize_cache/iblock/fff/500_100000_1/dpkx0ii0c96l7d8bytkxvp3sf1laz94r.jpg 500w, /upload/resize_cache/webp/iblock/fff/dpkx0ii0c96l7d8bytkxvp3sf1laz94r.webp 1920w">
                            </div>

                            <div class="stock-banner__item-content">


                                <div class="h2 stock-banner__item-title js-slide-title">Проекты</div>

                                <div class="stock-banner__item-desc js-slide-desc">
                                    <div class="p">Проект - это сложная система, состоящая из взаимосвязанных
                                        динамических частей, требующая особого подхода к управлению. При нажатии на
                                        каждый из баннеров попадать в соответсвующий раздел.
                                    </div>
                                </div>

                                <div class="stock-banner__spacer"></div>
                                <div class="stock-banner__btn">
                                    <a class="no-style btn
																	btn--red																"
                                       data-modal-window="#modal-zamer" href="">
                                        Записаться на замер </a>
                                    <a class="no-style btn
																	btn--blue																									only-desktop
								" href="#">
                                        Подробнее </a>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="stock-banner__pagination swiper-pagination js-stock-banner-pagination-2"></div>
                <div class="stock-banner__tabs">
                    <div class="stock-banner-tabs">
                        <div class="stock-banner-tabs__wrap">


                            <div class="stock-banner-tabs__item js-stock-banner-tab-2 active" data-slide-index="0">
                                <div class="h6 stock-banner-tabs__title">Собственное производство</div>
                                <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                            </div>


                            <div class="stock-banner-tabs__item js-stock-banner-tab-2" data-slide-index="1">
                                <div class="h6 stock-banner-tabs__title">Наша команда</div>
                                <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                            </div>


                            <div class="stock-banner-tabs__item js-stock-banner-tab-2" data-slide-index="2">
                                <div class="h6 stock-banner-tabs__title">Проекты</div>
                                <div class="stock-banner-tabs__progress-bar js-stock-banner-bar"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="tile-advantage">
            <div class="inner-container tile-advantage__container">
                <h2 class="h2 section-header">Сервисные услуги</h2>


                <div class="tile-advantage__wrap tile-advantage__col3">


                    <a href="/servis/zamena-uplotnitelya/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/570/a50f1qs1f0f52b3tfi6t218c25ohza5p.webp">
                            </div>

                            <div class="tile-advantage__title">Замена уплотнителя</div>
                        </div>
                    </a>

                    <a href="/servis/zamena-uplotnitelya/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/326/mdblwucecpswee4cd296uvxtp4qu6vks.webp">
                            </div>

                            <div class="tile-advantage__title">Регулировка пластиковых окон</div>
                        </div>
                    </a>

                    <a href="/aksessuary/ruchki/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/1f7/vpo7mjd74vvwo7mvv11iiagwrg96dw6q.webp">
                            </div>

                            <div class="tile-advantage__title">Замена ручек</div>
                        </div>
                    </a>

                    <a href="/servis/zamena-steklopaketa/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/904/kz8pds5s7z9n1lgs196cs2u23rvtetdf.webp">
                            </div>

                            <div class="tile-advantage__title">Замена стеклопакета</div>
                        </div>
                    </a>

                    <a href="/servis/zamena-otkosov/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/1d1/6yqn28hfivzsvr2rk37viuk20gjs6va2.webp">
                            </div>

                            <div class="tile-advantage__title">Замена откосов</div>
                        </div>
                    </a>

                    <a href="/aksessuary/podokonniki/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/e3c/7mppxhmhg211sj3wkjp6oz9zfk25cgjb.webp">
                            </div>

                            <div class="tile-advantage__title">Установка подоконника</div>
                        </div>
                    </a>

                    <a href="/servis/remont-i-zamena-furnitury/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/101/3jp0b03k2xv2ettoz1iso3735vgxlbdj.webp">
                            </div>

                            <div class="tile-advantage__title">Ремонт и замена фурнитуры</div>
                        </div>
                    </a>

                    <a href="/servis/zamena-otkosov/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/ceb/b64ca4v0gue6h5m3pgeiwq06bgzqt3oe.webp">
                            </div>

                            <div class="tile-advantage__title">Наружная отделка окна: отливы и козырьки</div>
                        </div>
                    </a>

                    <a href="/servis/detskaya-bezopasnost/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/cdc/ytbazuvk7mrzk3f8ilrhdsiictlaqcz8.webp">
                            </div>

                            <div class="tile-advantage__title">Детская безопасность</div>
                        </div>
                    </a>

                    <a href="/aksessuary/moskitnye-setki/" class="tile-advantage__item">
                        <div class="tile-advantage__card tile-card ">
                            <div class="tile-advantage__card-bg">
                                <img class="img lazyload"
                                     data-src="/upload/resize_cache/webp/iblock/5ee/0iqcp7h9gjyxuvt4ps6191x25y9aro7c.webp">
                            </div>

                            <div class="tile-advantage__title">Москитные сетки от производителя</div>
                        </div>
                    </a>
                </div>
            </div>
        </section>


        <section class="actions-carousel js-actions-carousel">

            <div class="inner-container">
                <div class="h2 section-header">Наши акции</div>
            </div>


            <div class="inner-container full-width actions-carousel__container">
                <div class="swiper swiper-action js-actions-carousel-swiper actions-carousel__content">
                    <div class="swiper-wrapper actions-carousel__wrapper">


                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/8cf/zoryiwk4cxaov5ww1bbm9rnonim7a4wm.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Получайте подарки
                                    </div>

                                    <div class="simple-card__desc">Москитная сетка, доставка, набор по уходу за окнами и
                                        другие подарки при заказе остекления в {{$config['company']}}.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/c9b/rw4uytsfz44pkia3todc87bzjtlkc7b2.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Скидка 20%
                                    </div>

                                    <div class="simple-card__desc">Скидка 20% на ремонт пластиковых окон до 15
                                        февраля.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/f8f/hq6dkwenw169k2npu2fpotu53xygyc1p.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Безопасные окна
                                    </div>

                                    <div class="simple-card__desc">Обеспечьте безопасность для Ваших детей. Скидка 15%
                                        на специальную фурнитуру для окон.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/358/f7uh233muxbtzdyiwl9oepel1g63ovlt.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Остекление зимой - выгодно!
                                    </div>

                                    <div class="simple-card__desc">Не боимся холодов! Присоединяйся к нам!</div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/119/v3kh9cfwdx9agf9w53ck9iix7trua4zr.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Окно Зимой? Легко!
                                    </div>

                                    <div class="simple-card__desc">Произведем монтаж зимой со скидкой 20%!</div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>


                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/ab4/x7pjlio11mwhfgy7y9ol75jm9ev0tn3z.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Спасаем кошек
                                    </div>

                                    <div class="simple-card__desc">Получите цену за 1 м2 сетки «антикошка» всего 2500
                                        рублей.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/224/lkbipswzspw4h8xus0q9dix81byz9wh1.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Нам 3 года - Вам 30%
                                    </div>

                                    <div class="simple-card__desc"></div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="swiper-slide actions-carousel__item">
                            <div class="simple-card simple-card--actions">
                                <div class="simple-card__img">

                                    <img width="400"
                                         data-src="/upload/resize_cache/webp/iblock/ee7/bbm8u4l51akdj8vwl717rwwx32whkkka.webp"
                                         class="lazyload img action-slide-img" height="200">
                                </div>
                                <div class="simple-card__body">
                                    <div class="no-style simple-card__title">
                                        Антикризисные окна за 3 549р.
                                    </div>

                                    <div class="simple-card__desc"></div>
                                </div>
                                <div class="simple-card__bottom">
                                    <button class="btn btn--red" data-modal-window="#modal-calc-win">Заказать расчет
                                    </button>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="arrow-box arrow-box--right arrow-box--blue js-arrow-right">
                        <div class="arrow-ico"></div>
                    </div>
                    <div class="arrow-box arrow-box--left arrow-box--blue js-arrow-left">
                        <div class="arrow-ico arrow-ico--left"></div>
                    </div>
                </div>


            </div>
        </section>


        <section class="lamin-color" data-action="/ajax/?controller=laminations&action=getlist&section-id=32">
            <div class="inner-container lamin-color__container">
                <div class="h2 section-header">Выбор цвета ламинации</div>
                <vue-app id="vue-lamin-color" data-type="32">
                    <lamin-color></lamin-color>
                </vue-app>
            </div>
        </section>


        <section class="rassrochka">
            <div class="rassrochka__container inner-container">
                <h2 class="h2 section-header">Честная рассрочка без процентов</h2>

                <div class="rassrochka__banner">
                    <div class="rassrochka__banner-bg">
                        <img class="img banner-desk lazyload"
                             data-src="/new_style_files/upload/img_verstka/rassrochka/rassrochka.jpg" alt=""
                             width="1170" height="420">
                        <img class="img banner-mob lazyload"
                             data-src="/new_style_files/upload/img_verstka/rassrochka/rassrochka.jpg" alt=""
                             width="1170" height="420">
                    </div>
                    <div class="rassrochka__banner-items">
                        <div class="rassrochka__item">
                            <div class="rassrochka__item-num"><span>1</span></div>
                            <div class="rassrochka__item-title">Оформите заявку</div>
                            <div class="rassrochka__item-desk">Менеджер подберет для Вас комфортные условия по
                                рассрочке.
                            </div>
                        </div>
                        <div class="rassrochka__item">
                            <div class="rassrochka__item-num"><span>2</span></div>
                            <div class="rassrochka__item-title">Внесите предоплату</div>
                            <div class="rassrochka__item-desk">Внесите 20% от суммы договора. Остаток суммы вносите
                                равными долями в течение 4-х месяцев.
                            </div>
                        </div>
                        <div class="rassrochka__item">
                            <div class="rassrochka__item-num"><span>3</span></div>
                            <div class="rassrochka__item-title">Наслаждайтесь комфортом</div>
                            <div class="rassrochka__item-desk">Наслаждайся новыми окнами/остеклением балкона уже сейчас-
                                плати потом!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="free-meas-form js-free-meas-form">
            <div class="inner-container free-meas-form__container">
                <div class="free-meas-form__block">
                    <div class="free-meas-form__bg">
                        <img class="img lazyload"
                             data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp">
                    </div>

                    <div class="free-meas-form__row">
                        <form class="free-meas-form__form" action="/ajax/?controller=form&action=add">
                            <input type="hidden" name="form" value="zamer">
                            <input type="hidden" name="attribute" value="ct">
                            <div class="free-meas-form__content">
                                <div class="free-meas-form__title-block">
                                    <div class="h2 free-meas-form__title">Запишитесь на бесплатный замер</div>
                                    <!-- <div class="free-meas-form__subtitle"><sup>*</sup> Оконных и дверных конструкций</div> -->
                                </div>
                                <div class="free-meas-form__group">
                                    <div class="control free-meas-form__fio">
                                        <div class="control__group">
                                            <label class="control__label">Ваше имя</label>
                                            <input class="control__input js-user-name" placeholder="Иван" name="name"
                                                   type="text" autocomplete="name">
                                        </div>
                                    </div>
                                    <div class="control free-meas-form__phone">
                                        <div class="control__group">
                                            <label class="control__label">Номер телефона</label>
                                            <input class="control__input js-user-phone" placeholder="+7(999)888-77-66"
                                                   name="phone" type="tel" autocomplete="tel">
                                        </div>
                                    </div>
                                    <button class="btn btn--red free-meas-form__btn">Записаться</button>
                                    <div class="free-meas-form__person-data">
                                        <label class="checkbox-small checkbox-small--white">
                                            <input class="checkbox-small__input js-person-data" type="checkbox"
                                                   name="person-data" id="free-meas__person-data">
                                            <label class="checkbox-small__checkbox"
                                                   for="free-meas__person-data"></label>
                                            <span class="checkbox-small__label">Нажимая на кнопку «Записаться», я даю согласие на <a
                                                        href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                        href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <section class="tile-advantage">
                    <div class="inner-container tile-advantage__container">
                        <br><br><br>
                        <h2 class="h2 section-header">Порядок выполнения работ</h2>
                        <div class="tile-advantage__wrap tile-advantage__col3">
                            <div class="tile-advantage__item poriadok">
                                <div class="tile-advantage__card tile-card ">
                                    <div class="tile-advantage__card-bg">
                                        <img class="img lazyload"
                                             data-src="/new_style_files/images/poriadok/poriadok-1.jpg">
                                    </div>

                                    <div class="tile-advantage__ico">
                                        1
                                    </div>

                                    <div class="tile-advantage__title">Оформление заявки</div>
                                </div>
                            </div>
                            <div class="tile-advantage__item poriadok">
                                <div class="tile-advantage__card tile-card ">
                                    <div class="tile-advantage__card-bg">
                                        <img class="img lazyload"
                                             data-src="/new_style_files/images/poriadok/poriadok-2.png">
                                    </div>
                                    <div class="tile-advantage__ico">
                                        2
                                    </div>
                                    <div class="tile-advantage__title">Выезд специалиста</div>
                                </div>
                            </div>
                            <div class="tile-advantage__item poriadok">
                                <div class="tile-advantage__card tile-card ">
                                    <div class="tile-advantage__card-bg">
                                        <img class="img lazyload"
                                             data-src="/new_style_files/images/poriadok/poriadok-3.jpeg">
                                    </div>
                                    <div class="tile-advantage__ico">
                                        3
                                    </div>
                                    <div class="tile-advantage__title">Замер</div>
                                </div>
                            </div>
                            <div class="tile-advantage__item poriadok">
                                <div class="tile-advantage__card tile-card ">
                                    <div class="tile-advantage__card-bg">
                                        <img class="img lazyload"
                                             data-src="/new_style_files/images/poriadok/poriadok-4.jpg">
                                    </div>

                                    <div class="tile-advantage__ico">
                                        4
                                    </div>
                                    <div class="tile-advantage__title">Заключение договра и оформление гарантии</div>
                                </div>
                            </div>
                            <div class="tile-advantage__item poriadok">
                                <div class="tile-advantage__card tile-card ">
                                    <div class="tile-advantage__card-bg">
                                        <img class="img lazyload"
                                             data-src="/new_style_files/images/poriadok/poriadok-5.jpeg">
                                    </div>

                                    <div class="tile-advantage__ico">
                                        5
                                    </div>
                                    <div class="tile-advantage__title">Доставка и монтаж</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section>
                    <div class="free-meas-form__info">
                        <div class="free-meas-form__info-header">
                            После этого мы:
                        </div>
                        <div class="free-meas-form__info-item">
                            <div class="free-meas-form__info-ico">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/free-meas-form.svg#manager-person"></use>
                                </svg>
                            </div>
                            <p class="p free-meas-form__info-title">Перезвоним и ответим на все вопросы</p>
                        </div>
                        <div class="free-meas-form__info-item">
                            <div class="free-meas-form__info-ico">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/free-meas-form.svg#calculator"></use>
                                </svg>
                            </div>
                            <p class="p free-meas-form__info-title">Произведём замер и подготовим расчёт</p>
                        </div>
                        <div class="free-meas-form__info-item">
                            <div class="free-meas-form__info-ico">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/free-meas-form.svg#box-pack"></use>
                                </svg>
                            </div>
                            <p class="p free-meas-form__info-title">Оформим заказ. Возможна рассрочка 0%</p>
                        </div>
                        <div class="free-meas-form__info-item">
                            <div class="free-meas-form__info-ico">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/free-meas-form.svg#delivery-time"></use>
                                </svg>
                            </div>
                            <p class="p free-meas-form__info-title">Изготовим, привезём и установим за 7 дней</p>
                        </div>
                        <div class="free-meas-form__info-item">
                            <div class="free-meas-form__info-ico">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/free-meas-form.svg#smile"></use>
                                </svg>
                            </div>
                            <p class="p free-meas-form__info-title">Пожелаем отличного настроения!</p>
                        </div>
                    </div>
                </section>
            </div>

        </section>

        <section class="faq-quest js-faq-quest">
            <div class="inner-container faq-quest__container">
                <div class="h2 faq-quest__title">Часто задаваемые вопросы</div>


                <div class="faq-quest__content">


                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    Возможно ли устанавливать окна зимой?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Да, установка пластиковых окон вполне возможна в зимний период. Здесь ключевым
                                    фактором является использование специальной монтажной пены для холодных условий. Эта
                                    зимняя монтажная пена позволяет проводить установку пластиковых окон даже при
                                    температурах до -12°C. Установка окон зимой имеет свои преимущества, такие как
                                    возможность немедленно проверить герметичность монтажных швов.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    Мне надо нанимать грузчиков для подъема?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Нет, мы сами все довезем и внесем.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    Какие особенности отличают одни ПВХ профили от других?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>ПВХ профиль может отличаться по следующим характеристикам: ширине, количеству камер,
                                    числу уплотнительных контуров, толщине стенок, наличию армирования и максимальной
                                    ширине стеклопакета.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    Хотелось бы отделать балкон, можете помочь?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Да, конечно! Остеклим, утеплим, оформим стильными отделочными материалами из нашего
                                    каталога.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    В каких ситуациях необходим демонтаж пластиковых окон?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Популярность пластиковых окон объясняется их долговечностью, которая может достигать
                                    до 60 лет. Поэтому вопрос демонтажа и замены обычно возникает при желании установить
                                    новые стеклопакеты с более высокой теплоизоляцией и энергосберегающими
                                    характеристиками, а также в случае повреждения оконной рамы или стекла.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    Зачем вызывать замерщика? Я могу дать размеры…
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Точный замер – это гарантия, что все четко встанет на место. Мы доверяем нашим
                                    клиентам, но рекомендуем обращаться к опытным специалистам для замера и последующей
                                    установки пластиковых окон.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    В чем разница между холодным и теплым остеклением?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Основные отличия заключаются в материалах, используемых для изготовления конструкции,
                                    уровне теплоизоляции, герметичности и, конечно, в стоимости. Холодное остекление
                                    является более доступным с точки зрения затрат, в основном из-за использования более
                                    простых материалов и более простого процесса монтажа, по сравнению с теплым
                                    остеклением.</p>
                            </div>
                        </details>
                    </div>

                    <div class="faq-quest__item">
                        <details class="accordion js-accordion">
                            <summary class="accordion__header">
                                <div>
                                    Какие существуют способы оплаты?
                                    <div class="accordion__marker">
                                        <div class="accordion__marker-arrow arrow-box arrow-box--small">
                                            <div class="arrow-ico arrow-ico--down"></div>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                            <div class="accordion__content">
                                <p>Несколько вариантов: наличными замерщику, наличными в офисе, через терминал,
                                    перевод.</p>
                            </div>
                        </details>
                    </div>

                </div>

            </div>
        </section>


        <section class="actions-carousel js-actions-carousel">

            <div class="inner-container">
                <h2 class="h2 section-header">Полезные статьи</h2>
            </div>

            <div class="inner-container full-width actions-carousel__container">
                <div class="swiper swiper-action js-actions-carousel-swiper actions-carousel__content swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                    <div class="swiper-wrapper actions-carousel__wrapper"
                         style="transform: translate3d(0px, 0px, 0px);">


                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Топ-5 ошибок при утеплении окон и балконов своими руками"
                                         data-src="/upload/resize_cache/webp/iblock/dd1/2wtnm4qllkj2qbfj5gnym5v5m0ff1qkj.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">22.09.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Топ-5 ошибок при утеплении окон и балконов своими
                                        руками
                                    </div>
                                    <div class="simple-card__desc">Мы собрали самые распространённые промахи и
                                        рассказали, как их избежать.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/top-5-oshibok-pri-uteplenii-okon-i-balkonov-svoimi-rukami/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Пластиковые двери для загородного дома: на что обратить внимание перед зимой"
                                         data-src="/upload/resize_cache/webp/iblock/51b/0evnsleur6kocpic18b5pbxo2ba01efi.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">16.09.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Пластиковые двери для загородного дома: на что
                                        обратить внимание перед зимой
                                    </div>
                                    <div class="simple-card__desc">Рассмотрим, какие характеристики пластиковых дверей
                                        стоит проверить или учесть при выборе и подготовке к зиме.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/plastikovye-dveri-dlya-zagorodnogo-doma-na-chto-obratit-vnimanie-pered-zimoy/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Когда нужна герметизация и зачем: сохраняем тепло надолго"
                                         data-src="/upload/iblock/b5a/y9tapvon9zxx2k0wpn1n0s5sexwkj0ky.jpg"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">27.08.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Когда нужна герметизация и зачем: сохраняем тепло
                                        надолго
                                    </div>
                                    <div class="simple-card__desc">Разберёмся, когда она необходима, какие бывают
                                        способы и почему экономить на этом не стоит.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kogda-nuzhna-germetizatsiya-i-zachem-sokhranyaem-teplo-nadolgo/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Тонкости ламинации окон: почему стоит или не стоит выбирать цветной профиль"
                                         data-src="/upload/iblock/23c/zq9a3ko3j29c4f3v1lzjq27kkh2d0c9i.jpg"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">18.08.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Тонкости ламинации окон: почему стоит или не стоит
                                        выбирать цветной профиль
                                    </div>
                                    <div class="simple-card__desc">Прежде чем заказать цветные окна, стоит разобраться в
                                        особенностях, плюсах и минусах ламинации.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/tonkosti-laminatsii-okon-pochemu-stoit-ili-ne-stoit-vybirat-tsvetnoy-profil/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Портальные двери: что это такое и в чем их преимущество?"
                                         data-src="/upload/iblock/890/4lz5m9qblawr7s8b4p91q3ivepvoo9go.jpg"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">21.07.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Портальные двери: что это такое и в чем их
                                        преимущество?
                                    </div>
                                    <div class="simple-card__desc">Разберемся, что такое портальные двери и почему они
                                        становятся выбором №1 у тех, кто ценит комфорт и эстетику.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/portalnye-dveri-chto-eto-takoe-i-v-chem-ikh-preimushchestvo/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Остекление дачи под ключ: этапы, сроки, советы"
                                         data-src="/upload/resize_cache/webp/iblock/b1e/fyn52te5qyy530sof94xy3quai2tuh19.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">14.07.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Остекление дачи под ключ: этапы, сроки, советы</div>
                                    <div class="simple-card__desc"> В этой статье расскажем, из чего состоит остекление
                                        дачи "под ключ", сколько это занимает времени и на что стоит обратить внимание.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/osteklenie-dachi-pod-klyuch-etapy-sroki-sovety/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Пластиковые окна для коттеджей: как выбрать идеальное решение"
                                         data-src="/upload/iblock/e14/d0nbhs7anesu5bbq3lrej6ssphlqcjif.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">23.06.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Пластиковые окна для коттеджей: как выбрать
                                        идеальное решение
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы расскажем, как выбрать идеальные
                                        окна для вашего коттеджа, чтобы они сочетали в себе практичность, стиль и
                                        энергоэффективность.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/plastikovye-okna-dlya-kottedzhey-kak-vybrat-idealnoe-reshenie/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Какие пластиковые окна выбрать для офиса: практичность и эстетика"
                                         data-src="/upload/resize_cache/webp/iblock/8b2/gt5l2or4fa2pbrhe242osj3v1uuwl9ql.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">17.06.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Какие пластиковые окна выбрать для офиса:
                                        практичность и эстетика
                                    </div>
                                    <div class="simple-card__desc">. Как выбрать пластиковые окна для офиса, чтобы
                                        сочетать практичность и эстетику? Давайте разберемся.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kakie-plastikovye-okna-vybrat-dlya-ofisa-praktichnost-i-estetika/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Чем отличаются ПВХ-двери от металлических и деревянных: сравнение без мифов"
                                         data-src="/upload/resize_cache/webp/iblock/ffe/v5nmrgak8zeqiwfzhpo4rzw81cevqyep.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">19.05.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Чем отличаются ПВХ-двери от металлических и
                                        деревянных: сравнение без мифов
                                    </div>
                                    <div class="simple-card__desc"> Разберёмся, в чём реальные отличия каждого варианта,
                                        и какой из них подойдёт именно вам.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/chem-otlichayutsya-pvkh-dveri-ot-metallicheskikh-i-derevyannykh-sravnenie-bez-mifov/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Тёплое и холодное остекление: что выбрать для вашей беседки?"
                                         data-src="/upload/resize_cache/webp/iblock/024/k3wtz9uspuyzrqx8klkorwizxbhxkqll.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">05.05.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Тёплое и холодное остекление: что выбрать для вашей
                                        беседки?
                                    </div>
                                    <div class="simple-card__desc">Вы решили остеклить беседку, но столкнулись с
                                        выбором: тёплое или холодное остекление?
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/tyeploe-i-kholodnoe-osteklenie-chto-vybrat-dlya-vashey-besedki/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Как сделать балкон уютным: идеи для отделки"
                                         data-src="/upload/resize_cache/webp/iblock/506/ayb5726hccx11xyqf3w8dwhoxb8xh2gx.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">28.04.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Как сделать балкон уютным: идеи для отделки</div>
                                    <div class="simple-card__desc">В этой статье мы поделимся лучшими идеями и советами
                                        по отделке балкона, чтобы он стал уютным и функциональным пространством.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kak-sdelat-balkon-uyutnym-idei-dlya-otdelki/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Типы остекления балкона: как выбрать подходящий вариант?"
                                         data-src="/upload/resize_cache/webp/iblock/b17/40pn80lb9gb06hr5py0o2btz8g9po5nr.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">21.04.2025</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Типы остекления балкона: как выбрать подходящий
                                        вариант?
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы расскажем о различных типах
                                        остекления балконов и лоджий, а также о том, как выбрать подходящий вариант для
                                        вашего дома.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/tipy-ostekleniya-balkona-kak-vybrat-podkhodyashchiy-variant/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Дует под подоконником и рамой пластикового окна: причины и что делать"
                                         data-src="/upload/resize_cache/webp/iblock/59e/0tni0msiu133r06gpro46mr16epy9s7g.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">25.12.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Дует под подоконником и рамой пластикового окна:
                                        причины и что делать
                                    </div>
                                    <div class="simple-card__desc">Важно понять причину и устранить проблему, чтобы
                                        вернуть комфорт в помещение и снизить теплопотери.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/duet-pod-podokonnikom-i-ramoy-plastikovogo-okna-prichiny-i-chto-delat/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Разбился стеклопакет — что делать?"
                                         data-src="/upload/resize_cache/webp/iblock/b1d/5ufeyygutv6doatj0cjgfn5l9356zf1a.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">16.12.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Разбился стеклопакет — что делать?</div>
                                    <div class="simple-card__desc">Разберем основные причины, последствия и действия,
                                        которые помогут быстро устранить проблему.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/razbilsya-steklopaket-chto-delat/">Подробнее ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Что делать, если запотевает окно внутри стеклопакета?"
                                         data-src="/upload/resize_cache/webp/iblock/876/lbt73yywivmx9026m07dardthkyc25py.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">28.11.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Что делать, если запотевает окно внутри
                                        стеклопакета?
                                    </div>
                                    <div class="simple-card__desc">В этой статье разберемся в причинах и подскажем, что
                                        делать.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/chto-delat-esli-zapotevaet-okno-vnutri-steklopaketa/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Почему дует из окна: причины и как устранить проблему?"
                                         data-src="/upload/resize_cache/webp/iblock/4c7/ugkz5gp8f0hvqg3w9jjn688lgsj2ckdp.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">26.11.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Почему дует из окна: причины и как устранить
                                        проблему?
                                    </div>
                                    <div class="simple-card__desc"> Если вы заметили, что дует из окна, важно
                                        разобраться в причинах и устранить проблему.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/pochemu-duet-iz-okna-prichiny-i-kak-ustranit-problemu/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Почему ремонт и замена фурнитуры ваших окон так важна для безопасности"
                                         data-src="/upload/resize_cache/webp/iblock/2cc/3xv197cmoiuqqr033vol4y3b4q18tzk1.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">14.10.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Почему ремонт и замена фурнитуры ваших окон так
                                        важна для безопасности
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы обсудим, почему ремонт и замена
                                        фурнитуры так важны для безопасности вашего жилья.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/pochemu-remont-i-zamena-furnitury-vashikh-okon-tak-vazhna-dlya-bezopasnosti/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Замена уплотнительной резины на окнах: улучшаем изоляцию и снижаем шум"
                                         data-src="/upload/resize_cache/webp/iblock/7a2/f2m5ija152ca1w0ep9uvm2009ggrmrei.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">07.10.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Замена уплотнительной резины на окнах: улучшаем
                                        изоляцию и снижаем шум
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы рассмотрим, зачем нужно заменять
                                        уплотнительную резину, как это сделать самостоятельно и какие преимущества вы
                                        получите после замены.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/zamena-uplotnitelnoy-reziny-na-oknakh-uluchshaem-izolyatsiyu-i-snizhaem-shum/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Замена стеклопакета в пластиковых окнах: что нужно знать каждому владельцу?"
                                         data-src="/upload/resize_cache/webp/iblock/b03/uq7ppmyeo4tkfefj0n7smqro9ul4cbf2.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">23.09.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Замена стеклопакета в пластиковых окнах: что нужно
                                        знать каждому владельцу?
                                    </div>
                                    <div class="simple-card__desc">В этой статье разберем, почему возникает
                                        необходимость в замене, как происходит процесс, и что важно учесть при выборе
                                        нового стеклопакета.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/zamena-steklopaketa-v-plastikovykh-oknakh-chto-nuzhno-znat-kazhdomu-vladeltsu/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Детская безопасность на окнах: как выбрать и установить?"
                                         data-src="/upload/resize_cache/webp/iblock/748/o6u3z2c7glrbwl0imeo6n19r45tb7bvj.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">09.09.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Детская безопасность на окнах: как выбрать и
                                        установить?
                                    </div>
                                    <div class="simple-card__desc"> В этой статье разберем, как выбрать и установить
                                        системы, обеспечивающие детскую безопасность на окнах, и какие решения сегодня
                                        популярны в России.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/detskaya-bezopasnost-na-oknakh-kak-vybrat-i-ustanovit/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Технологии изготовления пластиковых окон: качество и надежность"
                                         data-src="/upload/resize_cache/webp/iblock/ee7/bbm8u4l51akdj8vwl717rwwx32whkkka.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">29.08.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Технологии изготовления пластиковых окон: качество и
                                        надежность
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы рассмотрим основные этапы
                                        производства пластиковых окон и те технологические решения, которые позволяют
                                        создать продукт, отвечающий самым высоким стандартам.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/tekhnologii-izgotovleniya-plastikovykh-okon-kachestvo-i-nadezhnost/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Виды остекления балконных дверей: французские окна, панорамные двери и другие опции"
                                         data-src="/upload/resize_cache/webp/iblock/e20/pxzdi5yp14zxkxv6m5fsizaaocfw64r0.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">19.08.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Виды остекления балконных дверей: французские окна,
                                        панорамные двери и другие опции
                                    </div>
                                    <div class="simple-card__desc">Остекление балконных дверей – важный элемент, который
                                        может значительно изменить внешний вид и функциональность любого пространства.�
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/vidy-ostekleniya-balkonnykh-dverey-frantsuzskie-okna-panoramnye-steklyannye-dveri-i-drugie-optsii/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Как выбрать балконный блок — советы от эксперта"
                                         data-src="/upload/resize_cache/webp/iblock/74e/hxb2xpelra0u2k53a27tz8hex82em1a6.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">29.08.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Как выбрать балконный блок — советы от эксперта
                                    </div>
                                    <div class="simple-card__desc">Существует несколько основных типов балконных блоков,
                                        различающихся по расположению дверей и окон, а также по типу открывания створок.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kak-vybrat-balkonnyy-blok-sovety-ot-eksperta/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Виды пластиковых окон: какие бывают и что нужно знать?"
                                         data-src="/upload/resize_cache/webp/iblock/04e/08af13vs629ia59uiz4wu8ym396u1usy.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">22.07.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Виды пластиковых окон: какие бывают и что нужно
                                        знать?
                                    </div>
                                    <div class="simple-card__desc">Прежде чем выбрать конкретную модель, важно
                                        разобраться в разнообразии видов пластиковых окон и их особенностях.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/vidy-plastikovykh-okon-kakie-byvayut-i-chto-nuzhno-znat/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Как выбрать правильные пластиковые окна — статья от производителя"
                                         data-src="/upload/resize_cache/webp/iblock/6c6/557mlswtrpi4untjceuuy939gnw0s0vf.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">24.06.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Как выбрать правильные пластиковые окна — статья от
                                        производителя
                                    </div>
                                    <div class="simple-card__desc"> В этой статье мы, как производитель пластиковых
                                        окон, дадим несколько ключевых рекомендаций, которые помогут вам сделать
                                        правильный выбор.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kak-vybrat-pravilnye-plastikovye-okna-statya-ot-proizvoditelya/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Холодное или теплое остекление балкона: в чем отличия и какое выбрать?"
                                         data-src="/upload/resize_cache/webp/iblock/307/4bjqy06cyjq0p2fx2etv75cobvaunnib.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">18.06.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Холодное или теплое остекление балкона: в чем
                                        отличия и какое выбрать?
                                    </div>
                                    <div class="simple-card__desc">Балкон — это не просто дополнительная площадь в
                                        квартире, но и пространство, которое можно использовать по-разному. В
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kholodnoe-ili-teploe-osteklenie-balkona-v-chem-otlichiya-i-kakoe-vybrat/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Как регулярная профессиональная регулировка окон может продлить их срок службы?"
                                         data-src="/upload/resize_cache/webp/iblock/3f0/8x7ky4lww2i58y5220kkln2g681ppca2.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">20.05.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Как регулярная профессиональная регулировка окон
                                        может продлить их срок службы?
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы рассмотрим, как регулярная
                                        профессиональная регулировка окон может продлить их срок службы и улучшить общее
                                        состояние вашего жилища.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/kak-regulyarnaya-professionalnaya-regulirovka-okon-mozhet-prodlit-ikh-srok-sluzhby/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide actions-carousel__item swiper-slide-next">
                            <div class="simple-card simple-card--article">
                                <div class="simple-card__img">
                                    <img alt="Преобразите свои окна: как ремонт фурнитуры может улучшить функциональность"
                                         data-src="/upload/resize_cache/webp/iblock/23a/r1kshk08da9yu6o6y3hnecgpqwyo5xiv.webp"
                                         class="lazyload img action-slide-img" width="400" height="200">
                                    <div class="simple-card__date">06.05.2024</div>
                                </div>
                                <div class="simple-card__body">
                                    <div class="simple-card__title">Преобразите свои окна: как ремонт фурнитуры может
                                        улучшить функциональность
                                    </div>
                                    <div class="simple-card__desc">В этой статье мы рассмотрим, как ремонт или
                                        обновление фурнитуры окон может трансформировать ваше жилище, улучшая как его
                                        функциональные, так и эстетические аспекты.
                                    </div>
                                </div>
                                <div class="simple-card__bottom">
                                    <a class="simple-card__link"
                                       href="/company/articles/preobrazite-svoi-okna-kak-remont-furnitury-mozhet-uluchshit-funktsionalnost/">Подробнее
                                        ...</a>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="arrow-box arrow-box--right arrow-box--blue js-arrow-right">
                    <div class="arrow-ico"></div>
                </div>
                <div class="arrow-box arrow-box--left arrow-box--blue js-arrow-left swiper-button-disabled">
                    <div class="arrow-ico arrow-ico--left"></div>
                </div>
            </div>

            <br><br>
        </section>


        @include('admin.balcony.examples')


        <section class="actions-carousel js-actions-carousel reviews-list js-reviews-list">

            <div class="inner-container">
                <div class="h2 section-header">Отзывы</div>
            </div>


            <div class="inner-container full-width actions-carousel__container">
                <div class="swiper swiper-action js-actions-carousel-swiper actions-carousel__content">
                    <div class="swiper-wrapper actions-carousel__wrapper">


                        <div class="swiper-slide reviews-list__item">

                            <div class="reviews-list__item-top">
                                <img class="reviews-list__item-rating lazyload"
                                     data-src="/new_style_files/assets/img/res/reviews-list/stars.svg" alt="">

                                <div class="reviews-list__item-date">
                                </div>
                            </div>
                            <div class="reviews-list__item-title-block">
                                <div>
                                    <img data-src="/upload/resize_cache/webp/iblock/328/gneq1497tvysyk4kz5hkudei93qf0obj.webp"
                                         class="lazyload">
                                </div>
                                <div class="reviews-list__item-title">
                                    Виталий Вороник
                                </div>
                            </div>

                            <p class="reviews-list__item-body js-reviews-list__item-body">
                                При выполнении работ был полный порядок. На балконе с новеньким остеклением стало куда
                                уютнее. Понравились скидки. </p>

                            <a href="javascript:void(0);" class="reviews-list__item-more js-reviews-list__item-more">
                                Подробнее
                            </a>
                        </div>


                        <div class="swiper-slide reviews-list__item">

                            <div class="reviews-list__item-top">
                                <img class="reviews-list__item-rating lazyload"
                                     data-src="/new_style_files/assets/img/res/reviews-list/stars.svg" alt="">

                                <div class="reviews-list__item-date">
                                </div>
                            </div>
                            <div class="reviews-list__item-title-block">
                                <div>
                                    <img data-src="/upload/resize_cache/webp/iblock/682/i7toawovjm9duudff2u2o80j6dk2uuc0.webp"
                                         class="lazyload">
                                </div>
                                <div class="reviews-list__item-title">
                                    Наталия Давыдова
                                </div>
                            </div>

                            <p class="reviews-list__item-body js-reviews-list__item-body">
                                В этом году решил поменять окна у мамы в квартире. Начал искать куда обратиться.
                                Обзвонил несколько компаний, пригласил на замер и понял, что скорее всего не успею в
                                этом году т.к зима на носу, а сроки до установки ставят 1-1,5 месяца. Каково же было моё
                                удивление когда я обратился в Компанию {{$data['company']}}: от подписания документов до
                                установки всего 14 дней ,шикарное качество окон, надёжная фурнитура, да ещё и москитная
                                сетка в подарок. А самое главное цена на все это не завышена. Проделанной работой очень
                                доволен, обратился ещё для ремонта окон уже себе в квартиру. Смело могу
                                рекомендовать. </p>

                            <a href="javascript:void(0);" class="reviews-list__item-more js-reviews-list__item-more">
                                Подробнее
                            </a>
                        </div>


                        <div class="swiper-slide reviews-list__item">

                            <div class="reviews-list__item-top">
                                <img class="reviews-list__item-rating lazyload"
                                     data-src="/new_style_files/assets/img/res/reviews-list/stars.svg" alt="">

                                <div class="reviews-list__item-date">
                                </div>
                            </div>
                            <div class="reviews-list__item-title-block">
                                <div>
                                    <img data-src="/upload/resize_cache/webp/iblock/5f5/pdr5qae9gnqhl939qzhrokotzvfbb8kp.webp"
                                         class="lazyload">
                                </div>
                                <div class="reviews-list__item-title">
                                    Павел Селяков
                                </div>
                            </div>

                            <p class="reviews-list__item-body js-reviews-list__item-body">
                                Сервис и профессионализм на высоте. Замер бесплатно, верно сняли мерки. По соотношению
                                цены и качества отлично. </p>

                            <a href="javascript:void(0);" class="reviews-list__item-more js-reviews-list__item-more">
                                Подробнее
                            </a>
                        </div>


                    </div>
                    <div class="arrow-box arrow-box--right arrow-box--blue js-arrow-right">
                        <div class="arrow-ico"></div>
                    </div>
                    <div class="arrow-box arrow-box--left arrow-box--blue js-arrow-left">
                        <div class="arrow-ico arrow-ico--left"></div>
                    </div>
                </div>


            </div>
        </section>


    </main>
    <footer class="footer">
        <div class="footer__container inner-container">
            <div class="footer__top">


                <nav class="footer__menu">
                    <ul class="footer-menu">
                        <li class="footer-menu__item">
                            <a class="no-style footer-menu__item-link"
                               href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/">Пластиковые окна под ключ</a>
                            <ul class="footer-menu__submenu footer-submenu">
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/gotovye-resheniya/">Готовые
                                        ПВХ-окна</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-prowin/">Пластиковые окна
                                        Exprof Prowin</a>
                                </li>

                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-profekta/">Пластиковые
                                        окна Exprof Profekta </a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/exprof-experta/">Пластиковые окна
                                        Exprof Experta </a>
                                </li>


                                <li class="footer-menu__item">
                                    <a class="no-style footer-menu__item-link" href="/plastikovyye-dveri-s-ustanovkoy/">Пластиковые
                                        двери</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovyye-dveri-s-ustanovkoy/balkonnye/">Балконные блоки</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovyye-dveri-s-ustanovkoy/alyuminievaya-vhodnaya-gruppa/">Алюминиевая
                                        входная группа</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovyye-dveri-s-ustanovkoy/pvx/">Входная группа ПВХ</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/plastikovyye-dveri-s-ustanovkoy/portal/">Портальные системы дверей </a>
                                </li>

                            </ul>
                        </li>


                        <li class="footer-menu__item">
                            <a class="no-style footer-menu__item-link" href="/osteklenie-balkonov-i-lodzhii/">Остекление
                                балконов и лоджий</a>
                            <ul class="footer-menu__submenu footer-submenu">
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/osteklenie-balkonov-i-lodzhii/teploe-osteklenie/">Теплое остекление
                                        балкона</a>
                                </li>

                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/osteklenie-balkonov-i-lodzhii/holodnoe-osteklenie/">Холодное остекление
                                        балкона</a>
                                </li>

                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/osteklenie-balkonov-i-lodzhii/francuzskoe-osteklenie/">Панорамное
                                        остекление балкона</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/osteklenie-balkonov-i-lodzhii/otdelka/">Отделка и утепление балкона</a>
                                </li>

                            </ul>
                        </li>


                        <li class="footer-menu__item">
                            <a class="no-style footer-menu__item-link" href="/kottedzhi-i-doma/osteklenie/">Остекление
                                домов и коттеджей</a>
                            <ul class="footer-menu__submenu footer-submenu">
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/kottedzhi-i-doma/osteklenie-besedok/">Остекление беседок </a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link"
                                       href="/kottedzhi-i-doma/dachnoe-osteklenie/">Дачное остекление </a>
                                </li>
                            </ul>
                        </li>

                        <li class="footer-submenu__item">
                            <a class="no-style footer-menu__item-link" href="/services/">Сервис</a></li>
                        <li class="footer-submenu__item">
                            <a class="no-style footer-menu__item-link" href="/aksessuary/">Аксессуары</a>
                        </li>


                        <li class="footer-menu__item">
                            <span class="no-style footer-menu__item-link">Наши работы</span>
                            <ul class="footer-menu__submenu footer-submenu">
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link" href="/company/">О компании</a>
                                </li>

                                <li class="footer-submenu__item">

                                    <a class="no-style footer-submenu__item-link" href="/company/certificate/">Сертификаты
                                        качества</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link" href="/company/articles">Статьи</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link" href="/company/news/">Новости</a>
                                </li>

                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link" href="/company/reviews/">Отзывы</a>
                                </li>
                                <li class="footer-submenu__item">
                                    <a class="no-style footer-submenu__item-link" href="/company/director/">Написать
                                        Директору</a>
                                </li>

                                <li class="footer-submenu__item">
                                    <a class="no-style footer-menu__item-link" href="/contacts/">Контакты</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

                <div class="footer__contact">
                    <div class="footer-contact">
                        <div class="footer-contact__group">
                            <div class="footer-contact__work-time">
                                с {{$conf['work_from']}} до {{$conf['work_from']}}
                            </div>
                            <br>
                            <a class="no-style footer-contact__phone"
                               href="{{$data['phone_href']}}">{{$conf['phone']}}</a>

                        </div>
                        <div class="footer-contact__group">

                            <a class="no-style only-mobile footer-contact__whatsapp"
                               rel="nofollow noopener" href="{{$conf['tg_href']}}">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/interface.svg#tg-small"></use>
                                </svg>
                                Написать в Telegram</a>
                            <button class="no-style btn btn--small footer-contact__btn-call"
                                    data-modal-window="#modal-calc-callback">Заказать звонок
                            </button>
                            <a class="no-style footer-contact__mail"
                               href="{{$data['email_href']}}">{{$conf['email']}}</a>
                        </div>
                        <div class="footer-contact__soc-link">


                            <a class="no-style soc-link" target="_blank" href="{{$conf['tg_href']}}">
                                <svg class="ico">
                                    <use xlink:href="/public/src/balcony/images/interface_234545.svg#tg-round"></use>
                                </svg>
                            </a>
                        </div>
                        <div class="footer-contact__legal-reference">
                            <a class="no-style ref-link" href="/confidence.php">Политика конфиденциальности</a>
                            <a class="no-style ref-link" href="/soglasiye.php">Соглашение на обработку персональных
                                данных</a>
                        </div>
                        <div class="footer-contact__legal-reference">
                            <a class="no-style ref-link" href="/karta-sajta/">Карта сайта</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__address">
                <div class="footer__address-item">
                    г. Вологда
                </div>

            </div>
            <div class="footer__bottom">
                <div class="footer__info footer-info">
                    <div class="footer-info__copyright">
                        <p class="p--small">
                            © 2026 Все права защищены.</p>
                    </div>

                </div>
            </div>
        </div>
    </footer>

</div>

<div class="modals-container">
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-calc-win">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">
                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="calc_window_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать расчет</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Рассчитать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Рассчитать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-calc-config">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="configurator">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать расчет</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Рассчитать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-consult">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">
                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="consult">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать консультацию</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-zamer">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="zamer">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Записаться на замер</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-fixprice">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="zamer">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Зафиксировать цену</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-calc-callback">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="callback_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать звонок</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-order-win">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="order_window_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Заказать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Заказать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-mosqit-order">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-mosqit-order"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="order_window_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input type="hidden" name="order" value="">
                                <input type="hidden" name="price" value="">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Заказать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Заказать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="hystmodal modal-win js-modal-win" aria-hidden="true" id="modal-success-form">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window modal-win__window" role="dialog" aria-modal="true">
                <div class="modal-win__container modal-calc-win">
                    <div class="modal-win__close" data-hystclose="">
                        <svg class="ico">
                            <use xlink:href="/public/src/balcony/images/interface.svg#close"></use>
                        </svg>
                    </div>
                    <div class="modal-win__content">
                        <div class="modal-win__head-title">Спасибо!<br>Наш менеджер скоро свяжется c Вами!</div>
                        <div class="js-flocktory-banner" style="height: 0; opacity: 0;"></div>
                        <div class="modal-win__btn">
                            <div class="btn" data-hystclose="">Отлично</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal modal-win js-modal-win" aria-hidden="true" id="modal-error">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window modal-win__window" role="dialog" aria-modal="true">
                <div class="modal-win__container modal-error js-modal-error">
                    <div class="modal-win__close" data-hystclose="">
                        <svg class="ico">
                            <use xlink:href="/public/src/balcony/images/interface.svg#close"></use>
                        </svg>
                    </div>
                    <div class="modal-win__content">
                        <div class="modal-win__head-title">Упс! Возникла ошибка.</div>
                        <div class="modal-win__head-desc">Ничего страшного, мы уже разбираемся в причинах. Попробуйте
                            повторить позднее или обращайтесь по телефону
                            <nobr><a class="no-style" href="tel:74959887888">+7 (495) 988-78-88</a></nobr>
                            .
                        </div>
                        <div class="modal-win__btn">
                            <div class="btn" data-hystclose="">ОК</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


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


<div class="hystmodal modal-win js-modal-win" aria-hidden="false" id="modal-write-key-person">
    <div class="hystmodal__wrap modal-win__wrap">
        <div class="hystmodal__window modal-win__window" role="dialog" aria-modal="true">
            <div class="modal-win__container modal-write-key-person js-modal-write-key-person">
                <div class="modal-win__close" data-hystclose="">
                    <svg class="ico">
                        <use xlink:href="/public/src/balcony/images/interface.svg#close"></use>
                    </svg>
                </div>
                <div class="modal-win__content">
                    <section class="write-key-person-form js-write-key-person-form">
                        <div class="inner-container write-key-person-form__container">
                            <form class="write-key-person-form__form" name="writeKeyPerson"
                                  action="/ajax/?controller=form&action=add" novalidate="novalidate">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="owner" value="plastika54@internet.ru">
                                <input type="hidden" name="bbc" value="">
                                <input type="hidden" name="form" value="owner">
                                <input type="hidden" name="attribute" value="mail">
                                <div class="h4 write-key-person-form__head-title">Написать</div>
                                <div class="write-key-person-form__content">
                                    <div class="write-key-person-form__group">
                                        <div class="control write-key-person-form__fio">
                                            <div class="control__group">
                                                <label class="control__label">Контактное лицо</label>
                                                <input class="control__input js-user-name" placeholder="Иван" id=""
                                                       name="user-name" type="text" required="" autocomplete="name">
                                            </div>
                                        </div>
                                        <div class="control write-key-person-form__phone">
                                            <div class="control__group">
                                                <label class="control__label">Контактный телефон</label>
                                                <input class="control__input js-user-phone" name="user-phone"
                                                       placeholder="+7(999)888-77-66" type="tel" required=""
                                                       autocomplete="tel">
                                            </div>
                                        </div>
                                        <div class="control write-key-person-form__email">
                                            <div class="control__group">
                                                <label class="control__label">Email</label>
                                                <input class="control__input js-user-email" id="" name="user-email"
                                                       placeholder="ivan@mail.ru" type="email" required=""
                                                       autocomplete="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control write-key-person-form__comment">
                                        <div class="control__group">
                                            <label class="control__label">Комментарий</label>
                                            <textarea class="control__textarea js-user-message" id=""
                                                      name="user-message" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn write-key-person-form__btn" type="submit">Написать</button>
                                <div class="free-meas-form__person-data">
                                    <label class="checkbox-small checkbox-small--white"></label>

                                    <input class="checkbox-small__input js-person-data" type="checkbox"
                                           name="person-data" id="free-meas__person-data">
                                    <label class="checkbox-small__checkbox" for="free-meas__person-data"></label>
                                    <label class="checkbox-small__label" for="free-meas__person-data"><span
                                                class="checkbox-small__label">Нажимая на кнопку «Написать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span></label>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal-bg"></div>


<div class="modal dialog">
    <span class="modal-close"></span>
    <p class="title">Заявка отправлена</p>
    <p>
        Ответим Вам в ближайшее время.
    </p>
</div>


<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/mosq-calc.js"></script>


<script>


   jQuery(document).ready(function () {

      $("form").prepend('<input type="hidden" name="capt" value="453457686796898745345gh355q5yh3" />');


      $(".main-banner__form button").click(function (e) {


         var checked = $(this).closest(".main-banner__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".main-banner__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".main-banner__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(".main-banner__form input[name='user-phone']").val());

         var capt = $.trim($(".main-banner__form input[name='capt']").val());

         if (phone.length != 16) {
            $(".main-banner__form input[name='user-phone']").addClass('just-validate-error-field');
         } else {
            $(".main-banner__form input[name='user-phone']").removeClass('just-validate-error-field');
         }

         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMail.php', {action: "send", phone: phone, capt: capt}, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".main-banner__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".window-decor-form__main:not(.modal-mosqit-order) button").click(function (e) {

         var checked = $(this).closest(".window-decor-form__main").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".window-decor-form__main").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".window-decor-form__main").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".window-decor-form__main").find("input[name='phone']").val());
         if (phone.length != 16) {
            $(this).closest(".window-decor-form__main").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".window-decor-form__main").find("input[name='phone']").removeClass('just-validate-error-field');
         }


         var capt = $.trim($(this).closest(".window-decor-form__main").find("input[name='capt']").val());


         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMail.php', {action: "send", phone: phone, capt: capt}, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".window-decor-form__main").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".modal-mosqit-order button").click(function (e) {

         var checked = $(this).closest(".modal-mosqit-order").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".modal-mosqit-order").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".modal-mosqit-order").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".modal-mosqit-order").find("input[name='phone']").val());
         var order = $.trim($(this).closest(".modal-mosqit-order").find("input[name='order']").val());
         var price = $.trim($(this).closest(".modal-mosqit-order").find("input[name='price']").val());
         if (phone.length != 16) {
            $(this).closest(".modal-mosqit-order").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".modal-mosqit-order").find("input[name='phone']").removeClass('just-validate-error-field');
         }


         var capt = $.trim($(this).closest(".modal-mosqit-order").find("input[name='capt']").val());

         if ((phone.length == 16) && (checked == 1)) {

            $.post('/ajax/sendMailMosqit.php', {
               action: "send",
               phone: phone,
               order: order,
               price: price,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".modal-mosqit-order").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".free-meas-form__form button").click(function (e) {

         var checked = $(this).closest(".free-meas-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".free-meas-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".free-meas-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".free-meas-form__form").find("input[name='phone']").val());
         var name = $.trim($(this).closest(".free-meas-form__form").find("input[name='name']").val());

         var capt = $.trim($(this).closest(".free-meas-form__form").find("input[name='capt']").val());


         if (phone.length != 16) {
            $(this).closest(".free-meas-form__form").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".free-meas-form__form").find("input[name='phone']").removeClass('just-validate-error-field');
         }


         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMail.php', {action: "send", phone: phone, name: name, capt: capt}, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".free-meas-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".feedback-form__form button").click(function (e) {

         var checked = $(this).closest(".feedback-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".feedback-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".feedback-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".feedback-form__form").find("input[name='phone']").val());
         var name = $.trim($(this).closest(".feedback-form__form").find("input[name='name']").val());
         var message = $.trim($(this).closest(".feedback-form__form").find("textarea[name='message']").val());

         if (phone.length != 16) {
            $(this).closest(".feedback-form__form").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".feedback-form__form").find("input[name='phone']").removeClass('just-validate-error-field');
         }

         var capt = $.trim($(this).closest(".feedback-form__form").find("input[name='capt']").val());


         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMailDirector.php', {
               action: "send",
               phone: phone,
               name: name,
               message: message,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".feedback-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".write-key-person-form__form button").click(function (e) {

         var checked = $(this).closest(".write-key-person-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".write-key-person-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".write-key-person-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var capt = $.trim($(this).closest(".write-key-person-form__form").find("input[name='capt']").val());
         var phone = $.trim($(this).closest(".write-key-person-form__form").find("input[name='user-phone']").val());
         var name = $.trim($(this).closest(".write-key-person-form__form").find("input[name='user-name']").val());
         var message = $.trim($(this).closest(".write-key-person-form__form").find("textarea[name='user-message']").val());

         var email = $.trim($(this).closest(".write-key-person-form__form").find("input[name='user-email']").val());
         var owner = $.trim($(this).closest(".write-key-person-form__form").find("input[name='owner']").val());

         if ((phone.length != 16) && (checked == 1)) {
            $(this).closest(".write-key-person-form__form").find("input[name='user-phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".write-key-person-form__form").find("input[name='user-phone']").removeClass('just-validate-error-field');
         }


         if (phone.length == 16) {
            $.post('/ajax/sendMailPerson.php', {
               action: "send",
               phone: phone,
               name: name,
               email: email,
               owner: owner,
               message: message,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".write-key-person-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".reviews-form__form button").click(function (e) {

         var checked = $(this).closest(".reviews-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".reviews-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".reviews-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".reviews-form__form").find("input[name='user-phone']").val());
         var name = $.trim($(this).closest(".reviews-form__form").find("input[name='user-name']").val());
         var email = $.trim($(this).closest(".reviews-form__form").find("input[name='user-email']").val());
         var doc = $.trim($(this).closest(".reviews-form__form").find("input[name='user-doc']").val());
         var message = $.trim($(this).closest(".reviews-form__form").find("textarea[name='user-message']").val());


         if (document.getElementById('star-1').checked) {
            var rating = 1;
         }

         if (document.getElementById('star-2').checked) {
            var rating = 2;
         }

         if (document.getElementById('star-3').checked) {
            var rating = 3;
         }

         if (document.getElementById('star-4').checked) {
            var rating = 4;
         }

         if (document.getElementById('star-5').checked) {
            var rating = 5;
         }

         if (phone.length < 6) {
            $(this).closest(".reviews-form__form").find("input[name='user-phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".reviews-form__form").find("input[name='user-phone']").removeClass('just-validate-error-field');
         }

         var capt = $.trim($(this).closest(".reviews-form__form").find("input[name='capt']").val());


         if ((phone.length > 5) && (checked == 1)) {
            $.post('/ajax/sendMailReview.php', {
               action: "send",
               phone: phone,
               name: name,
               doc: doc,
               email: email,
               rating: rating,
               message: message,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".reviews-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $('.modal-close').click(function () {
         $('.modal').removeClass('active');
         $(".modal-bg").removeClass('active');
      });

      $(document).mouseup(function (e) {
         var div = $(".modal");
         if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            $(".modal").removeClass('active');
            $(".modal-bg").removeClass('active');
         }
      });


      $(".js-arrow-next").removeClass("swiper-button-disabled");

      $(".profili-tabs .tabs-menu > span").click(function () {
         $(this).parent(".tabs-menu").children("span").removeClass('active');

         $(this).addClass('active');
         $(this).parent(".tabs-menu").parent(".profili-tabs").children(".tab").removeClass('active');
         $(".tab#tab-" + $(this).attr("data-id")).addClass('active');
         $(this).parent(".tabs-menu").parent(".profili-tabs").children(".tab.tab-" + $(this).attr("data-id")).addClass('active');

      });


      $(".win-prices-tab__wrap .win-prices-tab__item").click(function () {
         $(".win-prices-tab__wrap .win-prices-tab__item").removeClass('active');

         $(this).addClass('active');
         $(".win-prices__content .win-prices__item").removeClass('active');


         $(".win-prices__content .win-prices__item[data-tab-index=" + $(this).attr("data-tab-index") + "]").addClass('active');

      });


   });
</script>


</body>
</html>