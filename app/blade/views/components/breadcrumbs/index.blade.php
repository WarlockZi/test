<nav class="breadcrumbs-5" itemscope="" itemtype="https://schema.org/BreadcrumbList">
    <ul>
        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="/catalog">
                <span itemprop="name">Категории</span>
            </a>
            <meta itemprop="position" content="1">
        </li>
        @foreach($breadcrumbs['parentsArray']??[] as $position=>$item)
            @include('components.breadcrumbs.li',compact('position','item'))
            @php $position++; @endphp
        @endforeach

    </ul>
</nav>