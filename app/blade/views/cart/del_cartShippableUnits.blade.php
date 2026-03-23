<div class="shippable-table">

    @foreach($product['shippable_units'] as $shippable)

        @php
            $count = 0;
                foreach($product['orderitems'] as $orderitem){
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
        >
            <input
                    type="text"
                    class="input"
                    value="{!!$count??0!!}"
                    onclick="this.value??'';"
            >

            <div class="unit-name">{!!$shippable['name']!!}</div>

            <div class="cost"
                 data-cost="{{$shippable['pivot']['price']}}">
                {{number_format($shippable['pivot']['price'],2,'.',' ')}}
            </div>
            <div class="currency">₽</div>


            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>

        </div>

    @endforeach

</div>
