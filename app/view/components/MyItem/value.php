<div class="value"
	<? if ($data['html']): ?>
>
	<?= $data['html']; ?>
	<? else: ?>
	  >

	  <div class="text"
			 <?= "data-field={$data['field']}"; ?>
			 <?= $data['contenteditable']; ?>
			 <?= $data['required']; ?>
	  >
			 <?= $this->item[$data['field']] ?>
	  </div>
	<? endif; ?>
</div>