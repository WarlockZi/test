<select
		custom-select
	<?= isset($this->field) ? "data-field='{$this->field}'" : ''; ?>
	<?= $this->class ? "class={$this->class}" : ''; ?>
	<?= $this->title ? "title='{$this->title}'" : ''; ?>
>
	<!-- INITIAL VALUE-->
	<? if (isset($this->initialOptionLabel)): ?>
	  <option
			  value="<?= $this->initialOptionValue; ?>"
			 <?= !$this->selected ? 'selected' : ''; ?>
	  ><?= $this->initialOptionLabel; ?></option>
	<? endif; ?>

	<!-- VALUES -->
		<?= $this->values(); ?>


</select>


