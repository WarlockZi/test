@extends('layouts.main.main')

{{--        @php         xdebug_break() @endphp--}}
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
                                <a href="<?= $cat['href'] ?>"><?= $cat['name'] ?></a>
                            </li>
                        @endforeach
                    @endif

                </ol>

            </div>

        @else
            @include('components.breadcrumbs.index')

            <h1>{{$category['own_properties']['seo_h1'] ?? $category->name}}</h1>

            @if (!empty($category['children_recursive']))

                <div class="category-child-wrap">
                    @foreach ($category['children_recursive'] as $child)
                        @include('category.category_card', compact('child'))
                    @endforeach
                </div>
            @endif


            @if (!empty($category['products_in_store']))
                <div class="products-header">
                    <h2>Товары в наличии</h2>
                </div>

                <div class="product-wrap">
                    @foreach($category['products_in_store'] as $product)
                        @include('category.product_card', compact('product'))
                    @endforeach
                </div>

            @endif


            @if (!empty($category['products_not_in_store_in_matrix']))
                <div class="products-header">
                    <h2>Товары под заказ</h2>
                </div>
                <div class="product-wrap">
                    @foreach ($category['products_notin_store_in_matrix'] as $product)
                        @if (str_ends_with($product->name, '*'))
                            @include('category.product_card', compact('product'))
                        @endif
                    @endforeach
                </div>
            @endif

            <div id="seo_article">
                    <?= $category['own_properties']['seo_article'] ?>
            </div>

        @endif


    </div>
@endsection
