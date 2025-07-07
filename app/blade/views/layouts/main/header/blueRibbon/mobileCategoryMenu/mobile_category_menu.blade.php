@php
    use app\repository\CategoryRepository;
@endphp

@foreach (CategoryRepository::treeAll() as $child)

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.li', compact('child'))

@endforeach