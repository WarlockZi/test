@extends('layouts.main.main')

@section('title', $meta->title)
@section('description', $meta->description)
@section('keywords', $meta->keywords)

@section('content')
<main class="statii">

    <h1>Статьи</h1>
    <ul class="blog-list">
        <li>
            <a href="/main/statii/rukovodstvo-po-vyboru-meditsinskikh-perchatok-dlya-personala-kliniki-i-laboratorii">
                <img src="/pic/blog/ikonka3.webp">
                Руководство по выбору медицинских перчаток для персонала клиники и лаборатории
            </a>
        </li>
        <li>
            <a href="/main/statii/meditsinskiye-prinadlezhnosti-kotoryye-dolzhny-byt-v-kazhdom-kabinete-vracha">
                <img src="/pic/blog/ikonka2.webp">
                Медицинские принадлежности, которые должны быть в каждом кабинете врача
            </a>
        </li>
        <li>
            <a href="/main/statii/kak-vybrat-kachestvennyye-meditsinskiye-perchatki-dlya-razlichnykh-sfer-deyatelnosti">
                <img src="/pic/blog/ikonka.webp">
                Как выбрать качественные медицинские перчатки для различных сфер деятельности?
            </a>
        </li>
    </ul>
</main>
@endsection