<div class="shippable-table">

    @if(!isset($showToCartButton))
        <a href="/cart" class='button to-cart-button'>
            Перейти в корзину
        </a>
{{--        <button >--}}
{{--        </button>--}}
    @endif

    @foreach($product['shippable_units'] as $shippable)

        @php
            $count =0;
            if(isset($order['products']) ){
                foreach($order['products'] as $orderProduct){
                    if ($orderProduct['1s_id']!==$product['1s_id']) continue;
                    foreach($orderProduct['orderitems'] as $orderitem){
                        if(!empty($orderitem['product_unit'])) {
                            if($orderitem['product_unit']['unit_id']==$shippable['id']){
                                $count = $orderitem['count'];
                                break;
                        }
                    }
                }
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

            <div class="unit-name">{!!$shippable['name']??'ед.'!!}</div>

            <div class="cost"
                 data-cost="{{$shippable['pivot']['price']??'0'}}">
                {{$shippable['pivot']['price']?number_format($shippable['pivot']['price'],2,'.',' '):0}}
            </div>
            <div class="currency">₽</div>


            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>

        </div>
    @endforeach

</div>
