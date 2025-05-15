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

        @foreach($breadcrumbs->parentsArray as $item)
            @php ++$position; @endphp
            @include('components.breadcrumbs.li',compact('item', 'position','lastItemIsLink'))
        @endforeach

    </ul>
</nav>