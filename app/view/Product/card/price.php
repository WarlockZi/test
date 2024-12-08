<? $arr = $order->unitsTable[$order['1s_id']]; ?>
<div class="price">

    <div class="new-price">
        <?="{$arr['formatted_price']} {$arr['currency']} / {$order->baseUnit->name}";?>
    </div>

</div>
<div class="price-units ">
    <?= $shippablePrices; ?>
</div>
