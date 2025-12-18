@if(!count($child['children_recursive']))

    <li class="nav-item">
        <a
                class="nav-link"
                href="/catalog/{!!$child['own_properties']['path']??$child['s_id']!!}"
        >
                <?= $child['name']; ?>
        </a>
    </li>

@else

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.nav-expand',compact('child'))

@endif