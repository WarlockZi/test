<select
		custom-select
	<?= $this->title; ?>
	<?= $this->class; ?>
	<?= $this->field; ?>
	<?= $this->model; ?>
>
	<?= $this->initialOption; ?>

	<? if ($this->tree): ?>
		<?= $this->getTree2($this->tree); ?>
	<? else: ?>
		<?= $this->getArray(); ?>
	<? endif; ?>
</select>


