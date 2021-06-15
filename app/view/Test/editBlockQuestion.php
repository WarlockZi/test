<div class="block" id="question-<?= $q_id ?>">

	<div class="e-block-q " id=<?= $q_id ?>>
		<div class="left-sidebar">
			<textarea data-question-id="<?= $q_id ?>" cols="20" rows="5"
			          name="<?= $q_id ?>q"><?= $block[0]['question_text'] ?></textarea>
			<div class="block__top">
				<input class="sort-q" type="text" data-q-sort="<?= $q_id ?>" size="1" value="<?= $block[0]['sort'] ?>">
				<div class='error'></div>

			</div>
		</div>

		<div class="right-sidebar">
			<nav class="navi">
				<a class="navi__item a-add">Добавить ответ</a>
				<a class="navi__item q-delete">Удалить вопрос</a>
				<a class="navi__item img-delete">Удалить картинку</a>
			</nav>


			<div data-prefix="question" id="<?= $q_id ?>" class="holder">
				<? if ($block[0]['question_pic']): ?>
					<img src="/pic/<?= $block[0]['question_pic'] ?>">
				<? else: ?>
					<img src="/pic/srvc/nophoto-min.jpg">
				<? endif; ?>
			</div>

			<div class="field__wrapper">
				<input name="file" type="file" name="file" id="field__file-2" class="field field__file" multiple>
				<label class="field__file-wrapper" for="field__file-2">
					<div class="field__file-fake">Файл не выбран</div>
					<div class="field__file-button">Выбрать</div>
				</label>
			</div>


		</div>
	</div>

	<div class="answers">
		<? foreach ($block as $id => $answer): ?>
			<? if (isset($answer['answer_text'])): ?>
				<? require ROOT . '/app/view/Test/editBlockAnswer.php' ?>
			<? endif; ?>
		<? endforeach; ?>
	</div>

	<div class="question__buttons">
		<div class="question__save" data-qid= <?= $q_id ?>>Сохранить</div>
		<div class="question__cansel">Отмена</div>
	</div>

</div>
