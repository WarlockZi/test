<div class="question-edit" id="<?= $question['id'] ?>">

	<div class="row">

		<div class="sort"><?= $question['sort'] ?? '' ?></div>

<!--		<div class="question__save"-->
<!--		     data-tooltip="Сохранить этот вопрос ответами">-->
<!--				--><?// include ICONS . '/save.svg' ?>
<!--		</div>-->

		<div class="question-edit__parent-select" data-tooltip="Переместить этот вопрос с ответами в другой тест">
				<?= \app\view\Test\TestView::isTestSelector($test['id']); ?>
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
