<div
		custom-radio
		data-field="<?= $this->field; ?>"
	<?= $this->title ? "title='{$this->title}'" : ''; ?>
	<?= $this->className ? "class={$this->className}" : ''; ?>
>

	<? foreach ($this->tree as $k => $v): ?>
	  <label for="sex-<?= $k ?>"><?= $v ?>
		  <input name="sex"
		         id="sex-<?= $k ?>"
		         <?=$this->selected === $k?'checked':'';?>
		         type="radio">
	  </label>

	<? endforeach; ?>


</div>


