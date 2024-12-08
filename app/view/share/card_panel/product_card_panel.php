<?php

use app\core\Auth;

?>
<div class="card-panel">

    <div class="short-link"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $order->shortLink; ?>
    >
        <?= \app\core\Icon::link(); ?>
    </div>
    <?php if (Auth::getUser()?->isAdmin()): ?>
        <a href="/adminsc/product/edit/<?= $order->id ?>" class="edit"><?= \app\core\Icon::edit(); ?></a>
    <? endif; ?>
</div>
