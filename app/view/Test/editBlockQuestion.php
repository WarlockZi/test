<div class="block" id="question-<?= $q_id ?> draggable">

	<div class="e-block-q " id="<?= $q_id ?>q">
		<div class="left-sidebar">
			<input class="sort-q" type="text" data-q-sort="<?= $q_id ?>" size="1" value="<?= $block[0]['sort'] ?>">
			<textarea data-question-id="<?= $q_id ?>" cols="20" rows="5"
			          name="<?= $q_id ?>q"><?= $block[0]['question_text'] ?></textarea>
		</div>

		<div class="right-sidebar">
			<nav class="navi">
				<a class="navi__item add-answer" data-id="<?= $q_id ?>"> Добавить ответ </a>
			</nav>


			<div data-prefix="q" id="<?= $q_id ?>" class="holder">
				<p>Перетащить картинку</p>
				<p id="upload" class="hidden">
				<div class="field__wrapper">
					<input name="file" type="file" name="file" id="field__file-2" class="field field__file" multiple>
					<label class="field__file-wrapper" for="field__file-2">
						<div class="field__file-fake">Файл не выбран</div>
						<div class="field__file-button">Выбрать</div>
					</label>
				</div>

				<?= isset($block[0]['question_pic']) ? $block[0]['question_pic'] : "" ?>
				<div class="pic-del" data-q= <?= $q_id ?>> X</div>
			</div>


		</div>
	</div>
	<label for="<?="show_".$q_id?>" class="answers_show">Показать ответы</label>
	<input id="<?="show_".$q_id?>" data-toggle type="checkbox" >


	<div class="answers">
		<? foreach ($block as $id => $answer): ?>
			<? if (isset($answer['answer_text'])): ?>
				<? require ROOT . '/app/view/Test/editBlockAnswer.php' ?>
			<? endif; ?>
		<? endforeach; ?>
	</div>


</div>
