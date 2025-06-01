<?php

use app\service\AuthService\Auth;
use app\view\Icon;

?>
<? if ($forBreadcrumbs): ?>
    <div class="card-panel">
        <?php if (Auth::userIsAdmin()): ?>
            <a href="/adminsc/category/edit/<?= $category->id ?>" class="edit card-panel-item"><?= Icon::edit(); ?></a>
        <? endif; ?>
    </div>
<?php else: ?>
    <div class="card-panel">

        <div class="short-link card-panel-item"
             title='Скопировать короткую ссылку'
             data-shortLink= <?= $category->shortLink; ?>
        >
            <?= \app\view\Icon::link(); ?>
        </div>
        <?php if (Auth::userIsAdmin()): ?>
            <a href="/adminsc/category/edit/<?= $category->id ?>" class="edit card-panel-item"><?= Icon::edit(); ?></a>
        <? endif; ?>
    </div>
<? endif; ?>

