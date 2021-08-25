<div class="test-edit__content">
	<div class="test-edit__title">
		<? if (isset($test)): ?>
			<p class="test-name"
			   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?>
			</p>
		<? endif; ?>
	</div>

	<div class="questions">

		<div class="question__create">
			<? include ROOT . '/app/view/Test/editBlockQuestion.php' ?>
		</div>

		<div class="answer__create">
			<? include ROOT . '/app/view/Test/editBlockAnswer.php' ?>
		</div>

		<? foreach ($testDataToEdit as $q_id => $block): ?>
			<? include ROOT . '/app/view/Test/editBlockQuestion.php' ?>
		<? endforeach; ?>

		<div class="question__create-button" data-action-hover="Добавить вопрос">+</div>

	</div>

</div>
