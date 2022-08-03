<div class="value"
	<? if ($data['html']): ?>
>
	<?= $data['html']; ?>
	<? else: ?>
	  >

	  <div class="text"
			 <?= "data-field={$data['field']}"; ?>
			 <?= "data-model={$this->model}"; ?>
			 <?= $data['contenteditable']; ?>
			 <?= $data['required']; ?>
	  >
			 <?= $this->item[$data['field']] ?>
	  </div>
	<? endif; ?>
</div>