<div class="products" data-model="product">
    @if (!empty($category->productsInStore))
        <div class="products-header">
            <h2>Товары в наличии</h2>
        </div>

        <div class="product-wrap">
            @foreach($category->productsInStore as $product)
                @include('category.product_card', compact('product'))
            @endforeach
        </div>

    @endif


    @if (!empty($category->productsNotInStoreInMatrix))
        <div class="products-header">
            <h2>Товары под заказ</h2>
        </div>

        <div class="product-wrap">
            @foreach ($category->productsNotInStoreInMatrix as $product)
                @if (str_ends_with($product['name'], '*'))
                    @include('category.product_card', compact('product'))
                @endif
            @endforeach
        </div>
    @endif
</div>
{{--@deb--}}
<div id="seo_article">
    {!!$category->ownProperties->seo_article!!}
</div>
