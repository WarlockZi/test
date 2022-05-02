<div>
	<input
			custom-date
			data-field="<?= $this->field; ?>"
		 <?= $this->className ? "class='{$this->className}'" : ""; ?>
		 <?= $this->title ? "title='{$this->title}'" : ''; ?>
			min=<?=$this->min??"1965-01-01"?>
			max=<?=$this->max??"2030-01-01"?>
			value=<?=date('Y-m-d',strtotime($this->value))??"2000-01-01"?>
			type="date"
	>

</div>
