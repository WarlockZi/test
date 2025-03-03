<?php //if ($order->units->count()): ?>
<!--    --><?php //foreach ($order->units as $unit): ?>
<!---->
<!--        --><?php
//        $u = $order->units->toArray();
//        $formattedPrice     = $unit->pivot->multiplier
//            ? number_format($order->price * $unit->pivot->multiplier, 2, '.', ' ')
//            : $order->formattedPrice;
//        $multipliedBaseUnit = $unit->pivot->multiplier
//            ? "{$unit->name} ({$unit->pivot->multiplier} {$order->baseUnit->name})"
//            : $order->baseUnit->name;
//
//        ?>
<!--        <div class="price">-->
<!--            --><?php //= $formattedPrice; ?>
<!--            ₽-->
<!--        </div>-->
<!--        <div class="unit">/ --><?php //= $multipliedBaseUnit; ?><!--</div>-->
<!---->
<!--    --><?php //endforeach; ?>
<?php //endif; ?>
