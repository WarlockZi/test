
<?= isset($cat['childs']) ? '<li class = "vert-menu__list">' : '<li>'; ?>

<a class="test-edit-menu__params"  href = "/adminsc/test/update/<?=$cat['id'];?>" data-testid="<?=$cat['id'];?>">

<?= include ROOT.'/app/view/components/icons/gamburger.php' ?>

</a>

<a class="test-edit-menu__test-name <?=$cat['isTest']?'test':''?>"
 href=
   <?= isset($cat['childs']) ? "#" : "/adminsc/test/edit/" . $cat['id'] ?>
><?= $cat['test_name'] ?>
</a>

<? if (isset($cat['childs'])): ?>
    <ul class="vert-menu__drop">
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>