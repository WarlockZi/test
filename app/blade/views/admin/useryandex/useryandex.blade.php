@extends('layouts.admin.admin')

@section('content')
    <div class="page-name">Пользователь</div>

    @include('admin.components.table.table', ['content'=>$content])

@endsection
