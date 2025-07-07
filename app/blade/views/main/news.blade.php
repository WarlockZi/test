@section('title', $meta->title)
@section('description', $meta->description)
@section('keywords', $meta->keywords)

@extends('layouts.main.main')

@section('content')
    <main class="news">

        <h1>Новости</h1>

        <?= $content; ?>
    </main>
@endsection