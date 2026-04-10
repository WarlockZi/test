<div class="category-card">

    <a class="category-card-a"
       href="/catalog/{{$child['own_properties']['seo_path']??$child['own_properties']['path']}}">
        {{$child['name']}}
    </a>

    @include('components.card_panel.category_card_panel',compact('child'))

</div>


