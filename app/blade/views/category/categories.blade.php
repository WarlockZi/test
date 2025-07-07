@extends('layouts.main.main')

@php xdebug_break()@endphp

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
    <h1 class="page-name">Каталог</h1>
    <div class="category">


        @if (isset($categories) && $categories)

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
                            @php $forBreadcrumbs= false; @endphp
                            @include('components.category_card_panel', compact('category', 'forBreadcrumbs'))
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
