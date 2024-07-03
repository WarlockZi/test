<div class="card-panel">

    <div class="short-link"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $product->shortLink; ?>
    >
        <?= \app\core\Icon::link(); ?>
    </div>

    <a href="/adminsc/product/edit/<?= $product->id ?>" class="edit"><?= $edit ?></a>

</div>
