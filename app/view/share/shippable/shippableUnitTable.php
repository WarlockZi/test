<div
        unit-row
        class="unit-row"
        data-unitId="<?= $unit->id; ?>"
        data-multiplier="<?= $multiplier; ?>"
        data-orderitem-id="<?= $orderItem->id ?? null; ?>"
>
    <input type="text" class="input" value="<?= $orderItem->count ?? 0; ?>" onclick="this.value??'';">

    <div class="unit-name">
        <span class="name"><?= $unit->name; ?></span>
        <?= $description; ?>

    </div>

    <div class="arrows">
        <div class="arrow plus"></div>
        <div class="arrow minus"></div>

    </div>

    <?= $totalRowSum; ?>

</div>

