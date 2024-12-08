<?php foreach ($order->shippableUnits as $shippableUnit): ?>
    <div class="unit-row" data-unitId="<?=$shippableUnit->id?>">
        <button class="button minus">-</button>
        <input type="number" class="input">
        <button class="button plus">+</button>
        <div class="shippable-unit">
            <div value="<?= $shippableUnit->id ?>">
                <?= $shippableUnit->name ?>
                <?php if (!$shippableUnit->pivot->is_base): ?>
                    <span class="contains">
                        (<?= $shippableUnit->pivot->multiplier ?> <?= $order->baseUnit->name ?>)
                        </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php endforeach; ?>
