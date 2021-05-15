<div class="e-block-a" id="<?= $id ?>">
	<div class="left-sidebar">

		<textarea data-answer-id="<?= $id ?>" cols="20" rows="2"
		          name="<?= $id ?>"><?= $answer['answer_text'] ?></textarea>
		<div class="check_right_answer">
			<input id="right_answer<?= $id ?>" type="checkbox" class="checkbox none"
			       data-answer="<?= $id ?>" <?= $answer['answer_correct'] == 1 ? "checked" : "" ?>>
			<label for="right_answer<?= $id ?>">Верный ответ</label>
		</div>

	</div>
	<div class="right-sidebar">
		<nav class="navi">
			<p id="d_a" class="navi__item" onClick="edit('delete_a',<?= $a_id ?>)">Удалить ответ</p>
		</nav>

		<div data-prefix="a" id='<?= $id ?>' class="holder">
			<p>Перетащить картинку</p>
			<p id="upload" class="hidden"></p>

			<div class="field__wrapper">
				<input name="file" type="file" name="file" id="field__file-2" class="field field__file" multiple>
				<label class="field__file-wrapper" for="field__file-2">
					<div class="field__file-fake">Файл не выбран</div>
					<div class="field__file-button">Выбрать</div>
				</label>
			</div>


			<!--<p><progress class="hidden" id="uploadprogress" max="100" value="0">0</progress></p>-->
			<? !isset($answer['answer_pic']) ? "" : '<img id = "ima' . $id . '"   src= /pic/' . $answer['answer_pic'] . '   data-id = ' . $answer['answer_pic'] . "'>"; ?>
			<div class="pic-del" data-a="<?= $id ?>"> X</div>
		</div>

	</div>
</div>
