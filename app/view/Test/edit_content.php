<div class="test-edit__content">

	<? if (isset($test)): ?>

		<? if ($test['isTest']): ?>
		  <div class="test-edit__title">
			  <p class="test-name">Название теста - <?= $test['name'] ?></p>
		  </div>

		  <div class="questions" data-test-id="<?= $test['id'] ?>">

			  <div class="question__create">
						 <? $question = new \app\model\Question(); ?>
						 <? $question = $question->empty(); ?>
						 <? $question['id'] = 0; ?>
						 <? include ROOT . '/app/view/Test/edit_BlockQuestion.php' ?>
						 <? $i = 1; ?>
			  </div>

			  <div class="answer__create">
						 <? $a = new \app\model\Answer(); ?>
						 <? $a = $a->empty(); ?>
						 <? $a['id'] = 0; ?>
						 <? include ROOT . '/app/view/Test/edit_BlockAnswer.php' ?>
			  </div>

					<? if ($questions): ?>
						<? foreach ($questions as $q_id => $question): ?>
							<? include ROOT . '/app/view/Test/edit_BlockQuestion.php' ?>
						<? endforeach; ?>
					<? else: ?>
				 <h3>Вопросов нет</h3>
					<? endif; ?>

			  <div class="question__create-button">
				  + Добавить вопрос
			  </div>
		  </div>


		<? else: ?>
			<? include ROOT . '/app/view/Test/edit_children.php' ?>
		<? endif; ?>

		<? include COMPONENTS . "/test/test_edit_rules.php"; ?>

	<? else: ?>

	  <h3>Выберите тест</h3>

	<? endif; ?>

</div>
