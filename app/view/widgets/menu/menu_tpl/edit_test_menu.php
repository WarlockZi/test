
<?= isset($cat['childs']) ? '<li class = "vert-menu__list">' : '<li>'; ?>

<div class="test-params" data-testid="{$cat['id']}">

<?= include ROOT.'/app/view/components/icons/gamburger.php' ?>
<?//= isset($cat['childs']) ? '' : include ROOT.'/app/view/components/icons/gamburger.php' ?>

</div>

<a href=
   <?= isset($cat['childs']) ? "#" : "/adminsc/test/edit/" . $cat['id'] ?>
><?= $cat['test_name'] ?>
</a>
<? if (isset($cat['childs'])): ?>
    <ul class="vert-menu__drop">
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>