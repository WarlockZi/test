<? use \app\Repository\QuestionRepository;
use \app\Repository\AnswerRepository; ?>
<div class="test-edit__title">
	<p class="test-name">Название теста - <?= $test['name'] ?></p>
</div>

<div class="questions" data-test-id="<?= $test['id'] ?>">

	<div class="empty">
		 <?= QuestionRepository::empty($test); ?>
		 <?= AnswerRepository::empty(1); ?>
	</div>

	<? if ($test['questions']): ?>
		<? foreach ($test['questions'] as $question): ?>
			<?= QuestionRepository::getQuestion($question, $parentSelector); ?>
		<? endforeach; ?>
	<? else: ?>
	  <h3>Вопросов нет</h3>
	<? endif; ?>

	<div class="question__create-button">
		+ Добавить вопрос
	</div>
</div>

