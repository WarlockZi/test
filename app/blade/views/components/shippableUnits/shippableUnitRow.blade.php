<div
        unit-row
        class="unit-row"
        data-unitid="{!! $row['unit_id'] !!}"
        data-multiplier="{!! $row['multiplier'] !!}"
        data-orderitem-id="{!! $row['order_item_id']??''!!}">
    <input
            type="text"
            class="input"
            value="{!! $row['count']??0 !!}"
            onclick="this.value??'';"
    >

    <div class="unit-name">
        <span class="name">{!! $row['unit_name'] !!}</span>

        @if($shippableTable->description)
{{--            @php xdebug_break() @endphp--}}
            <div class="description text-small">
                <span class="contains">{!! $row['multiplier'] !!} {!! $row['base_unit_name'] !!}</span>
                <span class="cost" data-cost="{{$row['unit_price']}}">{{$row['formatted_unit_price']}} ₽</span>
            </div>
        @endif

    </div>

    <div class="arrows">
        <div class="arrow plus"></div>
        <div class="arrow minus"></div>
    </div>


</div>