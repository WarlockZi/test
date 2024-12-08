<?php
if ($order): ?>

    <?php if ($order->deleted_at): ?>
        <div class="deleted-overlay">
            <h1 class="deleted">
                Товар закончился
            </h1>

        </div>
    <?php endif; ?>
    <div class="product-card" data-1sid="<?= $order['1s_id']; ?>">

        <?= $breadcrumbs ?>
        <h1><?= $order['print_name']; ?></h1>


        <div class="product-card_hero">
            <? include 'main_image.php'?>
            <? include 'card/toCart.php' ?>
        </div>

        <div class="info-wrap">
            <div class="info-tag">Информация о товаре</div>
            <div class="properties">
                <h2><?=$order->seo_h1()?></h2>

                <div id="seo-article"><?=$order->seo_article()?></div>

                <?php foreach ($order->values as $value): ?>
                    <?php include __DIR__ . '/property.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="info-wrap">
            <div class="info-tag">Характеристики</div>

            <article id="detail-text"><?= $order->txt; ?></article>
        </div>



        <?php //include __DIR__.'/card/olsoLike.php'?>
        <?php //include __DIR__.'/card/rating.php'?>


<!--        --><?php //= Icon::star() ?>
        <!--		 --><?php // include __DIR__ . '/card/reviews.php' ?>
        <!--		 --><?php // include __DIR__ . '/card/alsoViewd.php.php' ?>

    </div>


<?php else: ?>
    <div>Такого товара нет</div>
    <a href="/adminsc/category">Перейти в каталог</a>
<? endif; ?>
