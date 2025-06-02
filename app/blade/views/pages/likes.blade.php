@extends('layouts.main.main')

@section('content')
    @php xdebug_break() @endphp
    @include('admin.components.table.tableStandAlone', ['data'=>$content])
{{--    {!!  $content!!}--}}
@endsection