<? use \app\view\share\ShippableUnitsTableFactory; ?>
<div class="cart">

    <div class="<?= $products->count() ? '' : 'none'; ?> content">

        <div class="page-title">Корзина</div>

        <?php include 'counter.php' ?>

        <div class="table" data-model="<?= $authed ? 'order' : 'orderItem'; ?>">

            <?php foreach ($products as $i => $product): ?>

                <div class="row" data-product-id="<?= $product['1s_id']; ?>">
                    <div class="num cell"><?= ++$i; ?></div>

                    <img src="<?= $product->mainImagePath ?>" alt="<?= $product->name; ?>">

                    <div class="name-price cell">
                        <a href="/product/<?= $product->slug; ?>"
                           class="name">
                            <?= $product->name; ?>
                        </a>
                    </div>

                    <div class="cell cart-shippable-table">
                        <?= ShippableUnitsTableFactory::create($product, 'cart'); ?>
                    </div>

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
    <div class="empty-cart <?= $products->count() ? 'none' : ''; ?>">
        Корзина пуста
    </div>
</div>




