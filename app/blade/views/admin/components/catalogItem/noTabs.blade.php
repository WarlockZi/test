<div class="item_content">

    <!--  TABLE  -->
{{--@deb--}}
    @foreach ($catItem['fields'] as $field)
        @include('admin.components.catalogItem.row',['field'=>$field])
    @endforeach

    @include('admin.components.catalogItem.buttons')

</div>

