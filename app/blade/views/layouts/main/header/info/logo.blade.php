@php
use app\view\Icon;
@endphp

@if ( $request->isHome())

    <div class="logo">

        {!! Icon::logo_square1() . Icon::logo_vitex1()!!}
    </div>

@else
    <a href='/' class="logo" aria-label='На главную'>
        {!! Icon::logo_square1() . Icon::logo_vitex1()!!}
    </a>
@endif