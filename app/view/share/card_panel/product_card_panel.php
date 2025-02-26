<?php

use app\core\Auth;

?>
<div class="card-panel">

    <div class="short-link card-panel-item"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $product->shortLink; ?>
    >
        <?= \app\core\Icon::link(); ?>
    </div>

    <div class="compare card-panel-item <?=$product->compare?'green':''?>"
         data-compare="false"
         title='Добавить в сравнение'
    >
        <?= \app\core\Icon::chart(); ?>
    </div>

    <div class="like card-panel-item <?=$product->like?'red':''?>"
         data-like="false"
         title='Добавить в избранное'
    >
        <?= \app\core\Icon::heart(); ?>
    </div>
    <?php if (Auth::getUser()?->isAdmin()): ?>
        <a href="/adminsc/product/edit/<?= $product->id ?>" class="edit card-panel-item"><?= \app\core\Icon::edit(); ?></a>
    <? endif; ?>
</div>
