<div custom-table
        {!!$data['class']??''!!}
        {!!$data['dataAttributes']??''!!}
>

    <div class='table-title'>{!!$data['pageTitle']??''!!}</div>

    @foreach($data['header'] as $title=>$html)
        <div class="table-header-row">
                {!!$title??''!!} : {!!$html??''!!}
        </div>
    @endforeach
{{--@deb--}}
    <div class="custom-table" {!!$data['grid']??''!!}>

        <!--  HEADER  -->
        @foreach ($data['columns'] as $c)
            <div
                    {!!$c->classHeader??''!!}
                {!!$c->sort??''!!}
            >
                    {!!$c->sortIcon??''!!}
                    {!!$c->name??''!!}
                    {!!$c->search??''!!}
            </div>
        @endforeach

        <!--  TABLE  -->

        <!--   Empty row-->
        @include('admin.components.table.row.emptyRow',compact('data','c'))

        <!--		 Data rows-->

        @if (count($data['items']))
            @foreach ($data['items'] as $item)

                @foreach ($data['columns'] as $field => $c)

                    @include('admin.components.table.row.tableRow', compact('field', 'c','item'))

                @endforeach
            @endforeach
        @endif

    </div>

    @if (!$data['items']->count())
        <h3 class="no-items">Элементы не найдены</h3>
    @endif

          <!--  ADD BUTTON  -->
    @if($data['addButton'])
        <div class="buttons">
            <div class="add-model" {!!$data['pivot']!!}>+</div>
        </div>
    @endif

</div>
