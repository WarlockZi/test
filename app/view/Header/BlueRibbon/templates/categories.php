
<?php foreach ($front_categories as $category): ?>

    <div class='h-cat'><?= $category->name; ?>

        <a href="<?= $category->href; ?>" class='show-front-a'></a>

            <?= $child_categories[$category->name]; ?>

    </div>
<?php endforeach; ?>
