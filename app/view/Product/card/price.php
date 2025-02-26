<? $arr = $product->unitsTable[$product['1s_id']]; ?>
<div class="price">

    <div class="new-price">
        <?="{$arr['formatted_price']} {$arr['currency']} / {$product->baseUnit->name}";?>
    </div>

</div>
<div class="price-units ">
    <?= $shippablePrices; ?>
</div>
