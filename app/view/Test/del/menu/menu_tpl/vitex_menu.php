<?= isset($cat['childs']) ? '<li class = "sub">' : '<li>'?>
    <a href=
    <?= "/adminsc/catalog/category?id=". $cat['id'] ?>
       ><?= $cat['name'] ?>
    </a>
<? if (isset($cat['childs'])): ?>
    <ul>
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>