<div class="shippable-table">

    <div class="button blue-button">Добавить</div>

    <div class="green-button-wrap">
        <a href="/cart" class="button green-button">Перейти в корзину</a>
        <?= \app\view\Cart\CartView::cartTable($order) ?>
    </div>

</div>
