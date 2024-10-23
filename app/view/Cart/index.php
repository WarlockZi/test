<? use app\core\Icon;
use \app\view\share\shippable\ShippableUnitsTableFactory;

$authed = \app\core\Auth::isAuthed();
?>
<div class="cart">

    <div class="<?= $products->count() ? '' : 'none'; ?> content">

        <div class="page-name">Корзина</div>

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

            <?php if (!$authed && !$lead): ?>
                <div class="buttons">
                    <div class="button" id="cartLead">Оставить свои данные</div>
                    <div class="button" id="cartLogin">Войти</div>
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




