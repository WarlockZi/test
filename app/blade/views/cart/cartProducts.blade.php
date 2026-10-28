@php
    use app\service\AuthService\AuthService;use app\view\components\Icon\Icon;
    $i = 1;
@endphp

@foreach ($order['products'] as $product_is_id => $orderitems)
    @php($product = $orderitems[0]['product'])


    <div class="row cart-item" data-product_1s_id="{!!$product_is_id!!}">

        <div class="num cell">{!!$i++!!}</div>

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
{{--            @deb--}}
            @php
                $showToCartButton = false;
                $plus_minus_buttons = true;
            @endphp

            @include('components.shippable_units.shippableUnits', compact('product', 'orderitems', 'showToCartButton', 'plus_minus_buttons'))

        </div>

        @include('cart.cartSubSum')

        <div class="del cell">{!!Icon::trashWhite()!!}</div>
    </div>

@endforeach

@include('cart.total')

