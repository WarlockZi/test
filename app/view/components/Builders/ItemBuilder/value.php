<div class="value">
	  <div
			 <?= $field->id??''; ?>
			 <?= $field->getDatafield(); ?>
			 <?= $field->getDatarelation(); ?>
			 <?= $field->contenteditable; ?>
			 <?= $field->required; ?>
	  ><?= $field->value; ?></div>

</div>