<?= isset($cat['childs']) ? '<li class = "children">' : '<li>'?>
    <a href=
    <?= isset($cat['childs']) ? "#" : "/test/" . $cat['id'] ?>
       ><?= $cat['test_name'] ?>
    </a>
<? if (isset($cat['childs'])): ?>
    <ul>
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>


