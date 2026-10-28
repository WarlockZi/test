<div class="shippable-table">

    @if($showToCartButton)
        @include('components.shippable_units.to_cart_button')
    @endif

    @foreach($product['shippable_units'] as $shippable)

{{--        @deb--}}
        @php
            $count = 0;
            foreach ($orderitems as $orderitem){
            $orderitem = $orderitem[0]??$orderitem;
                if ($shippable['id']===$orderitem['unit_id']) {
                    $count = $orderitem['count'];
                }
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

            @if($plus_minus_buttons)
                @include('components.shippable_units.plus_minus_buttons')
            @endif

        </div>

    @endforeach

</div>
