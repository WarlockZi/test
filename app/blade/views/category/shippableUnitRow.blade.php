<div
        unit-row
        class="unit-row"
        data-unitid="{{$row['unit']->id}}"
        data-multiplier="{{$row['multiplier']}}"
        data-orderitem-id="{{$row['orderItem']?->id??''}}">
    <input
            type="text"
            class="input"
            value="0"
            onclick="this.value??'';"
    >

    <div class="unit-name">
        <span class="name">{{$row['unit']->name}}</span>

        <div class="description text-small">
            <span class="contains">{{$row['multiplier']}} {{$row['baseUnit']}}</span>
            <span class="cost" data-cost="{{$row['cost']}}">{{$row['formattedCost']}} ₽</span>
        </div>
    </div>

    <div class="arrows">
        <div class="arrow plus"></div>
        <div class="arrow minus"></div>
    </div>


</div>