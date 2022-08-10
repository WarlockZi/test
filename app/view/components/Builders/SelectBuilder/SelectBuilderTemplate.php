<select
		custom-select
	<?= $this->title; ?>
	<?= $this->class; ?>
	<?= $this->field; ?>
	<?= $this->model; ?>
>
	<?= $this->initialOption; ?>

	<? if ($this->tree): ?>
		<?= $this->getTree($this->tree); ?>
	<? else: ?>
		<?= $this->getArray(); ?>
	<? endif; ?>
</select>


