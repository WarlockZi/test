
@foreach (APP->get('rootCategories') as $child)

{{--    @php(xdebug_break())--}}
    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))

@endforeach