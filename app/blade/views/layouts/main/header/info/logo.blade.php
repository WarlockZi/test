@php
use app\view\components\Icon\Icon;
@endphp

@if($_SERVER['REQUEST_URI']==='/')

    <div class="logo">
        {!!Icon::logo_square1() . Icon::logo_vitex1()!!}
    </div>

@else
    <a href='/' class="logo" aria-label='На главную'>
        {!!Icon::logo_square1() . Icon::logo_vitex1()!!}
    </a>
@endif