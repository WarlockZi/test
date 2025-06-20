@php
    use app\repository\CategoryRepository;
//        xdebug_break() ;
@endphp

@foreach (CategoryRepository::treeAll() as $child)

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))

@endforeach