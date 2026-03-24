<div class="sub-sum sum cell">

    @foreach($product['shippable_units'] as $shippableUnit)

{{--        @foreach($product['orderitems'] as $oi)--}}
{{--            @if(!empty($oi['product_unit']['unit']) && $oi['product_unit']['unit']['id']===$shippableUnit['id'])--}}
{{--                @php($orderItem = $oi)--}}
{{--            @endif--}}
{{--        @endforeach--}}

        <div class="row-sum">
                0
{{--            @if(isset($orderItem))--}}
{{--                @php--}}
{{--                    $subSum = $shippableUnit['pivot']['divider']--}}
{{--                    *$orderItem['product_unit']['price']--}}
{{--                    *$orderItem['count']--}}
{{--                @endphp--}}
{{--                {!!empty($subSum)?'-':number_format($subSum, 2, '.', ' ')!!}--}}
{{--            @else--}}
{{--                0--}}
{{--            @endif--}}
        </div>

    @endforeach

</div>