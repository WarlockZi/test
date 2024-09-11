<div class="category">

    <?php if (!isset($category)): ?>
        <div class="no-categories">
            <H1>Такой категории нет</H1>
            <H1><?= $category ?></H1>
        </div>
    <?php else: ?>

        <?= $breadcrumbs ?? '' ?>
        <h1><?= "Категория - " . $category->name; ?></h1>

        <?php if ($category['childrenRecursive']->count()): ?>

            <div class="category-child-wrap">
                <?php foreach ($category['childrenRecursive'] as $child): ?>
                    <a class="category-card" href="/category/<?= $child->slug ?>">
                        <?= $child->name ?>
                    </a>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <?php if ($category->productsInStore->count()): ?>

            <div class="products-header">
                <h2>Товары в наличии</h2>
                <!--					--><?php //= $category->products->filters ?>
            </div>

            <div class="product-wrap">


                <?php foreach ($category->productsInStore as $product): ?>
                    <?php include 'product_card.php' ?>
                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <?php if ($category->productsNotInStoreInMatrix->count()): ?>

            <div class="products-header">
                <h2>Товары под заказ</h2>
                <!--					--><?php //= $category->products->filters ?>
            </div>

            <div class="product-wrap">


                <?php foreach ($category->productsNotInStoreInMatrix as $product): ?>
                    <?php if (str_ends_with($product->name, '*')): ?>
                        <?php include 'product_card.php' ?>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
        <div class="hoist">Наверх</div>
    <?php endif; ?>


</div>

