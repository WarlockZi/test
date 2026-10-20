<div class="shippable-table">

    @if(!isset($showToCartButton))
        <a href="/cart" class='button to-cart-button'>
            Перейти в корзину
        </a>
    @endif

    @foreach($product['shippable_units'] as $shippable)

        @php
            $count = 0;
            foreach ($orderitems as $orderitem)
            if ($shippable['id']===$orderitem['unit_id']) {
                $count = $orderitem['count'];
            }
        @endphp

        <div
                unit-row
                class="unit-row"
                data-unit_id="{!!$shippable['id']??''!!}"
        >
            <input
                    type="text"
                    class="input"
                    value="{!!$count??"0"!!}"
                    onclick="this.value??'';"
            >

            <div class="unit-name">{!!data_get($shippable,['name'], 'ед.')!!}</div>

            <div class="cost"
                 @php $price = $shippable['pivot']['price']??'0'; @endphp

                 data-cost="{{$price}}">
                {{$price?number_format($price,2,'.',' '):0}}
            </div>
            <div class="currency">₽</div>


            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>

        </div>

    @endforeach

</div>
