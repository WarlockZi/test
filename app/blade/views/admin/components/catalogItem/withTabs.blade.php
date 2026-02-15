<div class="item_tabs">
    @include('admin.components.catalogItem.tabs')
</div>

<div class="item_content">

    @deb
    @if(isset($catItem['item']['own_properties']['path']))
        <div class="share-info">
            <span>адрес :: </span>
            <a href="/{{$catItem['model']}}/{{$catItem['item']['own_properties']['path']}}">
                {{$catItem['item']['name']??''}}
            </a>
        </div>
    @endif

    <section data-tab="1" class="show">
        <!--  TABLE  -->
        @foreach ($catItem['fields'] as $field)
            @include('admin.components.catalogItem.row',['field'=>$field])
        @endforeach
    </section>

    @php $n = 2 @endphp
    @foreach ($catItem['tabs'] as $k => $tab)
        <section
                {!!$tab->field!!}
                data-tab={!!$n!!}
        >
            @if($tab->html)
                {!!$tab->html!!}
            @elseif($tab->tableData)
                @include('admin.components.table.tableStandAlone', ['data'=>$tab->tableData])
            @endif

        </section>
        @php $n++ @endphp
    @endforeach

    @include('admin.components.catalogItem.buttons', compact('catItem'))


</div>
