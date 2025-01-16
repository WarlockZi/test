<?php

use app\core\Auth;
use app\core\Icon;

?>
<? if ($forBreadcrumbs): ?>
    <div class="card-panel">
        <?php if (Auth::getUser()?->isAdmin()): ?>
            <a href="/adminsc/category/edit/<?= $category->id ?>" class="edit card-panel-item"><?=Icon::edit(); ?></a>
        <? endif; ?>
    </div>
<?php else:?>
    <div class="card-panel">

        <div class="short-link card-panel-item"
             title='Скопировать короткую ссылку'
             data-shortLink= <?= $category->shortLink; ?>
        >
            <?= \app\core\Icon::link(); ?>
        </div>
        <?php if (Auth::getUser()?->isAdmin()): ?>
            <a href="/adminsc/category/edit/<?= $category->id ?>" class="edit card-panel-item"><?=Icon::edit(); ?></a>
        <? endif; ?>
    </div>
<? endif; ?>

