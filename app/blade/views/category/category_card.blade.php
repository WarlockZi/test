<div class="category-card">

    <a class="category-card-a" href="{{$child['href']}}">
        {{$child['name']}}
    </a>
    @php $forBreadcrumbs = false; @endphp
    @include('components.card_panel.category_card_panel', compact('forBreadcrumbs'))

</div>


