<div class="category-card">

    <a class="category-card-a" href="{{$child['own_properties']['path']}}">
        {{$child['name']}}
    </a>
{{--@php(xdebug_break())--}}
    @include('components.card_panel.category_card_panel',compact('child'))

</div>


