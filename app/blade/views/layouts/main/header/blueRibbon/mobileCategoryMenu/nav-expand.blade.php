<li class="nav-item nav-expand">

    <a class="nav-link nav-expand-link" href="#">
        {{$child['name']}}
    </a>

    <ul class="nav-items nav-expand-content">

        <li class="nav-item">

            @if(!empty($child['children_recursive']))
                @foreach($child['children_recursive'] as $child)
                    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))
                @endforeach
            @endif

        </li>

    </ul>
</li>

