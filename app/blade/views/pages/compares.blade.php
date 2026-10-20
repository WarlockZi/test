@extends('layouts.main.main')

@section('content')
{{--                @deb--}}
    <h1 class="compare-h1" data-jsmodule="compare">Страница сравнения товаров</h1>
    @if($compares)
        <div class='product-wrap' data-compare>
            @foreach($compares as $product)
                @php
                    $txt = $product['own_properties']['txt'];
                @endphp
                @include('category.product_card', compact('product'))
            @endforeach
        </div>
    @else
        Вы не добавили товары для сравнения
    @endif
@endsection