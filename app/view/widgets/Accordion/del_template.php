<ul class="cd-accordion-menu">
	<? $isPath = (bool)isset($cat['childs']);
	$gamburger = include ROOT . '/app/view/components/icons/gamburger.php'; ?>

	<li <?= $isPath ? 'class="has-children"' : ''; ?>>
		<input type="checkbox" name="group-1" id="group-1" checked>
		<label for="group-1">Group 1</label>
		<a class="test-edit-menu__params <?= $isPath ? 'path' : 'test' ?>"
		   href="/adminsc/test/update/<?= $cat['id']; ?>"
		   data-testid="<?= $cat['id']; ?>">
			<?= $gamburger ?>
		</a>
		<a class="test-edit-menu__test-name <?= $isPath ? 'path' : 'test' ?>"
		   href=<?= isset($cat['childs']) ? "#" : "/adminsc/test/edit/" . $cat['id'] ?>
		>
			<?= $cat['test_name'] ?>
		</a>
		<? if ($isPath): ?>
			<ul class="vert-menu__drop">
				<?= $this->getMenuHtml($cat['childs']); ?>
			</ul>
		<? endif ?>
	</li>
</ul>

<!--<li class="has-children">-->
<!--	<input type="checkbox" name="group-1" id="group-1" checked>-->
<!--	<label for="group-1">Group 1</label>-->
<!---->
<!--	<ul>-->
<!--		<li class="has-children">-->
<!--			<input type="checkbox" name="sub-group-1" id="sub-group-1">-->
<!--			<label for="sub-group-1">Sub Group 1</label>-->
<!---->
<!--			<ul>-->
<!--				<li><a href="#0">Image</a></li>-->
<!--			</ul>-->
<!--		</li>-->
<!--		<li><a href="#0">Image</a></li>-->
<!--	</ul>-->
<!--</li>-->

