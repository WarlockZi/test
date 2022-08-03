<select
		custom-select
	<?= isset($this->field) ? "data-field='{$this->field}'" : ''; ?>
	<?= $this->class ? "class={$this->class}" : ''; ?>
	<?= $this->title ? "title='{$this->title}'" : ''; ?>
>
	<!-- INITIAL OPTIONS-->
	<? if ($this->initialOption): ?>
	  <option
			  value="<?= $this->initialOptionValue; ?>"
	  ><?= $this->initialOptionLabel; ?></option>
	<? endif; ?>

	<!-- OPTIONS -->
	<?= $this->options(); ?>

</select>


