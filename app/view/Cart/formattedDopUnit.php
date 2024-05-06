<div class="price">
    <?php
    $multiplier = $unit->pivot->multiplier;
    echo number_format($product->price * $multiplier, 2, '.', ' ');
    ?>
    ₽
</div>
<div class="unit">/ <?= "{$unit->name} ($multiplier {$product->baseUnit->name})"; ?></div>
