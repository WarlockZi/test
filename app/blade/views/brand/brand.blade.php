@extends('layouts.main.main')

@section('title')
    {!! $meta->title !!}
@endsection

@section('description')
    {!! $meta->description !!}
@endsection

@section('keywords')
    {!! $meta->keywords !!}
@endsection

@section('content')
    <main class="brand-page">
        <h1>{!! $brand !!}</h1>
    </main>
@endsection