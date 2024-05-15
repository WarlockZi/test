<?php

use app\core\Icon;

use app\view\Product\ProductFormView;
use \app\view\Product\ProductView;


if ($product): ?>

    <?php if ($product->deleted_at): ?>
        <div class="deleted-overlay">
            <h1 class="deleted">
                Товар закончился
            </h1>

        </div>
    <?php endif; ?>
    <div class="product-card" data-id="<?= $product['1s_id']; ?>">

        <?= $breadcrumbs ?>
        <h1><?= $product['print_name']; ?></h1>


        <div class="main-image-wrapper">

            <div class="detail-image">
                <?= ProductFormView::getCardImages('', $product->detailImages); ?>
            </div>

            <?= ProductView::getCardMainImage($product) ?>
            <?php include 'card/toCart.php' ?>
        </div>

        <?php if ($userIsAdmin): ?>
            <div class="product-card__edit">
                <a href="/adminsc/product/edit/<?= $product->id ?>">Редакт</a>
            </div>
        <?php endif; ?>

        <div class="info-wrap">
            <div class="info-tag">Характеристики</div>
            <div class="properties">
                <?php foreach ($product->values as $value): ?>
                    <?php include __DIR__ . '/property.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="info-wrap">
            <div class="info-tag">Информация о товаре</div>
            <article class="detail-text">
                <?= $product['txt']; ?>
            </article>
        </div>

        <?php //include __DIR__.'/card/olsoLike.php'?>
        <?php //include __DIR__.'/card/rating.php'?>


        <?= Icon::star() ?>
        <!--		 --><?php // include __DIR__ . '/card/reviews.php' ?>
        <!--		 --><?php // include __DIR__ . '/card/alsoViewd.php.php' ?>

    </div>


<?php else: ?>
    <div>Такого товара нет</div>
    <a href="/adminsc/category">Перейти в каталог</a>
<? endif; ?>
