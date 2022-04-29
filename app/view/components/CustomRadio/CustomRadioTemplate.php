<div
		custom-radio
		data-field="<?= $this->field; ?>"
		data-value="<?=$this->selected ;?>"
	<?= $this->title ? "title='{$this->title}'" : ''; ?>
	<?= $this->className ? "class={$this->className}" : ''; ?>
>

	<? foreach ($this->tree as $k => $v): ?>
	  <label for="sex-<?= $k ?>"
	         data-value="<?= $k ?>"><?= $v ?>
		  <input name="sex"

		         id="sex-<?= $k ?>"
		         <?=$this->selected === $k?'checked':'';?>
		         type="radio">
	  </label>

	<? endforeach; ?>


</div>


