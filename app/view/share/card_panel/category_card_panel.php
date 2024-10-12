<?php

use app\core\Auth;
use app\core\Icon;

?>
<div class="card-panel">

    <div class="short-link"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $category->shortLink; ?>
    >
        <?= \app\core\Icon::link(); ?>
    </div>
    <?php if (Auth::userIsAdmin()): ?>
        <a href="/adminsc/category/edit/<?= $category->id ?>" class="edit"><?=Icon::edit(); ?></a>
    <? endif; ?>
</div>
