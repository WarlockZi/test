<div class="test-edit-wrapper">

	<div class='test-edit-menu'>
		<a class='add-test' href="/adminsc/test/show">Добавить тест</a>

		<?
		new app\view\widgets\menu\Menu([
			'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
			'cache' => 60,
		]);
		?>

	</div>

	<div class="content">
		<div class="title">
			<? if (isset($test)): ?>
				<p class="test-name" value="<?= $_REQUEST['id']??$test['id'] ?>"><?= $_REQUEST['name']??$test['test_name'] ?></p>
			<div class="test_delete" data-hover="showTip" data-click="delete"
			     tip="удалить тест : <?= $test['test_name'] ?>">
				<?= include ROOT . '/app/view/components/icons/trashIcon.php' ?>
			</div>
			<? endif; ?>

		</div>
		<?= $pagination ?? '' ?>

		<div class="blocks">
			<? if (isset($testDataToEdit)): ?>
				<? foreach ($testDataToEdit as $q_id => $block): ?>
					<? require ROOT . '/app/view/Test/editBlockQuestion.php' ?>
				<? endforeach; ?>
			<? endif; ?>
		</div>

</div>