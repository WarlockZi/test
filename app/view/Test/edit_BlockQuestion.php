<div class="question-edit" data-id="<?= $question['id'] ?>">

	<div class="row">

		<div class="sort"><?= $question['sort'] ?? '' ?></div>


		<div class="question-edit__parent-select" data-tooltip="Переместить этот вопрос с ответами в другой тест">
				<?= \app\view\Test\TestView::questionParentSelector($test['id']); ?>
		</div>

		<div class="question__show-answers"
		     data-tooltip="Показать ответы">
		</div>
		<div class="text" contenteditable="true">
				<?= $question['qustion'] ?? '' ?>
		</div>
		<div class="question__delete"
		     data-tooltip="Удалить Ответ с вопросами"
		     data-model = 'question'
		     data-id = <?=$question['id']?>
		>
				<? include TRASH; ?>
		</div>
	</div>

	<div class="row">

		<div class="question__answers">
				<? if (isset($question['Answer'])): ?>
						<? $i = 1;
						foreach ($question['Answer'] as $index => $a): ?>
								<? include ROOT . "/app/view/Test/edit_BlockAnswer.php"; ?>
						<? endforeach; ?>
				<? endif; ?>

			<div class="answer__create-button"
			     data-tooltip="Добавить ответ">+
			</div>

		</div>


	</div>
	<div class='message'></div>
</div>
