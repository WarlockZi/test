<div class="sub-sum sum cell">

    @foreach($product['shippable_units'] as $unit)

        @foreach($product['order_items'] as $oi)
            @if(!empty($oi['product_unit']['unit']) && $oi['product_unit']['unit']['id']===$unit['id'])
                @php($orderItem = $oi)
            @endif
        @endforeach

        <div class="row-sum">
            @if(isset($orderItem))
{{--                @deb--}}
                @php
                    $subSum = $unit['pivot']['multiplier']
                    *$orderItem['product_unit']['price']
                    *$orderItem['count']
                @endphp
                {!!empty($subSum)?'-':number_format($subSum, 2, '.', ' ')!!}
            @else
                0
            @endif
        </div>

    @endforeach

</div>