<div class="value">

<!--	--><?// if ($field->html): ?>
<!--		--><?//= $field->html; ?>
<!--	--><?// else: ?>
<!--	--><?// endif; ?>

	  <div
			 <?= $field->datafield; ?>
			 <?= $field->contenteditable; ?>
			 <?= $field->required; ?>
	  ><?= $field->value; ?></div>

</div>