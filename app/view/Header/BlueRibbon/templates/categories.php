<?php foreach ($categories as $category): ?>
    <a
            href="/catalog/<?= $category['slug']; ?>"
            class='show-front-a'
    >
        <div class='h-cat'><?= $category['name']; ?>
            <ul>
                <?php foreach ($category['children_not_deleted'] as $item): ?>
                    <li>
                        <a href="/catalog/<?= $item['slug'] ?>"><?= $item['name'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </a>
<?php endforeach; ?>
