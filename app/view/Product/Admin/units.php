<?php

use \app\view\Product\ProductArrayFormView;
use app\core\Icon;

?>
<div class="units">

    <div class="column">
        <div class="title">Единицы</div>

        <div class="head">
            <div class="name">Единица</div>
            <div class="multiplier">Коэфф</div>
            <div class="base-unit">Базовая ед.</div>
            <div class="min-unit" title="Можем отгрузить клиенту эту единицу">Отгруж ед.</div>
            <div class="del"><?= Icon::trashIcon() ?></div>
        </div>

        <div class="rows">
            <div class="none">
                <?= $selector; ?>
            </div>


            <div class="row">
                <?= ProductArrayFormView::unitsRow($baseUnit); ?>
            </div>

            <?php foreach ($units as $unit): ?>
                <?php if (!$unit->pivot->is_base): ?>
                    <div class="row">
                        <?= ProductArrayFormView::unitsRow($unit) ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="add-unit"
             data-unit="<?= $baseUnit->id ?>"
        >
            +
        </div>


    </div>
</div>
