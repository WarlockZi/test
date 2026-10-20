@extends('layouts.admin.admin')

@section('content')

    @if(isset($accounts))

        <div class="cart">
            <div class="order content" >
                <div class="table" id="order" data-jsmodule="order">
                    @foreach($accounts as $account)
                        @include('admin.order.account', compact('account'))
                    @endforeach
                </div>
            </div>
    @else
        <h1>нет выбранных аккантов</h1>
    @endif

    {{--    @include('admin.components.table.tableStandAlone', ['data'=>$unsubmittedTable])--}}
    {{--    @include('admin.components.table.tableStandAlone', ['data'=>$submittedTable])--}}
    {{--    {!!$unsubmittedTable!!}--}}
    {{--    {!!$submittedTable!!}--}}

@endsection