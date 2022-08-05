<div class="value">

	<? if ($field['html']): ?>
		<?= $field['html']; ?>

	<? else: ?>

	  <div class="text"
			 <?= $this->model; ?>
			 <?= $field['datafield']; ?>
			 <?= $field['contenteditable']; ?>
			 <?= $field['required']; ?>
	  >
			 <?= $this->item[$field['field']] ?>
	  </div>

	<? endif; ?>
</div>