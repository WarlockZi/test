<div
        unit-row
        class="unit-row"
        data-unitId="<?= $unit->id; ?>"
        data-multiplier="<?= $multiplier; ?>"
        data-orderitem-id="<?= $orderItemId; ?>"
>
    <input type="text" class="input" value="<?= $count; ?>" onclick="this.value??'';">

    <div class="unit-name">
        <span class="name"><?= $unit->name; ?></span>
        <?=$description;?>

    </div>

    <div class="arrows">
        <div class="arrow plus"></div>
        <div class="arrow minus"></div>

    </div>

    <?= $totalRowSum; ?>

</div>

