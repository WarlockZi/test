<select
		custom-select
	<?= $this->title; ?>
	<?= $this->class; ?>
	<?= $this->field; ?>
	<?= $this->model; ?>
>
	<!-- INITIAL OPTIONS-->
	<? if ($this->initialOption): ?>
	  <option
			  value="<?= $this->initialOptionValue; ?>">
			 <?= $this->initialOptionLabel; ?>
	  </option>
	<? endif; ?>

	<!-- OPTIONS -->
	<?= $this->isExcluded(); ?>

</select>


