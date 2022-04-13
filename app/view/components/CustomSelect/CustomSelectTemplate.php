<select
  custom-select
  data-field="<?= $model->field; ?>"
  <?=$model->title?"title='{$model->title}'":'';?>
  <?=$model->className?"class={$model->className}":'';?>
>

	<? if ($model->initialOption): ?>
	  <option value=""><?= $model->initialOptionValue; ?></option>
	<? endif; ?>

	<? foreach ($model->tree as $k => $v): ?>

	  <option value="<?= $v['id']??$k; ?>"
	  <?=(int)$model->selected==$k?'selected':'';?>>
			 <?= $v[$model->fieldName]??$v ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $model->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


