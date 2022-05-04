<div class="answer" data-answer-id=<?= $index??''; ?> >

<div class="answer__sort"><?= $i??$i; $i++; ?></div>
<input type="checkbox" class="answer__correct" <?= isset($a['correct_answer'])?$a['correct_answer'] ? 'checked' : '':''; ?>>
<div class="answer__text" contenteditable="true">
	<?= isset($a)?$a['answer_text']:''; ?>
</div>
<div class="answer__delete"><? include ICONS . '/trashIcon.svg'; ?></div>

</div>

