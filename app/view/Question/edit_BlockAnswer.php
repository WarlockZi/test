<?$checked = (bool)$a['correct_answer']===false ? '' : 'checked' ;?>
<div class="answer" data-id=<?= $a['id']; ?>>

	<div class="sort"><?= ++$i; ?></div>
	<input type="checkbox"
	       class="correct" <?= $checked; ?>/>
	<div class="text" contenteditable="true"><?= $a['answer']; ?></div>
	<div class="delete"
	     data-model="answer"
	     data-id= <?= $a['id']; ?>>
		 <? include ICONS . '/trashIcon.svg'; ?>
	</div>

</div>

