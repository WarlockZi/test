<div class="test-edit__content">
	<? if ($test): ?>
		<? if (isset($test['isTest']) && $test['isTest']): ?>
			<div class="test-edit__title">
				<? if (isset($test)): ?>
					<p class="test-name"
					   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?>
					</p>
				<? endif; ?>
			</div>

			<div class="questions">

				<div class="question__create">
					<?$question__create = true;?>
					<? include ROOT . '/app/view/Test/editBlockQuestion.php' ?>
					<?$question__create = false;?>
				</div>

				<div class="answer__create">
					<? include ROOT . '/app/view/Test/editBlockAnswer.php' ?>
				</div>

				<? if ($testDataToEdit): ?>
					<? foreach ($testDataToEdit as $q_id => $block): ?>
						<? include ROOT . '/app/view/Test/editBlockQuestion.php' ?>
					<? endforeach; ?>
				<? endif; ?>
				<div class="question__create-button" data-action-hover="Добавить вопрос">Добавить вопрос</div>
			</div>


		<? else: ?>
			<div class="test-edit__title">
				<? if (isset($test)): ?>
					<p class="test-name"
					   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?>
					</p>
				<? endif; ?>
			</div>
			<?= include ROOT . '/app/view/Test/test-edit-children.php' ?>

		<? endif; ?>
	<? else: ?>

		<h1>Выберите другой тест</h1>

	<? endif; ?>

</div>
