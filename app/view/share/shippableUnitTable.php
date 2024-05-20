

    <div
            class="unit-row"
            data-unitId="<?= $item->id; ?>"
            data-multiplier="<?= $item->pivot->multiplier ?? 1; ?>"
    >
        <input type="text" class="input" value="<?= $orderItemCount; ?>" onclick="this.value??'';
">

        <div class="unit-name">
            <span class="name"><?= $item->name; ?></span>
            <span class="description">(<?= $item->pivot->multiplier; ?>&nbsp;<?= $baseUnitName; ?> - <?= $rowSum; ?>)
        </span>
        </div>

        <div class="arrows">
            <div class="arrow plus"><?= \app\core\Icon::arrowUp() ?></div>
            <div class="arrow minus"><?= \app\core\Icon::arrowUp() ?></div>
        </div>

        <? if ($rowSum): ?>
            <div class="sub-sum">0</div>
        <? endif; ?>

    </div>

