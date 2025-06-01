<select id="shippableSelector">

    <?php if ($order->shippableUnits->count()): ?>
        <?php foreach ($order->shippableUnits as $shippable): ?>
            <option value="<?= $shippable->id ?>"><?= $shippable->name ?></option>
        <?php endforeach; ?>

    <?php else: ?>
        <option value="<?= $order->baseUnit->id ?>"><?= $order->baseUnit->name ?></option>
    <?php endif; ?>

</select>