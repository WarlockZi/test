<?= isset($cat['childs']) ? '<li class = "vert-menu__list">' : '<li>'?>
    <a href=
    <?= isset($cat['childs']) ? "#" : "/test/" . $cat['id'] ?>
       ><?= $cat['test_name'] ?>
    </a>
<? if (isset($cat['childs'])): ?>
    <ul class = "vert-menu__drop">
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>


