@extends('layouts.main.main')

@section('title', $meta->title)
@section('description', $meta->description)
@section('keywords', $meta->keywords)

@section('content')
<main class="statii">

    <h1>Статьи</h1>
    <ul>

        <li>
            <a href="statii.php">
                Статья 1
            </a>
        </li>
        <li>
            <a href="statii.php">
                Статья 2
            </a>
        </li>
    </ul>

</main>
@endsection