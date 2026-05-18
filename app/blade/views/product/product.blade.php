@extends('layouts.main.main')

@section('title', $meta['title'])
@section('description', $meta['description'])
@section('keywords', $meta['keywords'])

@section('content')

    @if (!empty($product))

        @if ($product['deleted_at'])
            <div class="deleted-overlay">
                <h1 class="deleted">
                    Товар закончился
                </h1>
            </div>
        @endif

        <div class="product-card" data-1sid="<?= $product['1s_id']; ?>">
            {{--            @deb--}}
            @include('components.breadcrumbs.index')

            <h1>{!!$product['print_name']!!}</h1>

            <div class="product-card_hero">
                @include('product.main_image')
                @include ('product.card.toCart')
            </div>

            <div class="info-wrap">
                <div class="info-tag">Описание</div>

                <article id="detail-text">{{$product['own_properties']['txt']}}</article>
            </div>


                <?php //include __DIR__.'/card/olsoLike.php'?>
                <?php //include __DIR__.'/card/rating.php'?>


                    <!--        --><?php //= Icon::star() ?>
                    <!--		 --><?php // include __DIR__ . '/card/reviews.php' ?>
                    <!--		 --><?php // include __DIR__ . '/card/alsoViewd.php.php' ?>

        </div>

    @else
        <div>Такого товара нет</div>
        <a href="/adminsc/category">Перейти в каталог</a>
    @endif
@endsection