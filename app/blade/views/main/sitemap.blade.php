@section('title', $meta->title)
@section('description', $meta->description)
@section('keywords', $meta->keywords)


@extends('layouts.main.main')

@section('content')
    <div class="sitemap">

        <h1>Карта сайта</h1>

        <?= $content ?? ''; ?>
    </div>
@endsection