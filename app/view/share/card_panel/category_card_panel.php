<div class="card-panel">

    <div class="short-link"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $category->shortLink; ?>
    >
        <?= \app\core\Icon::link(); ?>
    </div>
    <?php if ($userIsAdmin): ?>
        <a href="/adminsc/category/edit/<?= $category->id ?>" class="edit"><?= $edit ?></a>
    <? endif; ?>
</div>
