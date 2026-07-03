@php use app\service\Nonce\Nonce;
 $hash = mt_rand(1000,9999)
@endphp

@deb
<style nonce="{!!Nonce::getNonce()!!}">
    .grid-col-template-{!!$hash!!}  {
        grid-template-columns: {!!$data['grid']!!};
    }
</style>

<div custom-table
        {!!$data['class']??''!!}
        {!!$data['dataAttributes']??''!!}
>

    <div class='table-title'>{!!$data['pageTitle']??''!!}</div>

    <div class="custom-table grid-col-template-{!!$hash!!}">

        <!--  Head  -->
        @include('admin.components.table.head.head')

        <!--  Empty row-->

        @include('admin.components.table.row.emptyRow')

        <!-- Data rows-->
        @include('admin.components.table.row.rows')

    </div>

    {{--@deb--}}
    @if (!$data['items']->count())
        @include('admin.components.noItems.index')
    @endif

    <!--  ADD BUTTON  -->
    @if($data['addButton'])
        <div class="buttons">
            <div class="add-model" {!!$data['pivot']!!}>+</div>
        </div>
    @endif

</div>
