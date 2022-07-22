<? ob_start(); ?>
<? if ($this->delCol == 'ajax'): ?>
	<div <?= $hidden ?? ''; ?>
			class="del"
			data-model="<?= $this->model->model; ?>"
			data-id="<?= $model['id']; ?>">
		 <? include TRASH; ?>
	</div>
<? elseif ($this->delCol == 'redirect'): ?>
	<div <?= $hidden ?? ''; ?>
			class="del"
			data-id="<?= $model['id']; ?>">
		<a href="/adminsc/<?= $this->model->model; ?>/delete/<?= $model['id']; ?>">
				<? include TRASH; ?>
		</a>
	</div>
<? endif; ?>
<? $del = ob_get_clean(); ?>

