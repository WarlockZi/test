@php
    use app\service\AuthService\AuthService;use app\view\components\Icon\Icon;
    $i = 0;
@endphp

@foreach ($account['cart_items'] as $prdouct_1s_id => $orderitems)

    @foreach($orderitems as $orderitem)

{{--        @deb--}}
        @php
            $product = $orderitem['product'];

        @endphp

        <div class="row cart-item" data-product_1s_id="{!!$prdouct_1s_id!!}">

            <div class="num cell">{!!++$i!!}</div>

            <a href="/product/{!!$product['slug']!!}" class="name">
                <img class="img" src="{!!$product['mainImage']!!}" alt="{!!$product['name']!!}">
            </a>

            <div class="product-name cell">

                @if (AuthService::getUser())
                    <a href="/adminsc/product/edit/{!!$product['id']!!}"
                       class="edit card-panel-item">{!!Icon::edit()!!}</a>
                @endif
                <a href="/product/{!!$product['slug']!!}" class="name">{!!$product['name']!!}</a>
            </div>

            <div class="cart-shippable-table cell">
                @php
                    $plus_minus_buttons = false;
                    $showToCartButton = false;
                @endphp

                @include('admin.order.shippableUnits', compact('product', 'orderitems', 'plus_minus_buttons', 'showToCartButton'))

            </div>

            @include('cart.cartSubSum')

            <div class="del cell">{!!Icon::trashWhite()!!}</div>
        </div>

    @endforeach

@endforeach

@include('cart.total')
{{--<div class="total">--}}
{{--    <div class="title">Всего -&nbsp;&nbsp;</div>--}}
{{--    <span></span>--}}
{{--</div>--}}

{{--<div class="buttons">--}}
{{--    @if (!AuthService::getUser())--}}
{{--        <div class="button" id="cartLogin"--}}
{{--             title="Чтобы оформить заказ Вам &#10;необходимо зарегистрироваться &#10;или войти под своей учеткой">--}}
{{--            Войти--}}
{{--        </div>--}}
{{--    @else--}}
{{--        <div class="button" id="cartSubmit">Оформить заказ</div>--}}
{{--    @endif--}}
{{--</div>--}}
