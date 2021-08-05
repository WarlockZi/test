<div class="question-edit" id="<?= $q_id ?>">
	<div class="question__text" contenteditable="true"><?= $block[0]['question_text'] ?></div>
	<div class="question__sort" contenteditable="true"><?= $block[0]['sort'] ?></div>
	<div class="question__image">
		<div class="field__wrapper">
			<input name="file" type="file" name="file" id="field__file-2" class="field field__file" multiple>
			<label class="field__file-wrapper" for="field__file-2">
				<div class="field__file-button">Выбрать</div>
				<div class="field__file-fake">Файл не выбран</div>
			</label>
		</div>
	</div>
	<div class="question__delete"></div>
</div>
<div class='qestion__error'></div>