@php
    use app\view\layouts\MainLayout;

 $route = APP->get(MainLayout::class)->getRoute();

@endphp
@if ( $route->isHome())

    <div class="logo">
        @php echo $logo @endphp
    </div>

@else
    <a href='/' class="logo" aria-label='На главную'>
        @php echo $logo @endphp
    </a>
@endif