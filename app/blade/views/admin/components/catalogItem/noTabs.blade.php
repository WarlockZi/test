<div class="item_content">

    <!--  TABLE  -->
    @foreach ($this->fields as $field)
        @include('admin.components.catalogItem.row',['$field'=>$field])
    @endforeach

    @include('admin.components.catalogItem.buttons')

</div>

