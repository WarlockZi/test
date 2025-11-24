@extends('layouts.main.main')


@section('title')
    {!!$meta['title']!!}
@endsection

@section('description')
    {!!$meta['description']!!}
@endsection

@section('keywords')
    {!!$meta['keywords']!!}
@endsection

@section('error')
    @include('layouts.main.error')
@endsection

@section('content')
    <h1 class="page-name">Каталог</h1>
    <div class="category">


        @if (!empty($categories))

            <div class="category-child-wrap">

                @foreach($categories as $category)
                    @if ($category)

                        <div class="category-card">

                            <a
                                    class="category-card-a"
                                    href="/catalog/{{$category['slug']}}"
                            >
                                {{$category['name']}}
                            </a>
                            @include('components.card_panel.category_card_panel', compact('category'))
                        </div>

                    @endif

                @endforeach
            </div>

        @else
            <div class="no-categories">
                <H1>Категорий нет</H1>
            </div>
        @endif

    </div>

@endsection
