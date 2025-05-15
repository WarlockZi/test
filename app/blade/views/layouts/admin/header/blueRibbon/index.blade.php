@php use app\view\Icon; @endphp

<nav class="menu">
    <div class="header-catalog-menu">
        @include('layouts.main.header.blueRibbon.search_panel')
        <div class="header-catalog-menu__wrap">
            @include ('layouts.main.header.blueRibbon.categories')

            <ul class="utils">

                <li class="mob-burger">
                    @include('layouts.main.header.blueRibbon.mobile_menu')
                </li>

                <li>
                    <a href="/catalog" class="util-item catalog" title="Каталог">
                        @php echo  Icon::catalog() @endphp
                    </a>
                </li>

                <li>
                    <button class="util-item search" title="Поиск">
                        @php echo  Icon::search('feather'); @endphp
                    </button>
                </li>


                <li>
                    <a href="/cart" class="util-item cart-link" title="Корзина">

                        {{--                        @if ($oItemsCount) --}}
                        {{--                            <div class="count show">@php echo  $oItemsCount; @endphp </div>--}}
                        {{--                        @endif --}}

                        @php echo  Icon::shoppingCart('feather') @endphp
                    </a>
                </li>


                <li>
                    <a href="/compare/page" class="util-item compare" title="Сравнить товары">
                        @php echo  Icon::chart() @endphp
                    </a>
                </li>
                <li>
                    <a href="/like/page" class="util-item like" title="Избранное">
                        @php echo  Icon::heart() @endphp
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>
