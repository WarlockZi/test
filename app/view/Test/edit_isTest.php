<div class="test-edit__title">
	<p class="test-name">Название теста - <?= $test['name'] ?></p>
</div>

<div class="questions" data-test-id="<?= $test['id'] ?>">

	<div class="question__create">
		 <?= \app\Repository\QuestionRepository::empty($test); ?>
	</div>

	<div class="answer__create">
		 <?= \app\Repository\AnswerRepository::empty(1); ?>
	</div>

	<? if ($test['questions']): ?>
		<? foreach ($test['questions'] as $question): ?>
			<?= \app\Repository\QuestionRepository::getQuestion($question, $parentSelector); ?>
		<? endforeach; ?>
	<? else: ?>
	  <h3>Вопросов нет</h3>
	<? endif; ?>

	<div class="question__create-button">
		+ Добавить вопрос
	</div>
</div>

