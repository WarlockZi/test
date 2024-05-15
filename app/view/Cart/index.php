<div class="cart">

    <div class="<?= $oItems->count() ? '' : 'none'; ?> content">

        <div class="page-title">Корзина</div>

        <?php include 'counter.php' ?>

        <div data-model="<?= $authed ? 'order' : 'orderItem'; ?>">

            <?php foreach ($oItems as $i => $oItem): ?>

                <?php $product = $oItem->first()->product; ?>
                <div class="row" data-product-id="<?= $product['1s_id']; ?>">
                    <div class="num"><?= ++$i; ?></div>

                    <img src="<?= $product->mainImagePath ?>" alt="<?= $product->name; ?>">

                    <div class="name-price">
                        <a href="/product/<?= $product->slug; ?>"
                           class="name">
                            <?= $product->name; ?> ()
                        </a>

                        <div class="price-table"
                             data-price=<?= $product->price ?>
                        >

<!--                            --><?php //include __DIR__ . '/unitsTable.php';  ?>

                        </div>
                    </div>
                    <?php include dirname(__DIR__).'/share/shippableUnitTable.php' ?>

                    <div class="sum"></div>
                    <div class="del"><?= $trashedWhite; ?></div>
                </div>

            <?php endforeach; ?>


            <div class="total">
                <div class="title">Всего -&nbsp;&nbsp;</div>
                <span></span>&nbsp;&nbsp;₽
            </div>

            <?php if (!$authed && !$lead): ?>
                <div class="buttons">
                    <div class="button" id="cartLead">Оставить свои данные</div>
                    <div class="button" id="cartLogin">Войти под своей учеткой</div>
                </div>
            <?php else: ?>
                <div class="buttons">
                    <div class="button" id="cartSuccess">Оформить заказ</div>
                </div>
            <?php endif; ?>

        </div>

    </div>
    <div class="empty-cart <?= $oItems->count() ? 'none' : ''; ?>">
        Корзина пуста
    </div>
</div>




