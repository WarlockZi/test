<? if (!$userData): ?>
    <h1>Нет данных</h1>
<?php else: ?>
    <? foreach ($userData as $key => $data): ?>

        <p>
            <span><strong><?= $key; ?></strong></span>
            <span> <?= $data; ?></span>
        </p>

    <? endforeach; ?>
<? endif; ?>
