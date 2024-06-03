<?= $selector ?>

<?= $multiplier;?>

<div class="base-unit"><?= $name ?></div>

<div class="shippable">
    <input type="checkbox" <?= $shippable; ?>>
</div>

<?php if ($deletable): ?>
    <div class="del" data-delete>X</div>
<?php else: ?>
    <div class="del"></div>
<?php endif ?>
