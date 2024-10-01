<?php foreach ($categories as $category): ?>

    <div class='h-cat'><?= $category['name']; ?>

        <a href="/catalog/<?= $category['slug']; ?>" class='show-front-a'></a>

        <ul>
            <?php foreach ($category['children_not_deleted'] as $item): ?>
                <li>
                    <a href="/catalog/<?= $item['slug'] ?>"><?= $item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
<?php endforeach; ?>
