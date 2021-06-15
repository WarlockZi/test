<div class="e-block-a" id="<?= $id ?>">
	<div class="left-sidebar">

		<textarea data-answer-id="<?= $id ?>" cols="20" rows="5"
		          name="<?= $id ?>"><?= $answer['answer_text'] ?? '' ?></textarea>
		<div class="check_right_answer">
			<input id="right_answer<?= $id ?>" type="checkbox" class="checkbox"
			       data-answer="<?= $id; ?>"
				<?= $answer['correct_answer'] == 1 ? "checked" : "" ?>/>
			<label for="right_answer<?= $id ?>">Верный ответ</label>
		</div>

	</div>
	<div class="right-sidebar">
		<nav class="navi">
			<p class="navi__item a-del" >Удалить ответ</p>
			<p class="navi__item a-del" >Удалить картинку</p>
		</nav>

		<div data-prefix="answer" id="<?= $id ?>" class="holder">
			<?$src = (isset($answer['answer_pic'])&&$answer['answer_pic']) ? $answer['answer_pic'] : "srvc/nophoto-min.jpg";?>
			<img src="/pic/<?=$src;?>" >

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
