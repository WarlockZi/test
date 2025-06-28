@extends('layouts.main.main')

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

{{--            @dd($category['ownProperties']->toArray())--}}

            <h1>{{$category['ownProperties']['seo_h1'] ?? $category->name}}</h1>

            @if ($category['childrenRecursive']->count())

                <div class="category-child-wrap">
                    @foreach ($category['childrenRecursive'] as $child)
                        @include('category.category_card', compact('child'))
                    @endforeach
                </div>
            @endif


            <div class="products-header">
                <h2>Товары в наличии</h2>
            </div>

            <div class="product-wrap">
                @if ($category->productsInStore->count())
                    @foreach($category->productsInStore as $product)
                        @include('category.product_card', compact('product'))
                    @endforeach
                @else
                    Товары не найдены
                @endif
            </div>


            <div class="products-header">
                <h2>Товары под заказ</h2>
            </div>
            <div class="product-wrap">
                @if ($category->productsNotInStoreInMatrix->count())
                    @foreach ($category->productsNotInStoreInMatrix as $product)
                        @if (str_ends_with($product->name, '*'))
                            @include('category.product_card', compact('product'))
                        @endif
                    @endforeach
                @else
                    Товары не найдены
                @endif
            </div>

            <div id="seo_article">
                    <?= $category->seo_article() ?>
            </div>

        @endif


    </div>
@endsection
