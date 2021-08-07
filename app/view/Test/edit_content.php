<div class="test-edit__content">
	<div class="test-edit__title">
		<? if (isset($test)): ?>
			<p class="test-name"
			   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?></p>
			<div class="test_delete" data-hover="showTip" data-click="delete"
			     tip="удалить тест : <?= $test['test_name'] ?>">
				<?= include ROOT . '/app/view/components/icons/trashIcon.php' ?>
			</div>
		<? endif; ?>

	</div>
	<?= $pagination ?? '' ?>

	<div class="blocks">
			<? foreach ($testDataToEdit as $q_id => $block): ?>
				<? require ROOT . '/app/view/Test/editBlockQuestion.php' ?>
			<? endforeach; ?>
	</div>
</div>
