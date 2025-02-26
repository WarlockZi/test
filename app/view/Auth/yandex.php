<? if (!$userData): ?>
    <h1>Нет данных</h1>
<?php else: ?>
    <img style="width: 100px"
         src="https://avatars.yandex.net/get-yapic/<?= $userData['default_avatar_id'] ?>/islands-50">
    <? foreach ($userData as $key => $data): ?>

        <p>
            <span><strong><?= $key; ?></strong></span>

            <span> <?=is_array($data)?implode(',', $data):$data;?></span>
        </p>

    <? endforeach; ?>
<? endif; ?>
