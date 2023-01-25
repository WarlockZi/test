<div class="value">

	<? if ($field->html): ?>

		<?= $field->html; ?>

	<? else: ?>
	  <div
			 <?= $field->datafield; ?>
			 <?= $field->contenteditable; ?>
			 <?= $field->required; ?>
	  ><?= $field->value; ?></div>
	<? endif; ?>

</div>