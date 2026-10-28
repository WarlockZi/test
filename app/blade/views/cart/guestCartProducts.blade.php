@php
    use app\service\AuthService\AuthService;use app\view\components\Icon\Icon;
    $index = 1;
@endphp

@foreach ($order['products'] as $i => $product)
    @deb


    <div class="row cart-item" data-product_1s_id="{!!$product['1s_id']!!} ">

        <div class="num cell">{!!$index++!!}</div>

        <a href="/product/{!!$product['slug']!!}" class="name">
            <img class="img" src="{!!$product['mainImage']!!}" alt="{!!$product['name']!!}">
        </a>

        <div class="product-name cell">

            @if (AuthService::getUser())
                <a href="/adminsc/product/edit/{!!$product['id']??null!!}"
                   class="edit card-panel-item">{!!Icon::edit()!!}</a>
            @endif
            <a href="/product/{!!$product['slug']!!}" class="name">{!!$product['name']!!}</a>
        </div>

        <div class="cart-shippable-table cell">
            @php
                $showToCartButton = false;
                $plus_minus_buttons = false;
                $orderitems = $product['cart_items'];
            @endphp

            @include('components.shippable_units.shippableUnits', compact('product', 'orderitems', 'showToCartButton', 'plus_minus_buttons'))

{{--            @include('components.shippable_units.shippableUnits', ['product'=>$product??[],'orderitems' => $product['cart_items']??[], 'showToCartButton'])--}}

        </div>

        @include('cart.cartSubSum')

        <div class="del cell">{!!Icon::trashWhite()!!}</div>
    </div>

@endforeach


@include('cart.total')
