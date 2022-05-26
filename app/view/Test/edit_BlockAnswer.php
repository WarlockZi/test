<div class="answer" data-answer-id=<?= $index??''; ?> >

<div class="sort"><?= $i??$i; $i++; ?></div>
<input type="checkbox" class="correct" <?= isset($a['correct_answer'])?$a['correct_answer'] ? 'checked' : '':''; ?>>
<div class="text" contenteditable="true">
	<?= isset($a)?$a['answer_text']:''; ?>
</div>
<div class="delete"><? include ICONS . '/trashIcon.svg'; ?></div>

</div>

