@extends('layouts.main.main')

@section('content')
    <h1 class="compare-h1">Страница сравнения товаров</h1>
    @if($compares)
        <div class='product-wrap' data-compare>
            @foreach($compares as $compare)
                @php
                    $product = $compare->product;
                    $txt = $product->txt;
                @endphp
                {{--                @php xdebug_break() @endphp--}}
                @include('components.product_card.product_card', ['product'=>$compare->product])
            @endforeach
        </div>
    @else
        Вы не добавили товары для сравнения
    @endif
@endsection