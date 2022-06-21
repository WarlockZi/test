<div class="answer" data-answer-id=<?= $a['id']; ?>>

	<div class="sort"><?= $i++; ?></div>
	<input type="checkbox"
	       class="correct" <?= isset($a['correct_answer']) ? $a['correct_answer'] ? 'checked' : '' : ''; ?>/>
	<div class="text" contenteditable="true">
		 <?= $a['answer']; ?>
	</div>
	<div class="delete"
	     data-model="answer"
	     data-id= <?= $a['id']; ?>>
		 <? include ICONS . '/trashIcon.svg'; ?>
	</div>

</div>

