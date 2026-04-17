@foreach (APP->get('rootCategoriesOrderedByName')->toArray() as $child)

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))

@endforeach