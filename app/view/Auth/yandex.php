<? if (!$userData): ?>
    <h1>Нет данных</h1>
<?php else: ?>
    <? foreach ($userData as $key => $data): ?>

        <p>
            <span><strong><?= $key; ?></strong></span>
            <span> <?= $data; ?></span>
        </p>
        <a href="https://avatars.yandex.net/get-yapic/<?= $userData['default_avatar_id'] ?>/islands-50">
            avatar
        </a>


    <? endforeach; ?>
<? endif; ?>
