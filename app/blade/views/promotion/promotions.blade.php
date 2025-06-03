@extends('layouts.main.main')

@section('content')

    <div class="promotions-index">

        <h1>
            Акции
        </h1>

{{--        @php xdebug_break() @endphp--}}

        <h2>Активные акции</h2>

        @if (!count($activePromotions))
            <p>В даный момент активных акций нет, но скоро, возможно, появятся</p>

        @else

            @foreach ($activePromotions as $promotion)
                @if ($promotion && $promotion->product)
                    <div class="promotion row">

                        {{ $unit = $promotion->product->baseUnit->name}}

                        <div class="old-price">
                            цена без акции - <?= $promotion->product->getRelation('price')->price ?>
                        </div>
                        <div class="new-price">
                            <div class="price">
                                цена по акции - <?= $promotion->new_price; ?>

                            </div>
                            <div class="count">
                                oт <?= $promotion->count; ?> <?= $unit; ?>
                            </div>
                        </div>
                        <a href="/product/<?= $promotion->product->slug ?>" class="main-image">
                            <img src="<?= $promotion->product->mainImagePath; ?>" alt="">
                        </a>

                        <div class="active-till">
                            действует до - <?= $promotion->active_till ?>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        <h2>Закончившиеся акции</h2>

        @if (count($inactivePromotions))

            @foreach ($inactivePromotions as $promotion)
                @if ($promotion && $promotion->product)
                    <div class="promotion row">

                        {{ $unit = $promotion->product->baseUnit->name}}

                        <div class="old-price">
                            цена без акции - <?= $promotion->product->getRelation('price')->price ?>
                        </div>
                        <div class="new-price">
                            <div class="price">
                                цена по акции - <?= $promotion->new_price; ?>

                            </div>
                            <div class="count">
                                oт <?= $promotion->count; ?> <?= $unit; ?>
                            </div>
                        </div>
                        <a href="/product/<?= $promotion->product->slug ?>" class="main-image">
                            <img src="<?= $promotion->product->mainImagePath; ?>" alt="">
                        </a>

                        <div class="active-till">
                            действует до - <?= $promotion->active_till ?>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

    </div>

@endsection
