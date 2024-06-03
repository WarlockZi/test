<div class="order-edit">

    <div class="page-name">Заказ <span id="order-id">&nbsp;новый</span></div>

    <div class="row user">
        <div class="client">
            Клиент -
        </div>
        <div class="email"><?= $orders[0]->user->email ?></div>
        <div class="fio"><?= $orders[0]->user->fi() ?></div>
    </div>

    <div class="row manager">
        <div class="manager">
            Менеджер -
        </div>
        <?= \app\view\Product\ProductArrayFormView::getManagerSelector(); ?>
    </div>

    <?php foreach ($orders as $order): ?>
        <?php if ($order->product): ?>

            <div class="row">
                <div class="num"><?= $order->id ?></div>
                <div class="name-price">
                    <div class="name"><?= $order->product->name ?></div>
                    <div class="price"></div>
                    <!--		  <div class="id">--><?php //= $order->user->email ?><!--</div>-->
                </div>
                <div class="count"><?= $order->total_count ?></div>
                <div class="unit count"><?= $order->unit->name ?></div>
                <?$o = $order->toArray();?>
                <?php if ($order->deleted_at): ?>
                    <div class="active count"><?= $order->deleted_at ?></div>
                <?php else: ?>
                    <div class="deleted count"><?= $order->deleted_at ?></div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="not-found">Товар не найден</div>
        <?php endif; ?>

    <?php endforeach; ?>

    <a href="/adminsc/order">
        <div class="button">К списку заказов</div>
    </a>

</div>


