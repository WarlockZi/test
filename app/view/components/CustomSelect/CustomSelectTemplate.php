<select
  custom-select
  data-field="<?= $this->field; ?>"
  <?=$this->title?"title='{$this->title}'":'';?>
  <?=$this->className?"class={$this->className}":'';?>
>

	<? if ($this->initialOption): ?>
	  <option value=""><?= $this->initialOptionValue; ?></option>
	<? endif; ?>

	<? foreach ($this->tree as $k => $v): ?>

	  <option value="<?= $v['id']??$k; ?>"
	  <?=(int)$this->selected==$k?'selected':'';?>>
			 <?= $v[$this->fieldName]??$v ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $this->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


