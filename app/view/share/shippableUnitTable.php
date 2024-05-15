<div class="shippable-table">

    <?=$blueButton??'';?>
    <?=$greenButton??'';?>
    <?php foreach ($oItem as $i => $item): ?>

        <div class="unit-row">
            <input type="number" value="<?= $item->count; ?>">

            <span class="shippable-unit"><?=$item->unit->name?></span>
            <span class="input-line"></span>

            <div class="arrow-block ">
                <span class="arrow plus"></span>
                <span class="arrow minus"></span>
            </div>

        </div>

    <?php endforeach; ?>
</div>
