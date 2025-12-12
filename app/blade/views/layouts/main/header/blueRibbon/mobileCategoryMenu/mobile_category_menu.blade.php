@foreach (APP->get('rootCategories') as $child)

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))

@endforeach