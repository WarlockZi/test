<?$checked = (bool)$answer->correct_answer===false ? '' : 'checked' ;?>
<div class="answer" data-id=<?= $answer->id; ?>>

	<div class="sort"><?= ++$i; ?></div>
	<input type="checkbox"
	       class="correct" <?= $checked; ?>/>
	<div class="text" contenteditable="true"><?= $answer->answer; ?></div>
	<div class="delete">
		 <? include ICONS . '/trashIcon.svg'; ?>
	</div>

</div>

