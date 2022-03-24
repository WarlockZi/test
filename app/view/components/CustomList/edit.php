<? if ($this->editCol == 'ajax'): ?>
	<div class="edit" data-id="<?= $model['id']; ?>">
		<div data-id="<?= $model['id']; ?>">
			<? include EDIT; ?>
		</div>
	</div>
<? elseif ($this->editCol == 'redirect'): ?>
	<div class="edit" data-id="<?= $model['id']; ?>">
		<a href="/adminsc/<?= $this->modelName; ?>/edit/<?= $model['id']; ?>">
			<? include EDIT; ?>
		</a>
	</div>
<? endif; ?>