<div class="test-edit__content">


	<? include ROOT . '/app/view/Test/test-head.php'; ?>
	<? if ($test): ?>

		<!--		--><? // include COMPONENTS."/test/menu_toggle.php";?>

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
					<? $question__create = true; ?>
					<? include ROOT . '/app/view/Test/edit_BlockQuestion.php' ?>
					<? $question__create = false;
					$i = 1; ?>
				</div>

				<div class="answer__create">

					<? include ROOT . '/app/view/Test/edit_BlockAnswer.php' ?>
				</div>

				<? if ($testDataToEdit): ?>
					<? foreach ($testDataToEdit as $q_id => $block): ?>
						<? include ROOT . '/app/view/Test/edit_BlockQuestion.php' ?>
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
			<? include ROOT . '/app/view/Test/edit_children.php' ?>
		<? endif; ?>


		<? include COMPONENTS . "/test/test_edit_rules.php"; ?>

	<? else: ?>

		<!--		--><? // include COMPONENTS."/test/menu_toggle.php";?>

	<? endif; ?>

</div>
