@foreach (APP->get('mobileCategories') as $child)

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))

@endforeach