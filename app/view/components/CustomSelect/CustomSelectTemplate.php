<select
  custom-select
  <?= isset($this->field)?"data-field='{$this->field}'":''; ?>
  <?=$this->class?"class={$this->class}":'';?>
  <?=$this->title?"title='{$this->title}'":'';?>
>
<!-- INITIAL VALUE-->
	<? if (isset($this->initialOptionLabel)): ?>
	  <option
			  value="<?= $this->initialOptionValue; ?>"
			 <?=!$this->selected?'selected':'';?>
	  ><?= $this->initialOptionLabel; ?></option>
	<? endif; ?>

	<!-- VALUES -->
	<? foreach ($this->tree as $k => $v): ?>

	  <option value="<?= $v['id']??$k; ?>"
	  <?=(int)$this->selected==$k?'selected':'';?>>
			 <?= is_string($v)?$v:$v[$this->optionName]; ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $this->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


