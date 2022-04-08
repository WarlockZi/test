<div class="question-edit" id="<?= $q_id ?? '' ?>">

	<div class="question-edit_row">
		<div class="question__sort"><?= $block[0]['sort'] ?? '' ?></div>
		<div class="question__save"
		     data-tooltip="Сохранить этот вопрос ответами">
		  <? include ICONS . '/save.svg' ?>
		</div>

		<!--		<div class="question__menu">-->
		<div class="question-edit__parent-select" data-tooltip="Переместить этот вопрос с ответами в другой тест">
			<select>
					 <?= include ROOT . '/app/view/Test/edit_question-parent.php'; ?>
			</select>
		</div>
		<!--		</div>-->

		<div class="question__show-answers"
		     data-tooltip="Показать ответы">
		</div>
		<div class="question__text" contenteditable="true">
				<?= $block[0]['question_text'] ?? '' ?>
		</div>
		<div class="question__delete"
		     data-tooltip="Удалить">
		  <? include TRASH; ?>
		</div>
	</div>

	<div class="question-edit_row">

		<div class="question__answers">
				<? if (!$question__create): ?>

					<? if (isset($block)): ?>

						<? $i = 1;
						foreach ($block as $index => $a): ?>
							<? if ($index): ?>
								<? include ROOT . "/app/view/Test/edit_BlockAnswer.php"; ?>
							<? endif; ?>
						<? endforeach; ?>
					<? endif; ?>


				<? endif; ?>
			<div class="answer__create-button">Добавить ответ</div>

		</div>


	</div>
	<div class='qestion__error'></div>
</div>
