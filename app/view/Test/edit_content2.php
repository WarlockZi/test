<div class="test-edit__content-2 flex1">
	<div class="test-edit__title">
		<? if (isset($test)): ?>
			<p class="test-name"
			   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?>
			</p>
		<? endif; ?>
	</div>

	<div class="questions">
		<? foreach ($testDataToEdit as $q_id => $block): ?>
			<? require ROOT . '/app/view/Test/editBlockQuestion2.php' ?>
		<? endforeach; ?>
	</div>
</div>
