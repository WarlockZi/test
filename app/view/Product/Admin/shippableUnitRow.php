<div class="default-price">

    <div class='price-for-unit'><?= $formattedPrice; ?></div>
    <span>₽ /</span>
    <div class='unit'>
        <span class="unit-name"><?= $unit->name ?></span>
        <span> (<?= $unit->pivot->multiplier ?? 1; ?><?= $product->baseUnit->name; ?>)</span>
    </div>
</div>

<? if ($promotion && ($promotion->unit_id === $unit->id)): ?>


    <div class="promotion-price red mb-5">
        <div class=" price-for-unit new-price"><?= $promotionNewPrice ?></div>
            <span>₽ /  от</span>

            <div class="unit">

                <span class="unit-name"><?= $promotion->count; ?></span>
                <span><?= $unit->name ?></span>
            </div>

    </div>


<? endif; ?>


