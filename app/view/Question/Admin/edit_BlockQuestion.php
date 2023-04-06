<?php

use app\core\Icon;

?>
<div class="question-edit" data-id="<?= $question['id'] ?>">

	<div class="row">

		<div class="sort"><?= $question['sort'] ?? '' ?></div>

		<div class="question-edit__parent-select" data-tooltip="Переместить этот вопрос с ответами в другой тест">
				<?= $parentSelector; ?>
		</div>

		<div class="question__show-answers" data-tooltip="Показать ответы"></div>
		<div class="text" contenteditable="true">
				<?= $question['qustion'] ?? '' ?>
		</div>
		<div class="question__delete"
		     data-tooltip="Удалить Ответ с вопросами"
		     data-id= <?= $question['id'] ?>
		>
				<?= Icon::trashIcon(); ?>
		</div>
	</div>

	<div class="row">

		<div class="question__answers">
				<? if (isset($question->answers)): ?>
					<? foreach ($question->answers as $i => $a): ?>
						<? \app\Repository\AnswerRepository::getAnswer($i, $a); ?>
					<? endforeach; ?>
				<? endif; ?>

			<div class="answer__create-button"
			     data-tooltip="Добавить ответ">+
			</div>

		</div>


	</div>
	<!--	<div class='message'></div>-->
</div>
