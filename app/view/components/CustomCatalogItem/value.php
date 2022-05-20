<div class="value"
	<? if (array_key_exists('html', $data)): ?>
>
	<?= $data['html']; ?>
	<? else: ?>
	  >
	  <div class="text"
			 <?= "data-field={$data['field']}"; ?>
			 <?= $contenteditable; ?>
			 <?= $required; ?>
	  >
			 <?= $this->item[$data['field']] ?>
	  </div>
	<? endif; ?>
</div>