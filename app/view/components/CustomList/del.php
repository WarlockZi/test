<? ob_start(); ?>
<? if ($this->delCol == 'ajax'): ?>
	<div <?= $hidden ?? ''; ?>
			class="del"
			data-model="<?= $this->modelName; ?>"
			data-id="<?= $model['id']; ?>">
		 <? include TRASH; ?>
	</div>
<? elseif ($this->delCol == 'redirect'): ?>
	<div <?= $hidden ?? ''; ?>
			class="del"
			data-id="<?= $model['id']; ?>">
		<a href="/adminsc/<?= $this->modelName; ?>/delete/<?= $model['id']; ?>">
				<? include TRASH; ?>
		</a>
	</div>
<? endif; ?>
<? $del = ob_get_clean(); ?>

