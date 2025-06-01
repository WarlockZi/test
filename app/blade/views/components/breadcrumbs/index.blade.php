<nav class="breadcrumbs-5" itemscope="" itemtype="https://schema.org/BreadcrumbList">
    <ul>
        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="/catalog">
                <span itemprop="name">Категории</span>
            </a>
            <meta itemprop="position" content="1">
        </li>

        @php
            $position =1;
            $lastItemIsLink = $breadcrumbs->lastItemIsLink;
        @endphp

{{--        @php xdebug_break() @endphp--}}
        @foreach($breadcrumbs->parentsArray as $item)
            @include('components.breadcrumbs.li',compact('item', 'position','lastItemIsLink'))
            @php $position++; @endphp
        @endforeach

    </ul>
</nav>