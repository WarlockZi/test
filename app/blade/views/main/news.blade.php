@extends('layouts.main.main_with_meta')

@section('content')
    <main class="news" data-jsmodule="main">

        <h1>Новости</h1>

        <?= $content; ?>
    </main>
@endsection