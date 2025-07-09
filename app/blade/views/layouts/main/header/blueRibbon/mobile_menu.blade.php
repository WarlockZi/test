@php
    use app\repository\MobileMenuRepository;
    use app\view\components\Icon\Icon;
@endphp

<button class="nav-top util-item">
    <span class="hamburger material-icons" id="ham">
        {!! Icon::menu('feather') !!}
    </span>
</button>

<nav class="nav-drill">
    <ul class="nav-items nav-level-1">

        <li class="nav-item nav-expand">
            <a class="nav-link nav-expand-link" href="#">
                Каталог
            </a>
            <ul class="nav-items nav-expand-content">
                @include('layouts.main.header.blueRibbon.mobileCategoryMenu.mobile_category_menu')
            </ul>
        </li>

        @foreach(MobileMenuRepository::items() as $item)
            <li class="nav-item">
                <a class="nav-link" href="/main/{!! $item['path'] !!}">
                    {!! $item['title'] !!}
                </a>
            </li>
        @endforeach


    </ul>
    <div class="mob-menu-contacts">
        <a href="tel:+79815068191" onclick="YM('click_on_phone')">8 (909) 594-29-11</a>
        <a href="mailto:10@vitexopt.ru" onclick="YM('click_on_email')">10@vitexopt.ru</a>
        <button id="burger-call-me" class="call-me" title="Заказать обратный звонок">Позвоните мне !</button>
    </div>
</nav>