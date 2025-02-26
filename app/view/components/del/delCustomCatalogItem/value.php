<div class="value"
	<? if (array_key_exists('html', $data)): ?>
>
	<?= $data['html']; ?>
	<? else: ?>
	  >
		<? $contenteditable = (isset($data['contenteditable']) && $data['contenteditable']) ? 'contenteditable' : ''; ?>
		<? $required = (isset($data['required']) && $data['required']) ? 'required' : ''; ?>

	  <div class="text"
			 <?= "data-field={$data['field']}"; ?>
			 <?= $contenteditable; ?>
			 <?= $required; ?>
	  >
			 <?= $this->item[$data['field']] ?>
	  </div>
	<? endif; ?>
</div>