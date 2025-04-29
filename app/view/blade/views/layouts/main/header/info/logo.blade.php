@php
    use app\service\Router\IRequest;
 $isHome = APP->get(IRequest::class)->isHome();

@endphp

@if ( $isHome)

    <div class="logo">
        {!! $mainLayout->getLogo()!!}
    </div>

@else
    <a href='/' class="logo" aria-label='На главную'>
        {!! $mainLayout->getLogo()!!}
    </a>
@endif