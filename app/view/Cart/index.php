<? use app\core\Icon;
use app\view\share\shippable\ShippableUnitsTableFactory;

$authed = \app\core\Auth::getUser();
?>
<div class="cart">

    <div class="<?= $products->count() ? '' : 'none'; ?> content">

        <h1 class="page-name">Корзина</h1>

        <!--        --><?php //include 'counter.php' ?>

        <div class="table" data-model="<?= $authed ? 'order' : 'orderItem'; ?>">

            <?php foreach ($products as $i => $product): ?>

                <div class="row" data-product-id="<?= $product['1s_id']; ?>">
                    <div class="num cell"><?= ++$i; ?></div>

                    <img src="<?= $product->mainImagePath; ?>" alt="<?= $product->name; ?>">

                    <div class="cell name-price cell">
                        <a href="/product/<?= $product->slug; ?>"
                           class="name">
                            <?= $product->name; ?>
                        </a>
                    </div>

                    <div class="cart-shippable-table cell">
                        <?= ShippableUnitsTableFactory::create($product, 'cart'); ?>
                    </div>

                    <div class="sub-sum sum"></div>
                    <div class="del"><?= Icon::trashWhite(); ?></div>
                </div>

            <?php endforeach; ?>


            <div class="total">
                <div class="title">Всего -&nbsp;&nbsp;</div>
                <span></span>&nbsp;&nbsp;₽
            </div>

            <div class="buttons">
                <?php if (!$authed && !$lead): ?>
                    <div class="button" id="cartSuccess">Оформить заказ</div>
                <? else: ?>
                    <!--                    <div class="button" id="cartLead">Оставить свои данные</div>-->
                    <!--                    <div class="button" id="cartLogin">Войти</div>-->
                    <div class="button" id="cartLogin">Оформить заказ</div>
                <?php endif; ?>
            </div>

        </div>

    </div>
    <div class="empty-cart <?= $products->count() ? 'none' : ''; ?>">
        Корзина пуста
    </div>
</div>




