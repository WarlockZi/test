<div class="price">
    <?php if ($product->baseUnit): ?>
    <?php
    $price = $product->getRelation('price')->price;
    $unit  = $product->baseUnit->name;
    ?>

    <div class="new-price">
        <?= number_format($price, 2, '.', ' ') ?> ₽ / <?= $unit; ?>
    </div>

</div>
<div class="price-units ">
    <?php if ($product->dopUnits): ?>
        <?php foreach ($product->dopUnits as $unit): ?>
            <?php $multiplier = $unit->pivot->multiplier ?>
            <div class="price-unit-row ">

                <div class="price-for-unit">
                    <?= number_format((int)$price * $multiplier, 2, '.', ' ') ?>
                </div>
                ₽ /
                <div class="unit">
                    <?= $unit->name ?>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php else: ?>
        Цену уточняйте у менеджера
    <?php endif; ?>
</div>
