<?php

use app\Services\AuthService\Auth;

?>
<div class="card-panel">

    <div class="short-link card-panel-item"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $product->shortLink; ?>
    >
        <?= \app\view\Icon::link(); ?>
    </div>

    <div class="compare card-panel-item <?= $product->compare ? 'green' : '' ?>"
         data-compare="false"
         title='Добавить в сравнение'
    >
        <?= \app\view\Icon::chart(); ?>
    </div>

    <div class="like card-panel-item <?= $product->like ? 'red' : '' ?>"
         data-like="false"
         title='Добавить в избранное'
    >
        <?= \app\view\Icon::heart(); ?>
    </div>
    <?php if (Auth::getUser()?->isAdmin()): ?>
        <a href="/adminsc/product/edit/<?= $product->id ?>"
           class="edit card-panel-item"><?= \app\view\Icon::edit(); ?></a>
    <? endif; ?>
</div>
