@extends('layouts.main.main_with_meta')

@section('content')
    <div class="sitemap">

        <h1>Карта сайта</h1>

        <?= $content ?? ''; ?>
    </div>
@endsection