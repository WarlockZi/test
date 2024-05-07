<select id="shippableSelector">

    <?php if ($product->shippableUnits->count()): ?>
        <?php foreach ($product->shippableUnits as $shippable): ?>
            <option value="<?= $shippable->id ?>"><?= $shippable->name ?></option>
        <?php endforeach; ?>

    <?php else: ?>
        <option value="<?= $product->baseUnit->id ?>"><?= $product->baseUnit->name ?></option>
    <?php endif; ?>

</select>