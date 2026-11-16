@extends('layouts.main.main')

@section('error')
    @if(\app\service\AuthService\AuthService::getUser()->isAdmin()
||\app\service\AuthService\AuthService::getUser()->isAdmin())
{{--        @deb--}}
        {{$exception->getFile()}}
        <br>
        {{$exception->getLine()}}
        <br>
        {{$exception->getMessage()}}
        <br>
        {!!str_replace("\n", "<br>", $exception->getTraceAsString())!!}

    @else
        <h1>Ошибка сервера</h1>
    @endif
@endsection