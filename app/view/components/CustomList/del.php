<? if ($this->delCol == 'ajax'): ?>
	<div class="del" data-model="<?= $this->modelName; ?>" data-id="<?= $model['id']; ?>">
			<? include TRASH; ?>
	</div>
<? elseif ($this->delCol == 'redirect'): ?>
	<div class="del" data-id="<?= $model['id']; ?>">
		<a href="/adminsc/<?= $this->modelName; ?>/delete/<?= $model['id']; ?>">
			<? include TRASH; ?>
		</a>
	</div>
<? endif; ?>

