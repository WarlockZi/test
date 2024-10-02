<?php foreach ($categories as $category): ?>

    <div class='h-cat'><?= $category['name']; ?>

        <a href="<?= $category['href']; ?>" class='show-front-a'></a>

        <ul>
            <?php foreach ($category['children_not_deleted'] as $item): ?>
                <li>
                    <a href="<?= $category['href'] ?>"><?= $item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
<?php endforeach; ?>
