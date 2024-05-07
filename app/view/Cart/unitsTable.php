<?php if ($product->units->count()): ?>
    <?php foreach ($product->units as $unit): ?>

        <?php
        $u = $product->units->toArray();
        $formattedPrice     = $unit->pivot->multiplier
            ? number_format($product->price * $unit->pivot->multiplier, 2, '.', ' ')
            : $product->formattedPrice;
        $multipliedBaseUnit = $unit->pivot->multiplier
            ? "{$unit->name} ({$unit->pivot->multiplier} {$product->baseUnit->name})"
            : $product->baseUnit->name;

        ?>
        <div class="price">
            <?= $formattedPrice; ?>
            ₽
        </div>
        <div class="unit">/ <?= $multipliedBaseUnit; ?></div>

    <?php endforeach; ?>
<?php endif; ?>
