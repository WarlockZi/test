<? if (!$userData): ?>
    <h1>Нет данных</h1>
<? endif; ?>
<? foreach ($userData as $key => $data): ?>

    <?= $key; ?>
    <?= $data; ?>

<? endforeach; ?>
