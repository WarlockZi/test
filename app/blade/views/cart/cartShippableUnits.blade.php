<div
        shippable-table
        class="shippable-table"
{{--        @deb--}}
             data-price='{{$product['base_unit']['pivot']['price']??'***'}}'
>

    @foreach($product['shippable_units'] as $shippable)
        @php
            foreach($product['order_items'] as $orderitem){
                if(isset($orderitem['product_unit']['unit'])
                && $orderitem['product_unit']['unit']['id']==$shippable['id']){
                    $count = $orderitem['count'];
                    break;
                }
        }
        @endphp


        <div
                unit-row
                class="unit-row"
                data-unit_id="{!!$shippable['id']??''!!}"
                data-multiplier="{!!$orderitem['product_unit']['multiplier']??''!!}"
        >
            <input
                    type="text"
                    class="input"
                    value="{!!$count??0!!}"
                    onclick="this.value??'';"
            >

            <div class="unit-name">
                <span class="name">{!!$shippable['name']!!}</span>

                <div class="ps-2 description text-small">
                        <span class="cost"
                              data-cost="{{$shippable['pivot']['price']}}">
                            {{$shippable['pivot']['price']}} ₽
                        </span>

{{--                    <span class="contains">({!!$shippable['pivot']['multiplier']!!}--}}
{{--                        {!!$product['base_unit']['name']?? '-'!!})--}}
{{--                    </span>--}}
                </div>

            </div>

            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>

        </div>

    @endforeach
</div>
