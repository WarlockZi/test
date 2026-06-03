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
            $lastItemIsLink = $variables['breadcrumbs']['lastItemIsLink']??'';
        @endphp

        @foreach($variables['breadcrumbs']['parentsArray']??[] as $item)

{{--        @deb--}}
            @include('components.breadcrumbs.li',compact('item', 'position','lastItemIsLink'))
            @php $position++; @endphp
        @endforeach

    </ul>
</nav>