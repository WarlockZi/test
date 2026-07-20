<div class="products" data-model="product">

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
            @foreach ($category['products_not_in_store_in_matrix'] as $product)
                @if (str_ends_with($product['name'], '*'))
                    @include('category.product_card', compact('product'))
                @endif
            @endforeach
        </div>
    @endif
</div>

<div id="seo_article">
    <?= $category['own_properties']['seo_article'] ?>
</div>
