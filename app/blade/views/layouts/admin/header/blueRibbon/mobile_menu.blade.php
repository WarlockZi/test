@php
    use app\view\Icon;
@endphp

<button class="nav-top util-item">
    <span class="hamburger material-icons" id="ham">
        @php echo Icon::menu('feather') @endphp

    </span>
</button>

<nav class="nav-drill">
    <ul class="nav-items nav-level-1">
        <li class="nav-item nav-expand">
            <a class="nav-link nav-expand-link" href="#">
                Каталог
            </a>

            <ul class="nav-items nav-expand-content">
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nav-back-link" href="#"></a>--}}
{{--                </li>--}}

                @include('layouts.main.header.blueRibbon.mobileCategoryMenu.mobile_category_menu')
            </ul>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/contacts">
                Контакты
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/news">
                Новости
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/promotions">
                Акции
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/about">
                О нас
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/statii">
                Статьи
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/garantii">
                Гарантии
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/discount">
                Скидки
            </a>
        </li>
    </ul>
    <div class="mob-menu-contacts">
        <a href="tel:+79815068191" onclick="YM('click_on_phone')">8 (909) 594-29-11</a>
        <a href="mailto:10@vitexopt.ru" onclick="YM('click_on_email')">10@vitexopt.ru</a>
        <button id="burger-call-me" class="call-me" title="Заказать обратный звонок">Позвоните мне !</button>
    </div>
</nav>