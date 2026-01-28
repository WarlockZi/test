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
                       href={{$conf['phone_href']}}>{{$conf['phone']}}
                    </a>

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
                    <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                        <a href="/plastikovye-okna-s-ustanovkoy-pod-klyuch/" class="no-style mega-menu-item ">
                            <div class="mega-menu-item__label">Пластиковые окна</div>
                        </a>
                    </li>
                    <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                        <a href="/osteklenie-balkonov-i-lodzhii/" class="no-style mega-menu-item ">
                            <div class="mega-menu-item__label">Балконы и лоджии</div>
                        </a>
                    </li>
                    <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                        <a href="/kottedzhi-i-doma/osteklenie/" class="no-style mega-menu-item ">
                            <div class="mega-menu-item__label">Коттеджи и дачи</div>
                        </a>
                    </li>
                    <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                        <a href="/plastikovyye-dveri-s-ustanovkoy/" class="no-style mega-menu-item ">
                            <div class="mega-menu-item__label">Двери</div>
                        </a>
                    </li>
                    <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                        <a href="/servis/" class="no-style mega-menu-item ">
                            <div class="mega-menu-item__label">Сервис</div>
                        </a>
                    </li>
                    <li class="swiper-slide mega-menu__item js-mega-menu-item only-desktop">
                        <div class="mega-menu-item">
                            <div class="mega-menu-item__label">Дополнительно</div>
                        </div>
                    </li>
                    <li class="swiper-slide mega-menu__item js-mega-menu-item ">
                        <a href="/actions/" class="no-style mega-menu-item ">
                            <div class="mega-menu-item__label">Акции</div>
                        </a>
                    </li>
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