<?php use app\core\Icon;
use app\view\share\shippable\ShippableUnitsTableFactory;

$authed = \app\core\Auth::getUser();
?>
<div class="cart">

    <div class="<?= $orders->count() ? '' : 'none'; ?> content">

        <h1 class="page-name">Корзина</h1>

        <div class="table" data-model="<?= $authed ? 'order' : 'orderItem'; ?>">

            <?php foreach ($orders as $order): ?>

                <?php foreach ($order->items as $i => $orderItem): ?>

                    <div class="row cart-item" data-product-id="<?= $orderItem['product_id']; ?>">
                        <div class="num cell"><?= ++$i; ?></div>

                        <img src="<?= $orderItem->product?->mainImagePath; ?>" alt="<?= $orderItem->product?->name; ?>">

                        <div class="name-price cell">
                            <a href="/product/<?= $orderItem->product?->slug; ?>"
                               class="name">
                                <?= $orderItem->product?->name; ?>
                            </a>
                        </div>

                        <div class="cart-shippable-table cell">

                            <?= ShippableUnitsTableFactory::create($orderItem, 'cart'); ?>
                        </div>

                        <div class="sub-sum sum cell"></div>
                        <div class="del cell"><?= Icon::trashWhite(); ?></div>
                    </div>

                <?php endforeach; ?>
            <?php endforeach; ?>


            <div class="total">
                <div class="title">Всего -&nbsp;&nbsp;</div>
                <span></span>
            </div>

            <div class="buttons">
                <?php if (!\app\core\Auth::getUser()): ?>
                    <div class="button" id="cartLogin"
                         title="Чтобы оформить заказ Вам &#10;необходимо зарегистрироваться &#10;или войти под своей учеткой">
                        Войти
                    </div>
                <?php else: ?>
                    <div class="button" id="cartSubmit">Оформить заказ</div>
                <?php endif; ?>
            </div>

        </div>

    </div>
    <div class="empty-cart <?= $orders->count() ? 'none' : ''; ?>">
        Корзина пуста
    </div>
</div>




