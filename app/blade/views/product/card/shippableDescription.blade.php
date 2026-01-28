{{--@deb--}}
<div class="description text-small">
    <span class="cost"
          data-cost="{{$shippableUnit['pivot']['price']??'0'}}"
    >
            {{$shippableUnit['pivot']['price']??'0'}} ₽
    /
        </span>
        <span class="contains">
            {!!$shippableUnit['pivot']['multiplier']??0!!} {!!$product['base_unit']['name']??'баз. ед.'!!}
        </span>
</div>


