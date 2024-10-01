<?=$table??'';?>

<div class="order-edit">

    <div class="page-name">Заказ <span id="order-id">&nbsp</span></div>

    <div class="row user">
        <div class="client">
            Клиент -
        </div>
        <strong class="email"><?= $orders[0]->user->email ?></strong>
        <div class="fio"><?= $orders[0]->user->fi() ?></div>
    </div>

    <div class="row manager">
        <div class="manager">
            дата -
            <strong>
            <?=$orders[0]->created_at?>

            </strong>
        </div>
    </div>

    <div class="row manager">
        <div class="manager">
            Менеджер -
            <strong><?=$manager??'заказ не обработан'?></strong>
        </div>
    </div>
    <hr>
    <?php foreach ($orders as $order): ?>
        <?php if ($order->product): ?>

            <div class="row">
                <div class="num"><?= $order->id ?></div>
                <div class="name-price">
                    <a href="/adminsc/product/edit/<?=$order->product->id?>" class="name"><?= $order->product->name ?></a>
                    <div class="price"></div>
                    <!--		  <div class="id">--><?php //= $order->user->email ?><!--</div>-->
                </div>
                <div class="count"><?= $order->total_count ?></div>
                <div class="unit count"><?= $order->unit->name ?? 'неустановленная единица' ?></div>
                <div class="date"><?= $order->created_at ?? 'дата' ?></div>
                <? $o = $order->toArray(); ?>
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


