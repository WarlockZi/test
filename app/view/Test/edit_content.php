<div class="test-edit__content">

	<? $test = $test ?? ''; ?>
	<? if ($test): ?>

		<? $isTest = $test['isTest'] ?? ''; ?>
		<? if ($isTest): ?>
		  <div class="test-edit__title">

			  <p class="test-name">Название теста - <?= $test['name'] ?></p>

		  </div>

		  <div class="questions" data-test-id="<?= $test['id'] ?>">

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
			  <div class="question__create-button"
			  >
				  + Добавить вопрос
			  </div>
		  </div>


		<? else: ?>
		  <div class="test-edit__title">
					<? if (isset($test)): ?>
				 <p class="test-name"
				    value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['name'] ?>
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
