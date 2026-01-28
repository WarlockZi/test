<div
        unit-row
        class="unit-row"
        data-unitid="{!!$unit['id']!!}"
{{--        @php(xdebug_break())--}}
        data-multiplier="{!!$unit['pivot']['multiplier']!!}"
{{--        data-orderitem-id="{!!$orderItem['id']??''!!}"--}}
>
    <input
            type="text"
            class="input"
            value="{!!$unit['count']??0!!}"
            onclick="this.value??'';"
    >

    <div class="unit-name">
        <span class="name">{!!$unit['full_name']!!}</span>

{{--        @if($shippableTable->description)--}}
{{--            <div class="description text-small">--}}
{{--                <span class="contains">{!!$unit['multiplier']!!} {!!$unit['base_unit_name']!!}</span>--}}
{{--                <span class="cost" data-cost="{{$unit['unit_price']}}">{{$unit['formatted_unit_price']}} ₽</span>--}}
{{--            </div>--}}
{{--        @endif--}}

    </div>

    <div class="arrows">
        <div class="arrow plus"></div>
        <div class="arrow minus"></div>
    </div>


</div>