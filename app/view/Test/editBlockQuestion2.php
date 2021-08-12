<? if (!isset($qestion__create)): ?>
	<div class="question__create">Добавить  вопрос</div>
<? endif; ?>
<? $qestion__create = 1 ?>

<div class="question-edit" id="<?= $q_id ?>">

	<div class="question-edit_row">
		<div class="question__sort" contenteditable="true"><?= $block[0]['sort'] ?></div>
		<div class="question__text" contenteditable="true">
			<?= $block[0]['question_text'] ?>
		</div>
		<div class="question__delete"><?= include ROOT . '/app/view/components/icons/trashIcon.php'; ?></div>
	</div>

	<div class="question-edit_row">

		<div class="question__answers">

			<? $i = 0;
			foreach ($block as $index => $a): ?>
				<? if ($index): ?>

					<div class="answer">
						<div class="answer__number"><?= ++$i ?></div>
						<input type="checkbox" class="answer__correct" <?= $a['correct_answer'] ? 'checked' : '' ?>>
						<div class="answer__text" contenteditable="true">
							<?= $a['answer_text'] ?>
						</div>
						<div class="answer__delete"><?= include ROOT . '/app/view/components/icons/trashIcon.php'; ?></div>

					</div>
				<? endif; ?>

			<? endforeach; ?>


				<div class="answer__create-button">+</div>
				<div class="answer__create">
					<div class="answer__number">№</div>
					<input type="checkbox" class="answer__correct">
					<div class="answer__text" contenteditable="true"></div>
					<div class="answer__delete"><?= include ROOT . '/app/view/components/icons/trashIcon.php'; ?></div>

				</div>
		</div>


	</div>

	<div class="question-edit_row">
		<div class="question__save">Сохранить</div>
	</div>

</div>
<div class='qestion__error'></div>