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

            @include('components.breadcrumbs.index')

            <h1>{!! $product['print_name'] !!}</h1>

            <div class="product-card_hero">
                @include('product.main_image')
{{--            @php (xdebug_break())--}}
                @include ('product.card.toCart')
            </div>

            <div class="info-wrap">
                <div class="info-tag">Информация о товаре</div>
                <div class="properties">
                    <h2>{!!
                    $product['own_properties']['seo_h1'] ?? $product['name'];
                    !!}</h2>

                    <div id="seo-article">{!!
                     $product['own_properties']['seo_article']
                     ?? $product['own_properties']['seo_description']
                     ?? 'Описание товара отстутствует';
                     !!}</div>

{{--                    @php(xdebug_break())--}}
                    @if (isset($product->values) && !empty($product->values))
                        @foreach ($product->values as $value)
                            @include( __DIR__ . '/property.php')
                        @endforeach
                    @endif


                </div>
            </div>

            <div class="info-wrap">
                <div class="info-tag">Характеристики</div>

                <article id="detail-text"><?= $product['own_properties']['txt']; ?></article>
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