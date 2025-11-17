<div class="sub-sum sum cell">

    @foreach($product['shippable_units'] as $unit)

        @foreach($product['order_items'] as $oi)
            @if(!empty($oi['unit'][0])&&$oi['unit'][0]['id']===$unit['id'])
                @php($orderItem = $oi)
            @endif
        @endforeach

        <div class="row-sum">
            @if(isset($orderItem))
                @php
                    $subSum = $unit['pivot']['multiplier']*$orderItem['unit'][0]['pivot']['price']*$orderItem['count']
                @endphp
                {!!empty($subSum)?'-':number_format($subSum, 2, '.', ' ')!!}
            @else
                0
            @endif
        </div>

    @endforeach

</div>