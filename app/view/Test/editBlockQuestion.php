<div class="question-edit" id="<?= $q_id ?? '' ?>">

	<div class="question-edit_row">
		<div class="question__sort"><?= $block[0]['sort'] ?? '' ?></div>
		<div class="question__save"><?= include ROOT . '/app/view/components/icons/save.php' ?></div>
		<div class="question__text" contenteditable="true">
			<?= $block[0]['question_text'] ?? '' ?>
		</div>
		<div class="question__delete"><?= include ROOT . '/app/view/components/icons/trashIcon.php'; ?></div>
	</div>

	<div class="question-edit_row">

		<div class="question__answers">
			<? if (!$question__create): ?>

				<? if (isset($block)): ?>

					<? $i = 1;
					foreach ($block as $index => $a): ?>
						<? if ($index): ?>
							<? include ROOT . "/app/view/Test/editBlockAnswer.php"; ?>
						<? endif; ?>
					<? endforeach; ?>
				<? endif; ?>


			<? endif; ?>
			<div class="answer__create-button">+</div>

		</div>


	</div>
	<div class='qestion__error'></div>
</div>
