@php
    use app\service\AuthService\AuthService;use app\view\components\Icon\Icon;
    $i = 0;
@endphp

{{--@deb--}}
@php
    $first_key = array_key_first($orderitems);
    $order = data_get($orderitems, [$first_key, 0, 'order']);
    $checked= empty($order['in_process'])?'':'checked';
@endphp

<details>


    <summary >Заказ # {!!$order['id']!!} от {!!$order['created_at']!!}
        <label>{!!$order['in_process']!!}
        <input type="checkbox" data-order_id="{!!$order['id']!!}" {!!$checked!!}>
        </label>
    </summary>

    @foreach ($orderitems as $prdouct_1s_id => $orderitem)
        {{--        @deb--}}
        @php
            $orderitem = $orderitem[0];
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

                {{--            @deb--}}
                @include('admin.order.shippableUnits', compact('product', 'orderitem'))

            </div>

            @include('cart.cartSubSum')

            <div class="del cell">{!!Icon::trashWhite()!!}</div>
        </div>

    @endforeach


    <div class="total">
        <div class="title">Всего -&nbsp;&nbsp;</div>
        <span></span>
    </div>

</details>
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
