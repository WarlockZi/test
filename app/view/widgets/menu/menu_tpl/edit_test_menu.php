<?
$isTest = (bool)isset($cat['childs']);
$gamburger = include ROOT . '/app/view/components/icons/gamburger.php';
?>
<li <?= $isTest ? 'class="vert-menu__list"' : ''; ?>>

<a class="test-edit-menu__params <?=$isTest?'path':'test'?>"
   href="/adminsc/test/update/<?=$cat['id'];?>"
   data-testid="<?=$cat['id'];?>">
	<?= $gamburger ?>
</a>

<a class="test-edit-menu__test-name <?=$isTest?'path':'test'?>"
 href=<?= isset($cat['childs']) ? "#" : "/adminsc/test/edit/" . $cat['id'] ?>
>
	<?= $cat['test_name'] ?>
</a>

<? if ($isTest): ?>
    <ul class="vert-menu__drop">
        <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>

</li>


<!--<li --><?//= $isTest ?  'class = "vert-menu__list"':''; ?><!-- >-->
<!--	<a class="test-edit-menu__params" href="/adminsc/test/update/--><?//= $cat['id']; ?><!--"-->
<!--	   data-testid="--><?//= $cat['id']; ?><!--">-->
<!--		--><?//= $gamburger ?>
<!--	</a>-->
<!--	<a class="test-edit-menu__test-name --><?//= $isTest ? 'test' : 'path' ?><!--"-->
<!--	   href=-->
<!--		--><?//= $isTest ? "#" : "/adminsc/test/edit/" . $cat['id'] ?>
<!--	>--><?//= $cat['test_name'] ?>
<!--	</a>-->
<!--	--><?// if (!$isTest): ?>
<!--		<ul class="vert-menu__drop">-->
<!--			--><?//= $this->getMenuHtml($cat['childs']); ?>
<!--		</ul>-->
<!--	--><?// endif ?>
<!--</li>-->