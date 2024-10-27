<? if (!$userData): ?>
    <h1>Нет данных</h1>
<? endif; ?>
<? foreach ($userData as $key => $data): ?>

    <p>
        <span><?= $key; ?></span>
        <span> <?= $data; ?></span>
    </p>
    <?= $data; ?>

<? endforeach; ?>
