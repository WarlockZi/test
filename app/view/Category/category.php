<div class="category">

    <?php if (empty($category)): ?>
        <div class="no-categories">
            <H1>Внимание! Приносим свои извинения,
                но раздел <?= '' ?> находится на стадии разработки.
                В самое ближайшее время он будет наполнен,
                и Вы сможете совершить покупку у нас на самых выгодных условиях!
                В настоящее время Вы можете ознакомиться
                с ассортиментом других разделов нашего сайта:</H1>

            <ol>

                <? if (is_array($rootCategories) && !empty($rootCategories)): ?>
                    <? foreach ($rootCategories as $cat): ?>
                        <li>
                            <a href="<?= $cat['href'] ?>"><?= $cat['name'] ?></a>
                        </li>
                    <? endforeach ?>
                <? endif; ?>

            </ol>

        </div>
    <?php else: ?>

        <?= $breadcrumbs ?? '' ?>
        <h1><?= $category->ownProperties->seo_h1 ?? $category->name; ?></h1>

        <?php if ($category['childrenRecursive']->count()): ?>

            <div class="category-child-wrap">
                <?php foreach ($category['childrenRecursive'] as $child): ?>
                    <div class="category-card">
                        <a class="category-card-a" href="<?= $child->href; ?>">
                            <?= $child->name ?>
                        </a>
                        <?= \app\view\share\card_panel\CardPanel::categoryCardPanel($child) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <?php if ($category->productsInStore->count()): ?>

            <div class="products-header">
                <h2>Товары в наличии</h2>
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
            </div>

            <div class="product-wrap">
                <?php foreach ($category->productsNotInStoreInMatrix as $product): ?>
                    <?php if (str_ends_with($product->name, '*')): ?>
                        <?php include 'product_card.php' ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div id="seo_article">
            <?= $category->seo_article() ?>
        </div>

    <?php endif; ?>


</div>

