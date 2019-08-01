<?= isset($cat['childs']) ? '<li class = "vert-menu__list">' : '<li>'?>
    <a href=
    <?= isset($cat['childs']) ? "#" : "/?category=" . $cat['id'] ?>
       ><?= $cat['name'] ?>
    </a>
<? if (isset($cat['childs'])): ?>
    <ul class = "vert-menu__drop">
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>