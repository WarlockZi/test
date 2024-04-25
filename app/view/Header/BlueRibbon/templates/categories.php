<? foreach ($categories as $category): ?>
    <div class='h-cat'><?= $category['name']; ?>
        <ul>
            <? foreach ($category['children_not_deleted'] as $item): ?>
                <li>
                    <a href="/category/<?= $item['slug'] ?>"><?= $item['name'] ?></a>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
<? endforeach; ?>
