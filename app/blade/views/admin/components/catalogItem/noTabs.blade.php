<div class="item_content">

    <!--  TABLE  -->
{{--    @php xdebug_break() @endphp--}}
    @foreach ($catItem['fields'] as $field)
        @include('admin.components.catalogItem.row',['field'=>$field])
    @endforeach

    @include('admin.components.catalogItem.buttons')

</div>

