<? ob_start(); ?>
<? if ($this->editCol): ?>
	<a <?= $hidden ?? ''; ?>
			href="/adminsc/<?= $this->model->model; ?>/edit/<?= $model['id']; ?>"
			class="edit"
			data-id="<?= $model['id']; ?>"
	>

<!--		 --><?// include EDIT; ?>

	</a>
<? endif; ?>
<? $edit = ob_get_clean(); ?>
