<div
        class="unit-row"
        data-unitId="<?= $unit->id; ?>"
        data-multiplier="<?= $multiplier; ?>"
>
    <input type="text" class="input" value="<?= $count; ?>" onclick="this.value??'';">

    <div class="unit-name">
        <span class="name"><?= $unit->name; ?></span>
        <?=$description;?>

    </div>

    <div class="arrows">
        <div class="arrow plus"><?= \app\core\Icon::arrowUp() ?></div>
        <div class="arrow minus"><?= \app\core\Icon::arrowUp() ?></div>

    </div>

    <?= $totalRowSum; ?>

</div>

