<?php

use app\core\Auth;

?>
<div class="card-panel">

    <div class="short-link"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $product->shortLink; ?>
    >
        <?= \app\core\Icon::link(); ?>
    </div>
    <?php if (Auth::userIsAdmin()): ?>
        <a href="/adminsc/product/edit/<?= $product->id ?>" class="edit"><?= \app\core\Icon::edit(); ?></a>
    <? endif; ?>
</div>
