@extends('layouts.main.main')

@section('title', 'Корзина')
@section('description', 'Корзина.')
@section('keywords', 'Корзина')


@section('content')

    @php
        use app\service\AuthService\Auth;
        use app\view\Icon;
        $authed = Auth::getUser();
        xdebug_break();
    @endphp
    <div class="cart">

        <h1>Корзина</h1>

        @if (empty($order) || !$order?->products?->count())

            <div class="empty-cart">
                Корзина пуста
            </div>

        @else

            <div class="content">

                <div class="table" data-order-id="<?= $order->id; ?>">

                    @foreach ($order?->products as $i => $product)

                        <div class="row cart-item" data-product-id="<?= $product['1s_id']; ?>">
                            <div class="num cell"><?= ++$i; ?></div>

                            <img class="img" src="<?= $product->mainImagePath; ?>" alt="<?= $product->name; ?>">

                            <div class="name-price cell">
                                <a href="/product/<?= $product->slug; ?>"
                                   class="name">
                                        <?= $product->name; ?>
                                </a>
                            </div>

                            <div class="cart-shippable-table cell">
                                @include('components.shippableUnits.shippableUnits', compact('product'))
                            </div>

                            <div class="sub-sum sum cell">
                                @foreach($shippableTable->rows[$product['1s_id']] as $unit)

                                    {{--                                    @php xdebug_break() @endphp--}}
                                    <div class="row-sum">
                                        @if($unit['row_sum'])
                                            {!!$unit['formatted_row_sum']!!}
                                        @endif
                                    </div>

                                @endforeach

                            </div>
                            <div class="del cell"><?= Icon::trashWhite(); ?></div>
                        </div>

                    @endforeach


                    <div class="total">
                        <div class="title">Всего -&nbsp;&nbsp;</div>
                        <span></span>
                    </div>

                    <div class="buttons">
                        @if (!Auth::getUser())
                            <div class="button" id="cartLogin"
                                 title="Чтобы оформить заказ Вам &#10;необходимо зарегистрироваться &#10;или войти под своей учеткой">
                                Войти
                            </div>
                        @else
                            <div class="button" id="cartSubmit">Оформить заказ</div>
                        @endif
                    </div>

                </div>

            </div>

    </div>
    @endif

@endsection
