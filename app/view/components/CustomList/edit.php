<? if ($this->editCol): ?>
	<a
		href="/adminsc/<?=$this->modelName;?>
		/edit/<?=$model['id'];?>"
		class="edit"
		 data-id="<?= $model['id']; ?>"
	>

			<? include EDIT; ?>

	</a>
<? endif; ?>