@extends('layouts.main.main')

@section('title', $category['meta']['seo_title'])

@section('description')
    {!!$category['meta']['seo_desc']!!}
@endsection

@section('keywords')
    {!!$category['meta']['seo_keywords']!!}
@endsection

@section('error')
    @include('layouts.main.error')
@endsection

@section('content')

    <div class="category">

        @if (empty($category))
            <div class="no-categories">
                <H1>Внимание! Приносим свои извинения,
                    но раздел <?= '' ?> находится на стадии разработки.
                    В самое ближайшее время он будет наполнен,
                    и Вы сможете совершить покупку у нас на самых выгодных условиях!
                    В настоящее время Вы можете ознакомиться
                    с ассортиментом других разделов нашего сайта:</H1>

                <ol>

                    @if (!empty($rootCategories) && is_array($rootCategories))
                        @foreach ($rootCategories as $cat)
                            <li>
                                <a href="<?= $cat['own_properties']['path'] ?>"><?= $cat['name'] ?></a>
                            </li>
                        @endforeach
                    @endif

                </ol>

            </div>

        @else

            @include('components.breadcrumbs.index')
            <h1>{!!$category['own_properties']['page_title'] ?? $category['own_properties']['seo_h1'] ?? $category['own_properties']['seo_full_name'] ?? $category['name']!!}</h1>


            @if (!empty($category['children_recursive']))
                {{-- если это родительская категория, покажем детей--}}
                @include('category.category_children')
            @else
                @include('category.category_products')
            @endif
        @endif

    </div>
@endsection
